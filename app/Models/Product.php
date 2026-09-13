<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';

    protected $fillable = [
        'product_code',
        'product_name',
        'product_price',
        'product_tax_percent',
        'product_stock_on_hand',
        'product_threshold',
    ];


    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }
}