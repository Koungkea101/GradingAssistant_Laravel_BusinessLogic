<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Files extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'organization_id',
        'uploaded_by',
        'fileable_type',
        'fileable_id',
        'filename',
        'original_filename',
        'path',
        'disk',
        'mime_type',
        'size',
        'type',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'metadata' => 'array',
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * File type constants.
     */
    public const TYPE_QUESTION = 'question';
    public const TYPE_ANSWER = 'answer';
    public const TYPE_REPORT = 'report';
    public const TYPE_EXPORT = 'export';

    /**
     * Get the organization that owns the file.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organizations::class, 'organization_id');
    }

    /**
     * Get the user who uploaded the file.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'uploaded_by');
    }

    /**
     * Get the owning fileable model (polymorphic relationship).
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the file size in a human-readable format.
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the full file path.
     */
    public function getFullPathAttribute(): string
    {
        return storage_path("app/{$this->disk}/{$this->path}");
    }

    /**
     * Scope to filter files by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter files by organization.
     */
    public function scopeForOrganization($query, int $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    /**
     * Scope to filter files by uploader.
     */
    public function scopeUploadedBy($query, int $userId)
    {
        return $query->where('uploaded_by', $userId);
    }
}
