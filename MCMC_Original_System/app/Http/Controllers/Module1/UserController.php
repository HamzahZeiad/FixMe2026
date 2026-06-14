<?php

namespace App\Http\Controllers\Module1;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use App\Models\Module1\Administrator as Module1Administrator;
use App\Models\Module1\PublicUsers as Module1PublicUsers;
use App\Models\Module1\Agency as Module1Agency;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show login form - Module1
     */
    public function showLoginForm(): View
    {
        return view('home.loginPage');
    }

    /**
     * Handle login - Module1
     */
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

        // Try admin login first using Module1 Administrator model
        $adminResult = $this->attemptAdminLogin($loginInput, $password);
        if ($adminResult !== false) {
            return $adminResult;
        }

        // Try agency login with proper password handling using Module1 Agency model
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        $agency = null;

        if ($isEmail) {
            $agency = Module1Agency::where('AgencyEmail', $loginInput)->first();
        } else {
            $agency = Module1Agency::where('AgencyUserName', $loginInput)->first();
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

        // Finally, try public user login using Module1 PublicUsers model
        $column = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'UserEmail' : 'UserName';
        $user = Module1PublicUsers::where($column, $loginInput)->first();

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
    }    /**
     * Attempt admin login - Module1
     */
    private function attemptAdminLogin($loginInput, $password)
    {
        // Check if login input is email or username
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            $admin = Module1Administrator::where('AdminEmail', $loginInput)->first();
        } else {
            $admin = Module1Administrator::where('AdminUserName', $loginInput)->first();
        }

        if ($admin && Hash::check($password, $admin->AdminPassword)) {
            session(['admin_id' => $admin->AdminID, 'admin_name' => $admin->AdminName]);
            // Mark login as successful to clear form on return
            session()->flash('login_successful', true);
            return redirect()->route('admin.home');
        }

        return false;
    }

    /**
     * Show password recovery form - Module1
     */
    public function showRecoveryForm(): View
    {
        return view('home.recovaryPasswordPage');
    }

    /**
     * Send password reset link - Module1
     */
    public function sendResetLink(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        try {
            // Check if email exists in Module1 PublicUsers table first
            $user = Module1PublicUsers::where('UserEmail', $request->email)->first();
            $userType = 'public';

            // If not found in Module1 PublicUsers, check Module1 Administrator table
            if (!$user) {
                $user = Module1Administrator::where('AdminEmail', $request->email)->first();
                $userType = 'admin';
            }

            // If still not found, check Module1 Agency table
            if (!$user) {
                $user = Module1Agency::where('AgencyEmail', $request->email)->first();
                $userType = 'agency';
            }

            if (!$user) {
                // Check if this is an AJAX request
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'We could not find a user with that email address.'
                    ], 404);
                }
                return Redirect::back()->withErrors(['email' => 'We could not find a user with that email address.']);
            }

            // Store the verified email in the session and mark as verified
            session([
                'email_verified' => true,
                'reset_email' => $request->email,
                'user_type' => $userType
            ]);

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email verified successfully. You can now reset your password.'
                ]);
            }

            // Return to the same page, which will now show the reset form
            return Redirect::back();
        } catch (\Exception $e) {
            Log::error('Password verification error: ' . $e->getMessage());

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email verification failed. Please try again later.'
                ], 500);
            }
            return Redirect::back()->withErrors(['email' => 'Email verification failed. Please try again later.']);
        }
    }

    /**
     * Reset password - Module1
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            // Get user type from session
            $userType = session('user_type');

            // If no user type in session, determine it from the email
            if (!$userType) {
                // Check Module1 PublicUsers first
                if (Module1PublicUsers::where('UserEmail', $request->email)->exists()) {
                    $userType = 'public';
                } elseif (Module1Administrator::where('AdminEmail', $request->email)->exists()) {
                    $userType = 'admin';
                } elseif (Module1Agency::where('AgencyEmail', $request->email)->exists()) {
                    $userType = 'agency';
                } else {
                    $userType = 'public'; // default fallback
                }
            }

            if ($userType === 'admin') {
                // Check Module1 Administrator table
                $user = Module1Administrator::where('AdminEmail', $request->email)->first();

                if ($user) {
                    // Use Module1 Administrator's updatePassword method
                    $user->updatePassword(Hash::make($request->password));
                    Log::info("Admin password reset successful for admin ID: {$user->AdminID}");
                }
            } elseif ($userType === 'agency') {
                // Check Module1 Agency table
                $user = Module1Agency::where('AgencyEmail', $request->email)->first();

                if ($user) {
                    // Use Module1 Agency's updatePassword method
                    $user->updatePassword(Hash::make($request->password));
                    Log::info("Agency password reset successful for agency ID: {$user->AgencyID}");
                }
            } else {
                // Check Module1 PublicUsers table (default)
                $user = Module1PublicUsers::where('UserEmail', $request->email)->first();

                if ($user) {
                    // Use Module1 PublicUsers's updatePassword method
                    $user->updatePassword(Hash::make($request->password));
                    Log::info("Public user password reset successful for user ID: {$user->UserID}");
                }
            }

            if (!$user) {
                return Redirect::back()
                    ->withErrors(['email' => 'We could not find a user with that email address.'])
                    ->withInput($request->only('email'));
            }

            // Clear the session
            session()->forget(['email_verified', 'reset_email', 'user_type']);

            return redirect()->route('login')->with('status', 'Your password has been reset successfully!');
        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return Redirect::back()
                ->withErrors(['email' => 'Password reset failed. Please try again later.'])
                ->withInput($request->only('email'));
        }
    }

    /**
     * Show registration form - Module1
     */
    public function showRegistrationForm(): View
    {
        return view('Module1.publicUser.registerPage');
    }

    /**
     * Register a new user - Module1
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|unique:public_users,UserEmail',
            'UserPassword' => 'required|min:8|confirmed',
        ]);

        Module1PublicUsers::create([
            'UserName' => $request->UserName,
            'UserEmail' => $request->UserEmail,
            'UserPassword' => Hash::make($request->UserPassword),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    /**
     * Show manage profile page - Module1
     */
    public function showManageProfile(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('Module1.publicUser.manageProfilePage');
    }

    /**
     * Show edit password page - Module1
     */
    public function showEditPassword(): View|RedirectResponse
    {
        return view('Module1.publicUser.editPasswordPage');
    }

    /**
     * Cancel password reset - Module1
     */
    public function cancelPasswordReset(): RedirectResponse
    {
        session()->forget(['email_verified', 'reset_email', 'user_type']);
        return redirect()->route('module1.password.recovery');
    }

    /**
     * Handle logout - Module1
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login', ['clear' => '1']);
    }

    /**
     * Update agency phone number and password during setup - Module1
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

        $agency = Module1Agency::find($agencyId);

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

    /**
     * Update user profile - Module1
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|unique:public_users,UserEmail,' . $user->UserID . ',UserID',
            'UserPhone' => 'nullable|string|max:20',
            'UserAddress' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Update basic user information
            $user->UserName = $request->UserName;
            $user->UserEmail = $request->UserEmail;

            if ($request->filled('UserPhone')) {
                $user->UserPhone = $request->UserPhone;
            }

            if ($request->filled('UserAddress')) {
                $user->UserAddress = $request->UserAddress;
            }

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old profile image if exists
                if (isset($user->ProfileImage) && $user->ProfileImage && Storage::exists('public/' . $user->ProfileImage)) {
                    Storage::delete('public/' . $user->ProfileImage);
                }

                // Store new profile image
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $user->ProfileImage = $imagePath;
            }

            $user->save();

            Log::info("User profile updated successfully for user ID: {$user->UserID}");

            return Redirect::back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            Log::error('Profile update error for user ID ' . ($user->UserID ?? 'unknown') . ': ' . $e->getMessage());
            return Redirect::back()
                ->withErrors(['error' => 'Failed to update profile. Please try again.'])
                ->withInput($request->except('profile_image'));
        }
    }
}
