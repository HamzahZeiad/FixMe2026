<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $primaryKey = 'InquiryID';

    protected $fillable = [
        'InquiryTitle',
        'InquiryStatus',
        'InquiryPriority',
        'VerificationDescription',
        'InquirySource',
        'InquirySendDate',
        'InquiryDescription',
        'InquiryEvidence',
        'AgencyID',
        'assignment_date',
        'AdminID',
        'UserID',
        'StatusComments',
        'ProcessedAt',
    ];

    protected $casts = [
        'InquirySendDate' => 'datetime',
        'assignment_date' => 'datetime',
        'ProcessedAt' => 'datetime',
    ];

    public $timestamps = true; // Enable timestamps

    /**
     * Get the agency assigned to this inquiry
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class, 'AgencyID', 'AgencyID');
    }

    /**
     * Get the user who submitted this inquiry
     */
    public function user()
    {
        return $this->belongsTo(PublicUser::class, 'UserID', 'UserID');
    }

    /**
     * Get the admin who handled this inquiry
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'AdminID', 'AdminID');
    }

    /**
     * Get the full status change history for this inquiry (Module 4 timeline)
     */
    public function statusLogs()
    {
        return $this->hasMany(InquiryStatusLog::class, 'InquiryID', 'InquiryID')
                    ->orderBy('created_at', 'asc');
    }

    /**
     * Centralised helper: change status, write a log entry, and persist.
     * Use this everywhere instead of directly setting InquiryStatus.
     */
    public function changeStatus(
        string $newStatus,
        string $actorType,
        int    $actorId,
        string $actorName,
        ?string $notes = null
    ): void {
        $previous = $this->InquiryStatus;
        $this->InquiryStatus = $newStatus;
        $this->ProcessedAt   = now();
        $this->save();

        InquiryStatusLog::create([
            'InquiryID'       => $this->InquiryID,
            'status'          => $newStatus,
            'previous_status' => $previous,
            'notes'           => $notes,
            'actor_type'      => $actorType,
            'actor_id'        => $actorId,
            'actor_name'      => $actorName,
        ]);
    }
}
