<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelance extends Model
{
    use HasFactory;

    protected $table = 'freelance';

    protected $fillable = ['about','foto_ktp','selfie_ktp','nik','alamat','kode_pos','kelurahan','kecamatan','kota','status','no_rekening','jenis_rekening','user_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = true; 
}
