<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspendUser extends Model
{
    use HasFactory;

    protected $table = 'suspend_user';

    protected $fillable = [
        'email', 'note', 'user_id','admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
