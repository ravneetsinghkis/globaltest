<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class ProductCatalog extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'description',
        'email',
        'establishment',
        'region',
        'representative_name',
        'representative_contact',
        'person_name',
        'person_info',
        'logo',
        'country_id',
        'company_social'
    ];
   
}
