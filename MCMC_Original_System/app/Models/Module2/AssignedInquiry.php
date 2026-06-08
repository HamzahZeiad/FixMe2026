<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inquiry;
use App\Models\Agency;
use App\Models\Admin;

class AssignedInquiry extends Model
{
    use HasFactory;

    protected $table = 'assigned_inquiries';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inquiry_id',
        'agency_id',
        'admin_id',
        'assignment_date',
        'due_date',
        'priority_level',
        'status',
        'notes',
        'assigned_by',
        'estimated_completion_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'assignment_date' => 'datetime',
        'due_date' => 'datetime',
        'estimated_completion_time' => 'integer',
    ];

    /**
     * Get the inquiry that is assigned
     */
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get the agency assigned to handle this inquiry
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'AgencyID');
    }

    /**
     * Get the admin who assigned this inquiry
     */
    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by', 'AdminID');
    }

    /**
     * Get the admin responsible for this assignment
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'AdminID');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority_level', $priority);
    }

    /**
     * Scope for overdue assignments
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    /**
     * Check if assignment is overdue
     */
    public function isOverdue()
    {
        return $this->due_date < now() && !in_array($this->status, ['completed', 'cancelled']);
    }

    /**
     * Get days remaining until due date
     */
    public function getDaysRemaining()
    {
        if ($this->due_date) {
            return now()->diffInDays($this->due_date, false);
        }
        return null;
    }
}
