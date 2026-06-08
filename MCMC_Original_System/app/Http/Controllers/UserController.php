<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use App\Models\PublicUser;
use App\Models\Agency;
use App\Models\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgencyController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Show registration form
     */
    public function showRegistrationForm(): View
    {
        return view('publicUser.registerPage');
    }

    /**
     * Show login form
     */
    public function showLoginForm(): View
    {
        return view('home.loginPage');
    }

    /**
     * Register a new user (general)
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|unique:public_users,UserEmail',
            'UserPassword' => 'required|min:8|confirmed',
            'UserPhoneNum' => 'nullable|string|max:20',
        ]);

        PublicUser::create([
            'UserName' => $request->UserName,
            'UserEmail' => $request->UserEmail,
            'UserPassword' => Hash::make($request->UserPassword),
            'UserPhoneNum' => $request->UserPhoneNum,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
    public function login(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'login' => 'required|string',
                'password' => 'required',
            ],
            [
                'login.required' => 'Email or Username field is required.',
            ]
        );

        $loginInput = $request->input('login');
        $password = $request->input('password');

        // Try admin login first
        $adminController = new AdminController();
        $adminResult = $adminController->attemptLogin($loginInput, $password);
        if ($adminResult !== false) {
            return $adminResult;
        }

        // Try agency login with proper password handling
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        $agency = null;

        if ($isEmail) {
            $agency = Agency::where('AgencyEmail', $loginInput)->first();
        } else {
            $agency = Agency::where('AgencyUserName', $loginInput)->first();
        }

        if ($agency) {
            // Check if password matches using the agency's checkPassword method
            $passwordMatch = $agency->checkPassword($password);

            if ($passwordMatch) {
                // Check if agency has phone number
                if (empty($agency->AgencyPhoneNum) || is_null($agency->AgencyPhoneNum)) {
                    // Store agency ID in session for phone verification
                    session(['phone_verification_agency_id' => $agency->AgencyID]);

                    return redirect()->route('password.recovery')
                        ->with('phone_required', 'Please add your phone number and reset your password to complete account setup.');
                }

                // Store agency data in session
                session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);
                // Mark login as successful to clear form on return
                session()->flash('login_successful', true);
                return redirect()->route('agency.home');
            }
        }

        // Finally, try public user login
        $column = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'UserEmail' : 'UserName';
        $user = PublicUser::where($column, $loginInput)->first();

        if (!$user) {
            return Redirect::back()
                ->withErrors(['login' => 'No account found with this email or username.']);
        }

        if (!Hash::check($request->input('password'), $user->UserPassword)) {
            return Redirect::back()
                ->withErrors(['password' => 'The password is incorrect.']);
        }

        Auth::login($user);

        // Store the current page in session for potential back button functionality
        Session::put('previous_url', URL::previous());
        // Mark login as successful to clear form on return
        session()->flash('login_successful', true);

        return redirect()->route('public.user.home');
    }

    /**
     * Update agency phone number and password during setup
     */
    public function updateAgencyPhoneAndPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]).{8,}$/'
            ],
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        // Get agency ID from session
        $agencyId = session('phone_verification_agency_id');

        if (!$agencyId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $agency = Agency::find($agencyId);

        if (!$agency) {
            return redirect()->route('login')->with('error', 'Agency not found.');
        }

        try {
            // Validate password hash length before saving
            $hashedPassword = Hash::make($request->password);

            if (strlen($hashedPassword) > 255) {
                Log::error('Hashed password too long: ' . strlen($hashedPassword) . ' characters');
                return Redirect::back()->withErrors(['password' => 'Password processing error. Please try a different password.']);
            }

            // Update phone and password with proper hashing
            $agency->AgencyPhoneNum = $request->phone;
            $agency->AgencyPassword = $hashedPassword;
            $agency->save();

            // Clear the verification session
            session()->forget('phone_verification_agency_id');

            // Log the agency in
            session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);

            Log::info("Agency {$agency->AgencyID} completed account setup successfully");
            return redirect()->route('agency.home')->with('success', 'Account setup completed successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error during agency setup: ' . $e->getMessage());
            if (strpos($e->getMessage(), 'String data, right truncated') !== false) {
                return Redirect::back()->withErrors(['password' => 'Password is too long for database storage. Please contact support.']);
            }
            return Redirect::back()->withErrors(['phone' => 'Database error. Please try again.']);
        } catch (\Exception $e) {
            Log::error('Agency phone/password update error: ' . $e->getMessage());
            return Redirect::back()->withErrors(['phone' => 'Failed to update account. Please try again.']);
        }
    }

    public function verifyPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        $user = Auth::user();
        if (!$user) {
            return Redirect::back()->with('error', 'User not authenticated.');
        }

        if (Hash::check($request->current_password, $user->UserPassword)) {
            session(['password_verified' => true]);
            return redirect()->back();
        } else {
            return Redirect::back()->with('error', 'Current password is incorrect.');
        }
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        /** @var PublicUser $user */
        $user = Auth::user();
        $user->UserPassword = Hash::make($request->new_password);
        $user->save();

        session()->forget('password_verified');
        return Redirect::back()->with('status', 'Password updated successfully!');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login', ['clear' => '1']);
    }


    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'UserName' => 'required|string|max:255',
            'UserEmail' => 'required|email|max:255|unique:public_users,UserEmail,' . Auth::id() . ',UserID',
            'UserPhoneNum' => 'nullable|string|max:15',
            'UserProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /** @var PublicUser $user */
        $user = Auth::user();

        // Update name, email, and phone number
        $user->UserName = $request->UserName;
        $user->UserEmail = $request->UserEmail;
        $user->UserPhoneNum = $request->UserPhoneNum;

        // Handle profile picture upload
        if ($request->hasFile('UserProfilePicture')) {
            // Delete old profile picture if it exists
            if ($user->UserProfilePicture) {
                Storage::disk('public')->delete($user->UserProfilePicture);
            }
            // Store new profile picture in the 'public' disk
            $path = $request->file('UserProfilePicture')->store('profile_pictures', 'public');
            $user->UserProfilePicture = $path;
        }

        $user->save();

        return Redirect::back()->with('status', 'Profile updated successfully!');
    }
}
