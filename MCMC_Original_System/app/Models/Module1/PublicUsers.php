<?php

namespace App\Models\Module1;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Support\Facades\Hash;

class PublicUsers extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;
    use CanResetPasswordTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public_users';
    protected $primaryKey = 'UserID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UserName',
        'UserEmail',
        'UserPassword',
        'UserPhoneNum',
        'UserProfilePicture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'UserPassword',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Custom authentication methods
     */
    public function getAuthPassword()
    {
        return $this->UserPassword;
    }

    public function getEmailForPasswordReset()
    {
        return $this->UserEmail;
    }

    /**
     * Create a new user - Module1 specific
     */
    public static function createUser(array $data)
    {
        return static::create([
            'UserName' => $data['UserName'],
            'UserEmail' => $data['UserEmail'],
            'UserPassword' => $data['UserPassword'],
            'UserPhoneNum' => $data['UserPhoneNum'] ?? '',
        ]);
    }

    /**
     * Update user profile - Module1 specific
     */
    public function updateProfile(array $data)
    {
        $updateData = [
            'UserName' => $data['UserName'],
            'UserEmail' => $data['UserEmail'],
            'UserPhoneNum' => $data['UserPhoneNum'] ?? '',
            'updated_at' => now()
        ];

        // Handle profile picture if provided
        if (isset($data['UserProfilePicture'])) {
            $updateData['UserProfilePicture'] = $data['UserProfilePicture'];
        }

        return $this->update($updateData);
    }

    /**
     * Update user password - Module1 specific
     */
    public function updatePassword($newPassword)
    {
        return $this->update([
            'UserPassword' => $newPassword,
            'updated_at' => now()
        ]);
    }

    /**
     * Validate current password - Module1 specific
     */
    public function validateCurrentPassword($currentPassword)
    {
        return Hash::check($currentPassword, $this->UserPassword);
    }

    /**
     * Find user by email for password recovery - Module1 specific
     */
    public static function findByEmail($email)
    {
        return static::where('UserEmail', $email)->first();
    }

    /**
     * Check if email exists - Module1 specific
     */
    public static function emailExists($email)
    {
        return static::where('UserEmail', $email)->exists();
    }

    /**
     * Check if username exists - Module1 specific
     */
    public static function usernameExists($username)
    {
        return static::where('UserName', $username)->exists();
    }

    /**
     * Search users by name or email - Module1 specific
     */
    public static function search($searchTerm)
    {
        return static::where('UserName', 'like', "%{$searchTerm}%")
            ->where('UserEmail', 'like', "%{$searchTerm}%")
            ->get();
    }

    /**
     * Set a default value for the UserName field.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->UserName)) {
                $user->UserName = 'DefaultUserName'; // Set a default value for the UserName field
            }
        });
    }
}
