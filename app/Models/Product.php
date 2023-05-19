<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Color;

class Product extends Model
{
    use HasFactory;


    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

}