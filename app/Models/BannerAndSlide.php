<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerAndSlide extends Model
{
    use HasFactory;
    public $table = 'banners_and_slides';
    public $guarded = [];
}
