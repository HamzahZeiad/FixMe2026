<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class PublicUser extends Authenticatable implements CanResetPassword
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



    public function getAuthPassword()
    {
        return $this->UserPassword;
    }

    public function getEmailForPasswordReset()
    {
        return $this->UserEmail;
    }
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
     * Get all inquiries submitted by this user
     */
    public function inquiries()
    {
        return $this->hasMany(\App\Models\Module2\Inquiry::class, 'UserID', 'UserID');
    }

    /**
     * Get pending inquiries for this user
     */
    public function pendingInquiries()
    {
        return $this->inquiries()->where('InquiryStatus', 'pending');
    }

    /**
     * Get completed inquiries for this user
     */
    public function completedInquiries()
    {
        return $this->inquiries()->where('InquiryStatus', 'completed');
    }

    /**
     * Get inquiry statistics for this user
     */
    public function getInquiryStats()
    {
        return [
            'total' => $this->inquiries()->count(),
            'pending' => $this->pendingInquiries()->count(),
            'in_progress' => $this->inquiries()->whereIn('InquiryStatus', ['assigned', 'in-progress'])->count(),
            'completed' => $this->completedInquiries()->count(),
            'cancelled' => $this->inquiries()->where('InquiryStatus', 'cancelled')->count(),
        ];
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
