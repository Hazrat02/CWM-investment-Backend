<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class vip extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'task',
        'duration',
        'icon'
    ];
    public function vipunlock(): HasMany
    {
        return $this->hasMany(vipunlock::class,'vip_id','id');
    }
}
