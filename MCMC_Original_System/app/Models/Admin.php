<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Support\Facades\Hash;

class Admin extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'administrators';
    protected $primaryKey = 'AdminID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'AdminName',
        'AdminEmail',
        'AdminUserName',
        'AdminPassword',
        'AdminPhoneNum',
        'AdminRole',
        'AdminAddress',
        'AdminProfilePicture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'AdminPassword',
        'remember_token',
    ];

    /**
     * Custom authentication methods for Admin
     */
    public function getAuthIdentifierName()
    {
        return 'AdminID';
    }

    public function getAuthIdentifier()
    {
        return $this->AdminID;
    }

    public function getAuthPassword()
    {
        return $this->AdminPassword;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Check if the provided password matches the admin's password
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->AdminPassword);
    }

    /**
     * Find admin by login input (username or email)
     */
    public static function findByLogin($loginInput)
    {
        return static::where('AdminUserName', $loginInput)
            ->orWhere('AdminEmail', $loginInput)
            ->first();
    }

    /**
     * Create a new admin
     */
    public static function createAdmin(array $data)
    {
        return static::create([
            'AdminName' => $data['AdminName'],
            'AdminEmail' => $data['AdminEmail'],
            'AdminUserName' => $data['AdminUserName'],
            'AdminPassword' => $data['AdminPassword'],
            'AdminPhoneNum' => $data['AdminPhoneNum'] ?? '',
            'AdminRole' => $data['AdminRole'] ?? 'Administrator',
        ]);
    }

    /**
     * Update admin profile
     */
    public function updateProfile(array $data)
    {
        $updateData = [
            'AdminEmail' => $data['AdminEmail'],
            'AdminPhoneNum' => $data['AdminPhoneNum'] ?? '',
            'updated_at' => now()
        ];

        // Handle profile picture if provided
        if (isset($data['AdminProfilePicture'])) {
            $updateData['AdminProfilePicture'] = $data['AdminProfilePicture'];
        }

        return $this->update($updateData);
    }

    /**
     * Update admin password
     */
    public function updatePassword($newPassword)
    {
        return $this->update([
            'AdminPassword' => $newPassword,
            'updated_at' => now()
        ]);
    }

    /**
     * Get all inquiries managed by this admin
     */
    public function managedInquiries()
    {
        return $this->hasMany(\App\Models\Module2\Inquiry::class, 'AdminID', 'AdminID');
    }

    /**
     * Get all assignments created by this admin
     */
    public function createdAssignments()
    {
        return $this->hasMany(\App\Models\Module2\AssignedInquiry::class, 'assigned_by', 'AdminID');
    }

    /**
     * Get all assignments this admin is responsible for
     */
    public function responsibleAssignments()
    {
        return $this->hasMany(\App\Models\Module2\AssignedInquiry::class, 'admin_id', 'AdminID');
    }

    /**
     * Get all progress notes added by this admin
     */
    public function progressNotes()
    {
        return $this->hasMany(\App\Models\Module2\InquiryProgressNote::class, 'added_by', 'AdminID')
                   ->where('added_by_type', 'admin');
    }

    /**
     * Get all status changes made by this admin
     */
    public function statusChanges()
    {
        return $this->hasMany(\App\Models\Module2\InquiryStatusHistory::class, 'changed_by', 'AdminID')
                   ->where('changed_by_type', 'admin');
    }

    /**
     * Get admin performance statistics
     */
    public function getPerformanceStats()
    {
        return [
            'total_managed' => $this->managedInquiries()->count(),
            'assignments_created' => $this->createdAssignments()->count(),
            'pending_reviews' => $this->managedInquiries()->where('InquiryStatus', 'pending')->count(),
            'completed_this_month' => $this->managedInquiries()
                ->where('InquiryStatus', 'completed')
                ->whereMonth('ProcessedAt', now()->month)
                ->count(),
            'average_resolution_time' => $this->calculateAverageResolutionTime(),
            'notes_added' => $this->progressNotes()->count(),
            'status_changes' => $this->statusChanges()->count(),
        ];
    }

    /**
     * Calculate average resolution time for admin's inquiries
     */
    public function calculateAverageResolutionTime()
    {
        $completedInquiries = $this->managedInquiries()
            ->where('InquiryStatus', 'completed')
            ->whereNotNull('ProcessedAt')
            ->get();

        if ($completedInquiries->isEmpty()) {
            return 0;
        }

        $totalDays = 0;
        foreach ($completedInquiries as $inquiry) {
            $totalDays += $inquiry->InquirySendDate->diffInDays($inquiry->ProcessedAt);
        }

        return round($totalDays / $completedInquiries->count(), 1);
    }

    /**
     * Get inquiries requiring admin attention
     */
    public function getInquiriesRequiringAttention()
    {
        return $this->managedInquiries()
            ->where('InquiryStatus', 'pending')
            ->orWhere(function($query) {
                $query->whereHas('assignedInquiry', function($subQuery) {
                    $subQuery->where('due_date', '<', now()->addDays(2))
                            ->whereNotIn('status', ['completed', 'cancelled']);
                });
            })
            ->orderBy('InquiryPriority', 'desc')
            ->orderBy('InquirySendDate', 'asc');
    }

    /**
     * Search admins by name or username
     */
    public static function search($searchTerm)
    {
        return static::where('AdminName', 'like', "%{$searchTerm}%")
            ->orWhere('AdminUserName', 'like', "%{$searchTerm}%")
            ->get();
    }
}
