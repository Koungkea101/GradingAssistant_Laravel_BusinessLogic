<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reports extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'organization_id',
        'generated_by',
        'name',
        'type',
        'filters',
        'file_path',
        'format',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'filters' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // === RELATIONSHIPS ===
    /**
     * Get the organization that owns the report.
     */
    public function organization()
    {
        return $this->belongsTo(Organizations::class);
    }
    /**
     * Get the user who generated the report.
     */
    public function generatedBy()
    {
        return $this->belongsTo(Users::class, 'generated_by');
    }

}
