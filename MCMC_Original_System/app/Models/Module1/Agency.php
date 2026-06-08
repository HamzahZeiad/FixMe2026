<?php

namespace App\Models\Module1;

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
     * Update agency profile - Module1 specific
     */
    public function updateProfile(array $data)
    {
        $updateData = [
            'AgencyEmail' => $data['AgencyEmail'],
            'AgencyPhoneNum' => $data['AgencyPhoneNum'] ?? '',
            'updated_at' => now()
        ];

        // Handle name and username if provided
        if (isset($data['AgencyName'])) {
            $updateData['AgencyName'] = $data['AgencyName'];
        }

        if (isset($data['AgencyUserName'])) {
            $updateData['AgencyUserName'] = $data['AgencyUserName'];
        }

        // Handle profile picture if provided
        if (isset($data['AgencyProfilePicture'])) {
            $updateData['AgencyProfilePicture'] = $data['AgencyProfilePicture'];
        }

        return $this->update($updateData);
    }

    /**
     * Update agency password - Module1 specific
     */
    public function updatePassword($newPassword)
    {
        return $this->update([
            'AgencyPassword' => $newPassword,
            'updated_at' => now()
        ]);
    }

    /**
     * Validate current password - Module1 specific
     */
    public function validateCurrentPassword($currentPassword)
    {
        return password_verify($currentPassword, $this->AgencyPassword);
    }

    /**
     * Search agencies by name or username - Module1 specific
     */
    public static function search($searchTerm)
    {
        return static::where('AgencyName', 'like', "%{$searchTerm}%")
            ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%")
            ->get();
    }
}
