<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\SizeDetail;

class Size extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function sizeDetail()
    {
        return $this->belongsTo(SizeDetail::class);
    }


}
