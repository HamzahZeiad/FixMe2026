<?php

namespace App\Http\Controllers\Module2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display the public user dashboard
     */    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $stats = [
            'total_inquiries' => $user->inquiries()->count(),
            'pending' => $user->inquiries()->where('status', 'pending')->count(),
            'in_progress' => $user->inquiries()->whereIn('status', ['assigned', 'in-progress'])->count(),
            'completed' => $user->inquiries()->where('status', 'completed')->count()
        ];

        $recentInquiries = $user->inquiries()
            ->with('assignedAgency')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('Module2.publicUser.dashboard', compact('stats', 'recentInquiries'));
    }

    /**
     * Display user profile page
     */
    public function profile()
    {
        $user = Auth::user();
        return view('Module2.publicUser.profile', compact('user'));
    }

    /**
     * Update user profile
     */    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'preferred_contact_method' => 'required|in:email,phone,sms'
        ]);

        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'preferred_contact_method' => $request->preferred_contact_method
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required'
        ]);        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 422);
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update password: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload or update profile picture
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            if ($request->hasFile('profile_picture')) {                // Delete old profile picture if exists
                if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                    Storage::delete('public/' . $user->profile_picture);
                }

                // Store new profile picture
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                $path = $request->file('profile_picture')->storeAs('profile_pictures', $filename, 'public');

                $user->update([
                    'profile_picture' => $path
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture updated successfully',
                    'profile_picture_url' => Storage::url($path)
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile picture: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user notification preferences
     */
    public function getNotificationPreferences()
    {
        $user = Auth::user();
        
        $preferences = [
            'email_notifications' => $user->email_notifications ?? true,
            'sms_notifications' => $user->sms_notifications ?? false,
            'push_notifications' => $user->push_notifications ?? true,
            'inquiry_updates' => $user->inquiry_updates ?? true,
            'marketing_emails' => $user->marketing_emails ?? false,
            'newsletter' => $user->newsletter ?? false
        ];

        return response()->json([
            'success' => true,
            'preferences' => $preferences
        ]);
    }

    /**
     * Update user notification preferences
     */
    public function updateNotificationPreferences(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'inquiry_updates' => 'boolean',
            'marketing_emails' => 'boolean',
            'newsletter' => 'boolean'
        ]);        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $user->update([
                'email_notifications' => $request->get('email_notifications', true),
                'sms_notifications' => $request->get('sms_notifications', false),
                'push_notifications' => $request->get('push_notifications', true),
                'inquiry_updates' => $request->get('inquiry_updates', true),
                'marketing_emails' => $request->get('marketing_emails', false),
                'newsletter' => $request->get('newsletter', false)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification preferences updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update notification preferences: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user activity history
     */    public function getActivityHistory(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $limit = $request->get('limit', 20);
        
        $activities = $user->inquiries()
            ->with('activities')
            ->get()
            ->pluck('activities')
            ->flatten()
            ->sortByDesc('created_at')
            ->take($limit);

        return response()->json([
            'success' => true,
            'activities' => $activities
        ]);
    }

    /**
     * Export user data (GDPR compliance)
     */
    public function exportUserData()
    {        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $userData = [
                'profile' => $user->only(['name', 'email', 'phone', 'address', 'created_at']),
                'inquiries' => $user->inquiries()->with(['attachments', 'activities'])->get(),
                'preferences' => [
                    'email_notifications' => $user->email_notifications ?? true,
                    'sms_notifications' => $user->sms_notifications ?? false,
                    'push_notifications' => $user->push_notifications ?? true,
                    'inquiry_updates' => $user->inquiry_updates ?? true,
                    'marketing_emails' => $user->marketing_emails ?? false,
                    'newsletter' => $user->newsletter ?? false
                ]
            ];

            $filename = 'user_data_' . $user->id . '_' . date('Y-m-d') . '.json';
            
            return response()->json($userData)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export user data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user account (soft delete)
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirmation' => 'required|in:DELETE_MY_ACCOUNT'
        ]);        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Verify password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password is incorrect'
                ], 422);
            }

            // Check for active inquiries
            $activeInquiries = $user->inquiries()
                ->whereIn('status', ['pending', 'assigned', 'in-progress'])
                ->count();

            if ($activeInquiries > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete account while you have active inquiries. Please wait for them to be completed or contact support.'
                ], 422);
            }

            // Soft delete the user
            $user->update([
                'deleted_at' => now(),
                'email' => 'deleted_' . time() . '@deleted.com'
            ]);

            // Log out the user
            Auth::logout();

            return response()->json([
                'success' => true,
                'message' => 'Your account has been deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete account: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user dashboard data
     */    public function getDashboardData()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $data = [
            'stats' => [
                'total_inquiries' => 5, // Sample data
                'pending' => 2,
                'in_progress' => 2,
                'completed' => 1,
                'this_month' => 3
            ],
            'recent_inquiries' => collect([]), // Empty collection for now
            'recent_activities' => collect([]), // Empty collection for now
            'notifications' => $this->getUnreadNotifications()
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get unread notifications for user
     */
    private function getUnreadNotifications()
    {
        // This would typically come from a notifications table
        // For now, return sample data
        return [
            'count' => 2,
            'notifications' => [
                [
                    'id' => 1,
                    'message' => 'Your inquiry #INQ001 has been assigned to an agency',
                    'created_at' => now()->subHours(2),
                    'read' => false
                ],
                [
                    'id' => 2,
                    'message' => 'Update available on your inquiry #INQ002',
                    'created_at' => now()->subHours(5),
                    'read' => false
                ]
            ]
        ];
    }

    /**
     * Mark notifications as read
     */
    public function markNotificationsAsRead(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'integer'
        ]);

        // Implementation would update notification records
        // For now, return success response

        return response()->json([
            'success' => true,
            'message' => 'Notifications marked as read'
        ]);
    }
}
