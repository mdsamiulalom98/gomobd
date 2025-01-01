<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id')->select('id','name','phone','address');
    }
    public function withdrawdetails()
    {
        return $this->hasMany(WithdrawDetails::class, 'withdraw_id');
    }
}
