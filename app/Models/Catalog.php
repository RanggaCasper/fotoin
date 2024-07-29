<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';

    protected $fillable = ['title_name','description','slug','status','category_id','user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portofolios()
    {
        return $this->hasMany(Portofolio::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isInWishlist()
    {
        if (auth()->check()) {
            return $this->wishlists()->where('user_id', auth()->user()->id)->exists();
        }
        return false;
    }

    public $timestamps = true; 
}
