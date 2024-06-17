<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';

    protected $fillable = ['title_name','description','category_id','user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function portfolios()
    {
        return $this->hasMany(Portofolio::class);
    }

    public $timestamps = true; 
}
