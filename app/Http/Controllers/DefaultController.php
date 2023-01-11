<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
            $product = Product::with(['gallery', 'category'])->whereHas('category', function($q) use($slug) {
                $q->where('slug', '=', $slug);
            })->get();
        }
        $category = Category::orderBy('id', 'desc')->get();
        return view('pages.shop', compact('category', 'product'));
    }

    public function detail($slug)
    {
        $product = Product::with(['gallery', 'category'])->where('slug', $slug)->first();
        return view('pages.detail', compact('product'));
    }

    public function cart()
    {
        $carts = [];
        $total = 0;
        if(Auth::guard('customer')->check())
        {
            $carts = Cart::with(['product.gallery'])->where('customer_id', Auth::guard('customer')->user()->id)->get();
            foreach($carts as $cart)
            {
                $total += $cart['product']['price'] * $cart['qty'];
            }
        }
        // header('Content-type: application/json');
        // echo json_encode($carts);
        // die;

        return view('pages.cart', compact('carts', 'total'));
    }

    function add_to_cart(Request $request, $slug)
    {
        if(!Auth::guard('customer')->check()) {
            Alert::toast('Mohon login terlebih dahulu !', 'error');
            return redirect('login');
        }

        $product = Product::with(['gallery', 'category'])->where('slug', $slug)->first();

        $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->where('product_id', $product->id)->first();

        if($cart) {
            $qty = $cart->qty + 1;
            $cart->update([
                'qty' => $qty
            ]);
        } else {
            if($request->detail == 'detail') {
                $qty = $request->quantity;
            } else {
                $qty = 1;
            }
            Cart::create([
                'customer_id' => Auth::guard('customer')->user()->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $product->price
            ]);
        }

        Alert::toast('Added to cart !', 'success');
        return redirect()->back();
    }

    function update_cart(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->update([
            'qty' => $request->qty
        ]);
        Alert::toast('Cart updated !', 'success');
        return redirect()->back();
    }

    function remove_from_cart($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        Alert::toast('Product deleted from cart !', 'success');
        return redirect()->back();
    }
}
