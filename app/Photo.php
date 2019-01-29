<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'image_url',
        'size',
    ];

    // this needs to be uncommented to use user uploaded images, commented to use seed data
    // protected $uploads = '/images/';

    public function getImageUrlAttribute($photo) {
        // prepends /images/ when image_url property is rendered
        return $this->uploads . $photo;
    }
}
