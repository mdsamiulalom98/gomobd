<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariable extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id')->select('id','name','stock','stock_alert','new_price');
    }
    public function image()
    {
        return $this->belongsTo(Productimage::class, 'product_id')->select('id', 'image', 'product_id')->latest();
    }
}
