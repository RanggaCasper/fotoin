<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteConf extends Model
{
    use HasFactory;
    
    protected $table = 'website_conf';

    protected $fillable = ['conf_key','conf_value'];

    public $timestamps = false; 
}
