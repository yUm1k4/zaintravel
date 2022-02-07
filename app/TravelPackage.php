<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelPackage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'location', 'about', 'featured_event', 
        'language', 'food', 'departure_date', 'duration', 'type', 'price'
    ];

    protected $hidden = [
        // 'created_at', 'updated_at', 'deleted_at'
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'travel_packages_id', 'id');
    }
}
