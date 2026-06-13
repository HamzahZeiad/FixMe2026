<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * InquiryStatusLog — Module 4
 *
 * Records every status change on an Inquiry.
 * Used by StatusesController::statusHistory() and the timeline view.
 */
class InquiryStatusLog extends Model
{
    protected $table = 'inquiry_status_logs';

    protected $fillable = [
        'InquiryID',
        'status',
        'previous_status',
        'notes',
        'actor_type',
        'actor_id',
        'actor_name',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'InquiryID', 'InquiryID');
    }
}
