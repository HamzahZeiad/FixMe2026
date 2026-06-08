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
}
