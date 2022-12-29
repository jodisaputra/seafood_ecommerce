<?php

namespace App\Http\Controllers;
use DataTables;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Product::with(['category'])->get();
            return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="'. route('product.gallery.index', $row->id) .'" class="btn btn-info btn-sm">Gallery</a>';
                        $btn .= '<a href="'. route('product.edit', $row->id) .'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>';
                        $btn .= "
                            <form action='". route('product.destroy', $row->id) ."' class='d-inline' method='POST'>
                                ". csrf_field() ."
                                ". \method_field('DELETE') ."
                                <button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\"><i class='fas fa-trash'></i> Delete</button>
                            </form>
                        ";
                        return $btn;
                    })
                    ->addColumn('category', function($row) {
                        return $row->category->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('pages.admin.product.index', [
            'action' => route('product.create')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('pages.admin.product.form', [
            'action' => route('product.store'),
            'back' => route('product.index'),
            'type' => 'add',
            'title' => old('title'),
            'slug' => old('slug'),
            'description' => old('description'),
            'category' => old('category'),
            'category_list' => $category,
            'price' => old('price'),
            'stock' => old('stock')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'slug' => 'required',
            'category' => 'required',
            'price' =>'required|numeric',
            'stock' => 'required|numeric'
        ]);

       Product::create([
            'title'     => $request->title,
            'slug'     => $request->slug,
            'description' => $request->description,
            'category_id' => $request->category,
            'price'     => $request->price,
            'stock' => $request->stock
        ]);

        Alert::toast('Berhasil Disimpan', 'success');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $product = Product::find($id);
        return view('pages.admin.product.form', [
            'action' => route('product.update', $id),
            'back' => route('product.index'),
            'type' => 'edit',
            'title' => old('title', $product->title),
            'slug' => old('slug', $product->slug),
            'description' => old('description', $product->description),
            'category' => old('category', $product->category_id),
            'category_list' => $category,
            'price' => old('price', $product->price),
            'stock' => old('stock', $product->stock)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $this->validate($request, [
            'title'     => 'required',
            'slug' => 'required',
            'category' => 'required',
            'price' =>'required|numeric',
            'stock' => 'required|numeric'
        ]);

       $product->update([
            'title'     => $request->title,
            'slug'     => $request->slug,
            'description' => $request->description,
            'category_id' => $request->category,
            'price'     => $request->price,
            'stock' => $request->stock
        ]);

        Alert::toast('Berhasil Diubah', 'success');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        Alert::toast('Berhasil Dihapus', 'success');
        return redirect()->route('product.index');
    }

    public function gallery(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        if($request->ajax())
        {
            $data = ProductGallery::with('product')->where('product_id', $product_id)->get();
            return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn .= "
                            <form action='". route('product.gallery.destroy', [$row->product_id, $row->id]) ."' class='d-inline' method='POST'>
                                ". csrf_field() ."
                                ". \method_field('DELETE') ."
                                <button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\"><i class='fas fa-trash'></i> Delete</button>
                            </form>
                        ";
                        return $btn;
                    })
                    ->addColumn('image', function($row){
                        $image = '<img src="' . $row->image. '" class="rounded" style="width: 50px">';
                        return $image;
                    })
                    ->rawColumns(['image','action'])
                    ->make(true);
        }
        return view('pages.admin.product.gallery', [
            'action' => route('product.gallery.create', $product_id),
            'back' => route('product.index'),
            'title' => $product->title,
            'product' => $product
        ]);
    }

    public function gallery_create(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        return view('pages.admin.product.form_gallery', [
            'action' => route('product.gallery.store'),
            'back' => route('product.gallery.index', $product_id),
            'title' => $product->title,
            'product_id' => $product_id,
        ]);
    }

    public function gallery_store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg',
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/product', $image->hashName());

        ProductGallery::create([
            'product_id' => $request->product_id,
            'image'     => $image->hashName(),
        ]);

        Alert::toast('Berhasil Disimpan', 'success');
        return redirect()->route('product.gallery.index', $request->product_id);
    }

    public function gallery_destroy($product_id, $gallery_id)
    {
        $productGallery = ProductGallery::find($gallery_id);
        Storage::delete('public/product/'. $productGallery->image);
        $productGallery->delete();

        Alert::toast('Berhasil Dihapus', 'success');
        return redirect()->route('product.gallery.index', ['product_id' => $product_id]);
    }
}
