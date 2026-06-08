<?php

namespace App\Models\Module1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Support\Facades\Hash;

class Administrator extends Model implements Authenticatable
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
     * Get all public users with optional search - Module1 specific
     */
    public function getPublicUsers($searchTerm = null)
    {
        $query = \App\Models\Module1\PublicUsers::query();

        if ($searchTerm) {
            $query->where('UserName', 'like', "%{$searchTerm}%");
        }

        return $query->get();
    }

    /**
     * Get all agencies with optional search - Module1 specific
     */
    public function getAgencies($searchTerm = null)
    {
        $query = \App\Models\Module1\Agency::query();

        if ($searchTerm) {
            $query->where('AgencyName', 'like', "%{$searchTerm}%")
                ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%");
        }

        return $query->get();
    }

    /**
     * Update user profile - Module1 specific function
     */
    public function updateUserProfile($userId, array $data)
    {
        $user = \App\Models\Module1\PublicUsers::find($userId);
        if ($user) {
            return $user->update([
                'UserName' => $data['UserName'],
                'UserEmail' => $data['UserEmail'],
                'UserPhoneNum' => $data['UserPhoneNum'] ?? '',
                'updated_at' => now()
            ]);
        }
        return false;
    }

    /**
     * Update agency profile - Module1 specific function
     */
    public function updateAgencyProfile($agencyId, array $data)
    {
        $agency = \App\Models\Module1\Agency::find($agencyId);
        if ($agency) {
            return $agency->update([
                'AgencyName' => $data['AgencyName'],
                'AgencyEmail' => $data['AgencyEmail'],
                'AgencyUserName' => $data['AgencyUserName'],
                'AgencyPhoneNum' => $data['AgencyPhoneNum'] ?? '',
                'updated_at' => now()
            ]);
        }
        return false;
    }

    /**
     * Create a new agency - Module1 specific
     */
    public function createNewAgency(array $data)
    {
        return \App\Models\Module1\Agency::create([
            'AgencyName' => $data['AgencyName'],
            'AgencyEmail' => $data['AgencyEmail'],
            'AgencyUserName' => $data['AgencyUserName'],
            'AgencyPassword' => $data['AgencyPassword'],
            'AgencyPhoneNum' => $data['AgencyPhoneNum'] ?? '',
            'AgencyType' => $data['AgencyType'] ?? 'Default',
        ]);
    }

    /**
     * Delete a public user - Module1 specific
     */
    public function deleteUser($userId)
    {
        $user = \App\Models\Module1\PublicUsers::find($userId);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    /**
     * Delete an agency - Module1 specific
     */
    public function deleteAgency($agencyId)
    {
        $agency = \App\Models\Module1\Agency::find($agencyId);
        if ($agency) {
            return $agency->delete();
        }
        return false;
    }

    /**
     * Get statistics for admin dashboard - Module1 specific
     */
    public function getDashboardStats()
    {
        return [
            'total_users' => \App\Models\Module1\PublicUsers::count(),
            'total_agencies' => \App\Models\Module1\Agency::count(),
            'recent_users' => \App\Models\Module1\PublicUsers::latest()->take(5)->get(),
            'recent_agencies' => \App\Models\Module1\Agency::latest()->take(5)->get(),
        ];
    }

    /**
     * Search users by name or email - Module1 specific
     */
    public function searchUsers($searchTerm)
    {
        return \App\Models\Module1\PublicUsers::where('UserName', 'like', "%{$searchTerm}%")
            ->orWhere('UserEmail', 'like', "%{$searchTerm}%")
            ->get();
    }

    /**
     * Search agencies by name or username - Module1 specific
     */
    public function searchAgencies($searchTerm)
    {
        return \App\Models\Module1\Agency::where('AgencyName', 'like', "%{$searchTerm}%")
            ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%")
            ->get();
    }

    /**
     * Update admin password - Module1 specific
     */
    public function updatePassword($newPassword)
    {
        return $this->update([
            'AdminPassword' => $newPassword,
            'updated_at' => now()
        ]);
    }
}
