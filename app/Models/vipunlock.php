<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vipunlock extends Model
{
    use HasFactory;


    protected $fillable = [
        'vip_id',
        'type',
        'limit',
        
    ];
}
