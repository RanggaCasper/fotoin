<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorys';

    protected $fillable = ['name','icon','images'];

    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }

    public $timestamps = true; 
}
