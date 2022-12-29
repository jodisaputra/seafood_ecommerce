<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $appends = ['image'];
    public function getImageAttribute()
    {
        $imageUrl = "";
        if (isset($this->attributes['image']) && $this->attributes['image'] != "") {
            $imageUrl = Storage::url('public/category/').$this->attributes['image'];
        }
        return $imageUrl;
    }
}
