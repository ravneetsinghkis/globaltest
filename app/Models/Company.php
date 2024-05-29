<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    public function categories()
    {
        return $this->hasMany(Categories::class);
    }
    
}
