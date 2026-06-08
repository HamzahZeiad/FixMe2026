<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Module2 User Model - Central interface for all user types in Module2
 * This model provides a unified interface for PublicUsers, Admins, and Agencies
 */
class User extends Model
{
    use HasFactory;

    // This is more of a virtual model for Module2 interface
    // It doesn't have its own table but provides unified access

    /**
     * Get PublicUser by ID
     */
    public static function getPublicUser($id)
    {
        return \App\Models\PublicUser::find($id);
    }

    /**
     * Get Admin by ID
     */
    public static function getAdmin($id)
    {
        return \App\Models\Admin::find($id);
    }

    /**
     * Get Agency by ID
     */
    public static function getAgency($id)
    {
        return \App\Models\Agency::find($id);
    }

    /**
     * Get user by type and ID
     */
    public static function getUserByType($type, $id)
    {
        switch ($type) {
            case 'public':
            case 'user':
                return self::getPublicUser($id);
            case 'admin':
                return self::getAdmin($id);
            case 'agency':
                return self::getAgency($id);
            default:
                return null;
        }
    }

    /**
     * Get all public users with inquiry counts
     */
    public static function getPublicUsersWithStats()
    {
        return \App\Models\PublicUser::withCount([
            'inquiries',
            'inquiries as pending_inquiries_count' => function ($query) {
                $query->where('InquiryStatus', 'pending');
            },
            'inquiries as completed_inquiries_count' => function ($query) {
                $query->where('InquiryStatus', 'completed');
            }
        ])->get();
    }

    /**
     * Get all agencies with workload stats
     */
    public static function getAgenciesWithStats()
    {
        return \App\Models\Agency::withCount([
            'assignedInquiries',
            'assignedInquiries as pending_count' => function ($query) {
                $query->where('InquiryStatus', 'pending');
            },
            'assignedInquiries as completed_count' => function ($query) {
                $query->where('InquiryStatus', 'completed');
            }
        ])->get();
    }

    /**
     * Get all admins with performance stats
     */
    public static function getAdminsWithStats()
    {
        return \App\Models\Admin::withCount([
            'managedInquiries',
            'createdAssignments',
            'managedInquiries as pending_reviews_count' => function ($query) {
                $query->where('InquiryStatus', 'pending');
            }
        ])->get();
    }

    /**
     * Search across all user types
     */
    public static function searchAllUsers($searchTerm)
    {
        $publicUsers = \App\Models\PublicUser::where('UserName', 'like', "%{$searchTerm}%")
            ->orWhere('UserEmail', 'like', "%{$searchTerm}%")
            ->get()
            ->map(function ($user) {
                $user->user_type = 'public';
                return $user;
            });

        $admins = \App\Models\Admin::where('AdminName', 'like', "%{$searchTerm}%")
            ->orWhere('AdminUserName', 'like', "%{$searchTerm}%")
            ->orWhere('AdminEmail', 'like', "%{$searchTerm}%")
            ->get()
            ->map(function ($user) {
                $user->user_type = 'admin';
                return $user;
            });

        $agencies = \App\Models\Agency::where('AgencyName', 'like', "%{$searchTerm}%")
            ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%")
            ->orWhere('AgencyEmail', 'like', "%{$searchTerm}%")
            ->get()
            ->map(function ($user) {
                $user->user_type = 'agency';
                return $user;
            });

        return collect()
            ->merge($publicUsers)
            ->merge($admins)
            ->merge($agencies);
    }

    /**
     * Get user activity summary
     */
    public static function getUserActivitySummary($userType, $userId)
    {
        switch ($userType) {
            case 'public':
                $user = self::getPublicUser($userId);
                return $user ? $user->getInquiryStats() : null;
                
            case 'admin':
                $user = self::getAdmin($userId);
                return $user ? $user->getPerformanceStats() : null;
                
            case 'agency':
                $user = self::getAgency($userId);
                return $user ? $user->getWorkloadStats() : null;
                
            default:
                return null;
        }
    }

    /**
     * Get recent user activities across all types
     */
    public static function getRecentActivities($limit = 10)
    {
        // This would typically involve joining multiple tables
        // For now, return sample data
        return collect([
            [
                'user_type' => 'public',
                'user_name' => 'John Doe',
                'activity' => 'Submitted new inquiry',
                'timestamp' => now()->subMinutes(5),
            ],
            [
                'user_type' => 'admin',
                'user_name' => 'Admin Smith',
                'activity' => 'Reviewed inquiry #1234',
                'timestamp' => now()->subMinutes(15),
            ],
            [
                'user_type' => 'agency',
                'user_name' => 'Tech Agency',
                'activity' => 'Updated inquiry status',
                'timestamp' => now()->subMinutes(30),
            ],
        ])->take($limit);
    }
}
