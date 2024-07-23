<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = ['invoice','status','note','ip','user_agent','approved','catalog_name','catalog_image','package_name','package_price','package_description','catalog_id','user_id','freelance_id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freelance()
    {
        return $this->belongsTo(User::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'transaction_id');
    }

    public static function generateInvoice()
    {
        $date = now()->format('Ymd');
        $randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        return 'FOTO' . $date . $randomNumber;
    }
}
