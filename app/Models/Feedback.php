<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback_catalogs';

    protected $fillable = ['rate','feedback','user_id','catalog_id','transaction_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }


    public $timestamps = true; 
}
