<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function weightTags()
    {
        return $this->belongsToMany(WeighTag::class, 'product_weight', 'product_id', 'weight_tag_id');
    }

    public function product_weight()
    {
        return $this->hasMany(Product_Weight::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class)->with('user');
    }
    public function orderItems()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id');
    }
}
