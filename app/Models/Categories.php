<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCatalog;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'story',
        'establishment',
        'company_id',
        'type',
        'is_selected',
        'other_type',
        'brand_DM',
        'country',
        'region',
        'logo',
        'cover',
        'gallery',
        'socialmedia_link'
    ];
    public function companies()
    {
        return $this->belongsTo(ProductCatalog::class);
    }
}
