<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryAttachment extends Model
{
    use HasFactory;

    protected $table = 'inquiry_attachments';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inquiry_id',
        'filename',
        'original_filename',
        'file_path',
        'file_size',
        'file_type',
        'mime_type',
        'uploaded_by',
        'uploaded_by_type', // 'user', 'admin', 'agency'
        'description',
        'is_evidence',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'file_size' => 'integer',
        'is_evidence' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * Get the inquiry this attachment belongs to
     */
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get the user who uploaded this attachment (polymorphic)
     */
    public function uploadedBy()
    {
        switch ($this->uploaded_by_type) {
            case 'user':
                return $this->belongsTo(\App\Models\PublicUser::class, 'uploaded_by', 'UserID');
            case 'admin':
                return $this->belongsTo(\App\Models\Admin::class, 'uploaded_by', 'AdminID');
            case 'agency':
                return $this->belongsTo(\App\Models\Agency::class, 'uploaded_by', 'AgencyID');
            default:
                return null;
        }
    }

    /**
     * Scope for evidence files
     */
    public function scopeEvidence($query)
    {
        return $query->where('is_evidence', true);
    }

    /**
     * Scope for public files
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeFormatted()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is an image
     */
    public function isImage()
    {
        return strpos($this->mime_type, 'image/') === 0;
    }

    /**
     * Check if file is a document
     */
    public function isDocument()
    {
        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain'
        ];
        
        return in_array($this->mime_type, $documentTypes);
    }
}
