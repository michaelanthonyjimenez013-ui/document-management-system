<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'assessment_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'category',
        'description',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getFileSizeInKBAttribute(): string
    {
        return number_format($this->file_size / 1024, 2) . ' KB';
    }

    public function getFileSizeInMBAttribute(): string
    {
        return number_format($this->file_size / 1024 / 1024, 2) . ' MB';
    }

    public function isImage(): bool
    {
        return in_array($this->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    public function isWordDocument(): bool
    {
        return in_array($this->mime_type, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);
    }
}
