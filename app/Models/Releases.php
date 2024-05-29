<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Releases extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'story',
        'publication_date',
        'category_id',
        'type',
        'other_type',
        'brand_DM',
        'ean',
        'country',
        'region',
        'price_band',
        'abv',
        'logo',
        'gallery',
        'cover',
        'socialmedia_link'
    ];
}
