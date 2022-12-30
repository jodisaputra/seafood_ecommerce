<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class DefaultController extends Controller
{
    public function index()
    {
        // $product = Product::with(['gallery', 'category'])->orderBy('id', 'desc')->paginate(5);
        $category = Category::orderBy('id', 'desc')->paginate(5);
        // header('Content-Type: application/json');
        // echo json_encode($category);
        // die;
        return view('pages.index', compact('category'));
    }

    public function find_product_by_category(Request $request, $slug = NULL)
    {
        if($slug == null) {
            $product = Product::with(['gallery', 'category'])->get();
        } else {
            $product = Product::with(['gallery', 'category' => function($q) use($slug) {
                $q->where('slug', '=', $slug);
            }])->get();
        }
        $category = Category::orderBy('id', 'desc')->get();
        return view('pages.shop', compact('category', 'product'));
    }
}
