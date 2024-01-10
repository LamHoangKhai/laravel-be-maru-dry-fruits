<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItems extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'order_items';
    public $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }
}
