<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = [
        'property_id',
        'image_path',
        'thumbnail_path',
        'display_path',
        'original_path',
        'is_primary',
        'order'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the property that owns the image
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail_path 
            ? asset('storage/' . $this->thumbnail_path)
            : asset('storage/' . $this->image_path);
    }

    /**
     * Get display (medium size) URL
     */
    public function getDisplayUrlAttribute(): string
    {
        return $this->display_path 
            ? asset('storage/' . $this->display_path)
            : asset('storage/' . $this->image_path);
    }

    /**
     * Get original/full size URL
     */
    public function getOriginalUrlAttribute(): string
    {
        return $this->original_path 
            ? asset('storage/' . $this->original_path)
            : asset('storage/' . $this->image_path);
    }
}

