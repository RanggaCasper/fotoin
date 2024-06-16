<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category_catalogs';

    protected $fillable = ['category'];

    // public function catalog()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public $timestamps = true; 
}
