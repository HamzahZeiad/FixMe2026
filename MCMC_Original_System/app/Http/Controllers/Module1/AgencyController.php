<?php

namespace App\Http\Controllers\Module1;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\Module1\Agency as Module1Agency;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AgencyController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show agency profile page - Module1
     */
    public function showProfile(): View|RedirectResponse
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Module1Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        return view('Module1.agency.manageProfilePage', compact('agency'));
    }

    /**
     * Update agency profile - Module1
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        // Validate input
        $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyUserName' => 'required|string|max:50',
            'AgencyEmail' => 'required|email',
            'AgencyPhoneNum' => 'nullable|string|max:15',
            'AgencyProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get agency from session
        $agencyId = session('agency_id');
        if (!$agencyId) {
            return redirect()->route('login');
        }

        // Get agency data
        $agency = Module1Agency::find($agencyId);
        if (!$agency) {
            return redirect()->route('login');
        }

        // Check for unique constraints
        $existingAgencyUsername = Module1Agency::where('AgencyUserName', $request->AgencyUserName)
            ->where('AgencyID', '!=', $agencyId)
            ->first();

        if ($existingAgencyUsername) {
            return Redirect::back()->withErrors(['AgencyUserName' => 'This username is already taken.'])->withInput();
        }

        $existingAgencyEmail = Module1Agency::where('AgencyEmail', $request->AgencyEmail)
            ->where('AgencyID', '!=', $agencyId)
            ->first();

        if ($existingAgencyEmail) {
            return Redirect::back()->withErrors(['AgencyEmail' => 'This email is already taken.'])->withInput();
        }

        // Prepare update data
        $updateData = [
            'AgencyName' => $request->AgencyName,
            'AgencyUserName' => $request->AgencyUserName,
            'AgencyEmail' => $request->AgencyEmail,
            'AgencyPhoneNum' => $request->AgencyPhoneNum ?? '',
        ];

        // Handle profile picture upload
        if ($request->hasFile('AgencyProfilePicture')) {
            // Delete old profile picture if it exists
            if ($agency->AgencyProfilePicture) {
                Storage::disk('public')->delete($agency->AgencyProfilePicture);
            }

            // Store new profile picture
            $path = $request->file('AgencyProfilePicture')->store('agency_profile_pictures', 'public');
            $updateData['AgencyProfilePicture'] = $path;
        }

        // Update agency profile
        $agency->updateProfile($updateData);

        return redirect()->route('module1.agency.profile')
            ->with('status', 'Profile updated successfully!');
    }

    /**
     * Show agency security/password management page - Module1
     */
    public function showSecurity(): View|RedirectResponse
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Module1Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        return view('Module1.agency.editPasswordPage', compact('agency'));
    }

    /**
     * Verify current password for password change - Module1
     */
    public function verifyPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        $agency = Module1Agency::find(session('agency_id'));

        if (!$agency) {
            return redirect()->route('login');
        }

        if ($agency->validateCurrentPassword($request->current_password)) {
            session(['agency_password_verified' => true]);
            return redirect()->back();
        } else {
            return Redirect::back()->with('error', 'Current password is incorrect.');
        }
    }

    /**
     * Update agency password - Module1
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $agency = Module1Agency::find(session('agency_id'));

        if (!$agency) {
            return redirect()->route('login');
        }

        $agency->updatePassword(Hash::make($request->new_password));

        session()->forget('agency_password_verified');
        return Redirect::back()->with('status', 'Password updated successfully!');
    }

    /**
     * Reset password verification session - Module1
     */
    public function resetPasswordVerification(): RedirectResponse
    {
        session()->forget('agency_password_verified');
        return redirect()->route('module1.agency.security');
    }

    /**
     * Show agency home dashboard - Module1
     */
    public function showHome(): View|RedirectResponse
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Module1Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get inquiry status counts for the agency
        $statusCounts = [
            'total' => Inquiry::where('AgencyID', $agency->AgencyID)->count(),
            'under_investigation' => Inquiry::where('AgencyID', $agency->AgencyID)
                                          ->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => Inquiry::where('AgencyID', $agency->AgencyID)
                                    ->where('InquiryStatus', 'Verified True')->count(),
            'identified_fake' => Inquiry::where('AgencyID', $agency->AgencyID)
                                       ->where('InquiryStatus', 'Identified Fake')->count(),
        ];

        return view('agency.agencyHome', compact('agency', 'statusCounts'));
    }
}
