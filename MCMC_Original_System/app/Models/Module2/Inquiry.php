<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PublicUser;
use App\Models\Agency;
use App\Models\Admin;

class Inquiry extends Model
{
    use HasFactory;

    protected $table = 'inquiries';
    protected $primaryKey = 'InquiryID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'InquiryTitle',
        'InquiryDescription',
        'InquiryStatus',
        'InquiryPriority',
        'InquirySource',
        'InquirySendDate',
        'VerificationDescription',
        'InquiryEvidence',
        'UserID',
        'AgencyID',
        'AdminID',
        'assignment_date',
        'StatusComments',
        'ProcessedAt',
        'category',
        'contact_preference',
        'estimated_resolution_time',
        'actual_resolution_time',
        'satisfaction_rating',
        'follow_up_required',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'InquirySendDate' => 'datetime',
        'assignment_date' => 'datetime',
        'ProcessedAt' => 'datetime',
        'estimated_resolution_time' => 'integer',
        'actual_resolution_time' => 'integer',
        'satisfaction_rating' => 'integer',
        'follow_up_required' => 'boolean',
    ];

    /**
     * Get the public user who submitted this inquiry
     */
    public function publicUser()
    {
        return $this->belongsTo(PublicUser::class, 'UserID', 'UserID');
    }

    /**
     * Get the user who submitted this inquiry (alias for publicUser)
     */
    public function user()
    {
        return $this->publicUser();
    }

    /**
     * Get the agency assigned to this inquiry
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class, 'AgencyID', 'AgencyID');
    }

    /**
     * Get the administrator handling this inquiry
     */
    public function administrator()
    {
        return $this->belongsTo(Admin::class, 'AdminID', 'AdminID');
    }

    /**
     * Get the admin handling this inquiry (alias)
     */
    public function admin()
    {
        return $this->administrator();
    }

    /**
     * Get the assignment details for this inquiry
     */
    public function assignedInquiry()
    {
        return $this->hasOne(AssignedInquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get all attachments for this inquiry
     */
    public function attachments()
    {
        return $this->hasMany(InquiryAttachment::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get all progress notes for this inquiry
     */
    public function progressNotes()
    {
        return $this->hasMany(InquiryProgressNote::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get all status history for this inquiry
     */
    public function statusHistory()
    {
        return $this->hasMany(InquiryStatusHistory::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('InquiryStatus', $status);
    }

    /**
     * Scope for filtering by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('InquiryPriority', $priority);
    }

    /**
     * Scope for filtering by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('UserID', $userId);
    }

    /**
     * Scope for filtering by agency
     */
    public function scopeByAgency($query, $agencyId)
    {
        return $query->where('AgencyID', $agencyId);
    }

    /**
     * Scope for pending inquiries
     */
    public function scopePending($query)
    {
        return $query->where('InquiryStatus', 'pending');
    }

    /**
     * Scope for assigned inquiries
     */
    public function scopeAssigned($query)
    {
        return $query->whereIn('InquiryStatus', ['assigned', 'in-progress']);
    }

    /**
     * Scope for completed inquiries
     */
    public function scopeCompleted($query)
    {
        return $query->where('InquiryStatus', 'completed');
    }

    /**
     * Check if inquiry is overdue
     */
    public function isOverdue()
    {
        if ($this->assignedInquiry && $this->assignedInquiry->due_date) {
            return $this->assignedInquiry->due_date < now() && 
                   !in_array($this->InquiryStatus, ['completed', 'cancelled']);
        }
        return false;
    }

    /**
     * Get the inquiry age in days
     */
    public function getAgeInDays()
    {
        return $this->InquirySendDate ? 
               $this->InquirySendDate->diffInDays(now()) : 0;
    }

    /**
     * Get resolution time in days
     */
    public function getResolutionTimeInDays()
    {
        if ($this->ProcessedAt && $this->InquirySendDate) {
            return $this->InquirySendDate->diffInDays($this->ProcessedAt);
        }
        return null;
    }
}
