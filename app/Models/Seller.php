<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
      'password', 'remember_token',
    ];

    public function seller_area()
    {
        return $this->belongsTo(District::class,'area','id');
    }
    public function orders()
    {
        return $this->hasMany(OrderDetails::class, 'seller_id', 'id')->latest();
    }
    
    public function withdraws()
    {
        return $this->hasMany(Withdraw::class, 'seller_id', 'id')->latest();
    }
}
