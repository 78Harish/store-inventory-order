<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';

    const CREATED_AT = 'customer_created_at';
    const UPDATED_AT = 'customer_updated_at';

    protected $fillable = [
        'customer_name',
        'email',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
