<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawDetails extends Model
{
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->select('id','invoice_id');
    }
}
