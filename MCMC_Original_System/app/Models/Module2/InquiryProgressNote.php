<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryProgressNote extends Model
{
    use HasFactory;

    protected $table = 'inquiry_progress_notes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inquiry_id',
        'note',
        'note_type', // 'progress', 'internal', 'customer_facing', 'resolution'
        'added_by',
        'added_by_type', // 'admin', 'agency'
        'is_internal',
        'is_visible_to_user',
        'priority_level',
        'requires_action',
        'action_due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_internal' => 'boolean',
        'is_visible_to_user' => 'boolean',
        'requires_action' => 'boolean',
        'action_due_date' => 'datetime',
    ];

    /**
     * Get the inquiry this note belongs to
     */
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get the user who added this note (polymorphic)
     */
    public function addedBy()
    {
        switch ($this->added_by_type) {
            case 'admin':
                return $this->belongsTo(\App\Models\Admin::class, 'added_by', 'AdminID');
            case 'agency':
                return $this->belongsTo(\App\Models\Agency::class, 'added_by', 'AgencyID');
            default:
                return null;
        }
    }

    /**
     * Scope for internal notes
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * Scope for user-visible notes
     */
    public function scopeVisibleToUser($query)
    {
        return $query->where('is_visible_to_user', true);
    }

    /**
     * Scope for notes requiring action
     */
    public function scopeRequiresAction($query)
    {
        return $query->where('requires_action', true);
    }

    /**
     * Scope for overdue actions
     */
    public function scopeOverdueActions($query)
    {
        return $query->where('requires_action', true)
                    ->where('action_due_date', '<', now());
    }

    /**
     * Scope by note type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('note_type', $type);
    }

    /**
     * Check if action is overdue
     */
    public function isActionOverdue()
    {
        return $this->requires_action && 
               $this->action_due_date && 
               $this->action_due_date < now();
    }

    /**
     * Get days until action is due
     */
    public function getDaysUntilActionDue()
    {
        if ($this->action_due_date) {
            return now()->diffInDays($this->action_due_date, false);
        }
        return null;
    }
}
