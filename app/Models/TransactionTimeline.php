<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTimeline extends Model
{
    use HasFactory;

    protected $table = 'transaction_timelines';

    protected $fillable = ['progress', 'created_by', 'description', 'transaction_id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
