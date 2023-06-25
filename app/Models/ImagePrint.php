<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagePrint extends Model
{
    use HasFactory;

    protected $fillable = [
        'filepath',
        'expired_date',
        'item_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
