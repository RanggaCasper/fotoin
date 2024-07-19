<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = "payments";

    protected $fillable = ['reference','checkout_url','nomor_va','qr_link','expired_at','paid_at','price','fee','total_price','status','payment_channel_id','transaction_id'];

    public function payment_channel()
    {
        return $this->belongsTo(PaymentChannel::class);
    }
}
