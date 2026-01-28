<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;


class Property extends Model
{
    
    use HasFactory;
    protected $fillable = [
    'title', 'description', 'address', 'city', 'state', 
    'price', 'bedrooms', 'bathrooms', 'area_sqft', 'type',
    'status', 'latitude', 'longitude', 'user_id'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function applications()
    {
        return $this->hasMany(RentalApplication::class);
    }    

}
