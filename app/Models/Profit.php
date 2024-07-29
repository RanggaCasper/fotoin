<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    protected $table = 'profit_history';

    protected $fillable = ['profit','transaction_id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public $timestamps = true; 
}
