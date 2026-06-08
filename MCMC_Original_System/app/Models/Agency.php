<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Support\Facades\Hash;

class Agency extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agencies';
    protected $primaryKey = 'AgencyID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'AgencyName',
        'AgencyEmail',
        'AgencyUserName',
        'AgencyPassword',
        'AgencyPhoneNum',
        'AgencyType',
        'AgencyProfilePicture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'AgencyPassword',
        'remember_token',
    ];

    /**
     * Custom authentication methods for Agency
     */
    public function getAuthIdentifierName()
    {
        return 'AgencyID';
    }

    public function getAuthIdentifier()
    {
        return $this->AgencyID;
    }

    public function getAuthPassword()
    {
        return $this->AgencyPassword;
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
     * Check if the provided password matches the agency's password
     */
    public function checkPassword($password)
    {
        // Use native password_verify to bypass Laravel's algorithm verification
        return password_verify($password, $this->AgencyPassword);
    }

    /**
     * Find agency by login input (username or email)
     */
    public static function findByLogin($loginInput)
    {
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            return self::where('AgencyEmail', $loginInput)->first();
        } else {
            return self::where('AgencyUserName', $loginInput)->first();
        }
    }

    /**
     * Create a new agency
     */
    public static function createAgency(array $data)
    {
        return static::create([
            'AgencyName' => $data['AgencyName'],
            'AgencyEmail' => $data['AgencyEmail'],
            'AgencyUserName' => $data['AgencyUserName'],
            'AgencyPassword' => $data['AgencyPassword'],
            'AgencyPhoneNum' => $data['AgencyPhoneNum'] ?? '',
            'AgencyType' => $data['AgencyType'] ?? 'Default',
        ]);
    }

    /**
     * Get all inquiries assigned to this agency
     */
    public function assignedInquiries()
    {
        return $this->hasMany(\App\Models\Module2\Inquiry::class, 'AgencyID', 'AgencyID');
    }

    /**
     * Get assignment details for this agency
     */
    public function assignments()
    {
        return $this->hasMany(\App\Models\Module2\AssignedInquiry::class, 'agency_id', 'AgencyID');
    }

    /**
     * Get pending assignments for this agency
     */
    public function pendingAssignments()
    {
        return $this->assignments()->where('status', 'pending');
    }

    /**
     * Get in-progress assignments for this agency
     */
    public function inProgressAssignments()
    {
        return $this->assignments()->where('status', 'in-progress');
    }

    /**
     * Get completed assignments for this agency
     */
    public function completedAssignments()
    {
        return $this->assignments()->where('status', 'completed');
    }

    /**
     * Get overdue assignments for this agency
     */
    public function overdueAssignments()
    {
        return $this->assignments()->overdue();
    }

    /**
     * Get agency workload statistics
     */
    public function getWorkloadStats()
    {
        return [
            'total_assigned' => $this->assignments()->count(),
            'pending' => $this->pendingAssignments()->count(),
            'in_progress' => $this->inProgressAssignments()->count(),
            'completed' => $this->completedAssignments()->count(),
            'overdue' => $this->overdueAssignments()->count(),
            'completion_rate' => $this->calculateCompletionRate(),
            'average_completion_time' => $this->calculateAverageCompletionTime(),
        ];
    }

    /**
     * Calculate completion rate percentage
     */
    public function calculateCompletionRate()
    {
        $total = $this->assignments()->count();
        $completed = $this->completedAssignments()->count();
        
        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }

    /**
     * Calculate average completion time in days
     */
    public function calculateAverageCompletionTime()
    {
        $completedAssignments = $this->completedAssignments()
            ->whereNotNull('assignment_date')
            ->get();

        if ($completedAssignments->isEmpty()) {
            return 0;
        }

        $totalDays = 0;
        foreach ($completedAssignments as $assignment) {
            $totalDays += $assignment->assignment_date->diffInDays($assignment->updated_at);
        }

        return round($totalDays / $completedAssignments->count(), 1);
    }

    /**
     * Search agencies by name or username
     */
    public static function search($searchTerm)
    {
        return static::where('AgencyName', 'like', "%{$searchTerm}%")
            ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%")
            ->get();
    }
}
