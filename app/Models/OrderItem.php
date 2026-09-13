<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'order_item_id';

    const CREATED_AT = 'order_item_created_at';
    const UPDATED_AT = 'order_item_updated_at';

    protected $fillable = [
        'order_id',
        'product_id',
        'order_quantity',
        'order_unit_price',
        'order_tax_percentage',
        'order_tax_amount',
        'order_line_total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
