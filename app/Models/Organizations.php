<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizations extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'logo',
        'settings',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ============ RELATIONSHIPS ============

    /**
     * Get all departments belonging to this organization.
     */
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all users belonging to this organization.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all classes belonging to this organization.
     */
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    /**
     * Get all courses belonging to this organization.
     */
    public function courses()
    {
        return $this->hasMany(Courses::class);
    }

    /**
     * Get all assignments belonging to this organization.
     */
    public function assignments()
    {
        return $this->hasMany(Assignments::class);
    }

    /**
     * Get all rubrics belonging to this organization.
     */
    public function rubrics()
    {
        return $this->hasMany(Rubrics::class);
    }

    /**
     * Get all files belonging to this organization.
     */
    public function files()
    {
        return $this->hasMany(Files::class);
    }

    /**
     * Get all reports belonging to this organization.
     */
    public function reports()
    {
        return $this->hasMany(Reports::class);
    }


    // ============ SCOPES ============

    /**
     * Scope a query to only include active organizations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to search organizations by name or email.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // ============ MUTATORS & ACCESSORS ============

    /**
     * Set the organization's slug.
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = strtolower(str_replace(' ', '-', $value));
    }

    /**
     * Get the organization's logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
