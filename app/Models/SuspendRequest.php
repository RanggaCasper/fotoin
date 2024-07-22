<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspendRequest extends Model
{
    use HasFactory;

    protected $table = 'suspend_request';
    
    protected $fillable = [
        'reporter_id', 'reported_id', 'note', 'proff', 'status'
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }
}
