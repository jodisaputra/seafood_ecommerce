<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductGallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getImageAttribute()
    {
        $imageUrl = "";
        if (isset($this->attributes['image']) && $this->attributes['image'] != "") {
            $imageUrl = Storage::url('public/product/').$this->attributes['image'];
        }
        return $imageUrl;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
