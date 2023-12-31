<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'orders';
    public $guarded = [];

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'order_id');
    }

 

    public function order_items()
    {
        return $this->hasMany(OrderItems::class)->withTrashed()->with("product");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
