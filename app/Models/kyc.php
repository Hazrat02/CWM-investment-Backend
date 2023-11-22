<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasOne;
class kyc extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    protected $fillable = [
        'user_id',
        
        'type',
  
        'id_front',
        'id_back',
        'id_file',
        'id_status',


        'ad_front',
        'ad_back',
        'ad_file',
        'ad_status',

        'se_front',
        'se_back',
        'se_file',
        'se_status',

        'ot_front',
        'ot_back',
        'ot_file',
        'ot_status',

        'country',
        'city',
        'address',
        'postel',

    
       
    ];



    
    // public function method(): HasOne
    // {
    //     return $this->HasOne(payment::class,'id','method');
    // }
}
