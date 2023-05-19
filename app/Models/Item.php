<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Image;
use App\Models\Size;


class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'information',
        'price',
        'size_id',
        'sort_order',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function images()
    // {
    //     return $this->hasMany(Image::class);
    // }

    public function imageFirst()
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }

    public function imageSecond()
    {
        return $this->belongsTo(Image::class, 'image2', 'id');
    }

    public function imageThird()
    {
        return $this->belongsTo(Image::class, 'image3', 'id');
    }

    public function imageFourth()
    {
        return $this->belongsTo(Image::class, 'image4', 'id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }



}
