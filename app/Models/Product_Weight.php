<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Weight extends Model
{
    use HasFactory;
    protected $table = 'product_weight';
    protected $guarded = [];

    public function weight_tag()
    {
        return $this->belongsTo(WeighTag::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
