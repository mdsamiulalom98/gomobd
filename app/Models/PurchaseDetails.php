<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;
     protected $guarded = [];
     
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id')->select('id','name','status','category_id');
    }
}
