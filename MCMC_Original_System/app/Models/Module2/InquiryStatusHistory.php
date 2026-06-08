<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'inquiry_status_history';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inquiry_id',
        'previous_status',
        'new_status',
        'changed_by',
        'changed_by_type', // 'admin', 'agency', 'system'
        'reason',
        'comments',
        'status_duration', // in minutes
        'automatic_change',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status_duration' => 'integer',
        'automatic_change' => 'boolean',
    ];

    /**
     * Get the inquiry this status change belongs to
     */
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get the user who changed the status (polymorphic)
     */
    public function changedBy()
    {
        switch ($this->changed_by_type) {
            case 'admin':
                return $this->belongsTo(\App\Models\Admin::class, 'changed_by', 'AdminID');
            case 'agency':
                return $this->belongsTo(\App\Models\Agency::class, 'changed_by', 'AgencyID');
            default:
                return null;
        }
    }

    /**
     * Scope for specific status changes
     */
    public function scopeStatusChange($query, $from, $to)
    {
        return $query->where('previous_status', $from)
                    ->where('new_status', $to);
    }

    /**
     * Scope for automatic changes
     */
    public function scopeAutomatic($query)
    {
        return $query->where('automatic_change', true);
    }

    /**
     * Scope for manual changes
     */
    public function scopeManual($query)
    {
        return $query->where('automatic_change', false);
    }

    /**
     * Scope by who changed it
     */
    public function scopeChangedByType($query, $type)
    {
        return $query->where('changed_by_type', $type);
    }

    /**
     * Get status duration in human readable format
     */
    public function getStatusDurationFormatted()
    {
        if (!$this->status_duration) {
            return 'Unknown';
        }

        $minutes = $this->status_duration;
        
        if ($minutes < 60) {
            return $minutes . ' minute' . ($minutes != 1 ? 's' : '');
        }
        
        $hours = intval($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($hours < 24) {
            $result = $hours . ' hour' . ($hours != 1 ? 's' : '');
            if ($remainingMinutes > 0) {
                $result .= ' ' . $remainingMinutes . ' minute' . ($remainingMinutes != 1 ? 's' : '');
            }
            return $result;
        }
        
        $days = intval($hours / 24);
        $remainingHours = $hours % 24;
        
        $result = $days . ' day' . ($days != 1 ? 's' : '');
        if ($remainingHours > 0) {
            $result .= ' ' . $remainingHours . ' hour' . ($remainingHours != 1 ? 's' : '');
        }
        
        return $result;
    }

    /**
     * Check if status change was recent (within last hour)
     */
    public function isRecent()
    {
        return $this->created_at && $this->created_at->diffInHours(now()) <= 1;
    }
}
