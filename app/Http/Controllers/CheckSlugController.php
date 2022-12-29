<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CheckSlugController extends Controller
{
    public function check_slug_category()
    {
        $slug = SlugService::createSlug(Category::class, 'slug', request('name'));
        return response()->json(['slug' => $slug]);
    }

    public function check_slug_product()
    {
        $slug = SlugService::createSlug(Product::class, 'slug', request('title'));
        return response()->json(['slug' => $slug]);
    }
}
