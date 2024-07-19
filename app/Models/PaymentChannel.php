<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentChannel extends Model
{
    use HasFactory;

    protected $table = "payment_channel";

    protected $fillable = ['name','code','image','desc','is_qris','flat_fee','percent_fee','min_amount','max_amount'];
}
