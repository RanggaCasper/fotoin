<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendar';

    protected $fillable = ['title','start','end','allDay','calendar','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
