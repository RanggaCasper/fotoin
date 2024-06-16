<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolio_catalogs';

    protected $fillable = ['path_image','catalog_id'];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public $timestamps = true; 
}
