<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelance extends Model
{
    use HasFactory;

    protected $table = 'freelance';

    protected $fillable = ['about','foto_ktp','selfie_ktp','nik','alamat','kode_pos','provinsi','desa','kecamatan','kota','status','status_register','note_register','no_rekening','jenis_rekening','portofolio','user_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = true; 
}
