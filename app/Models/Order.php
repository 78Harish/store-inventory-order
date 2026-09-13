<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    const CREATED_AT = 'order_created_at';
    const UPDATED_AT = 'order_updated_at';

    protected $fillable = [
        'order_customer_id',
        'order_subtotal',
        'order_tax',
        'order_grand_total',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
