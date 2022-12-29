<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Category;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
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
            $data = Category::all();
            return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="'. route('category.edit', $row->id) .'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>';
                        $btn .= "
                            <form action='". route('category.destroy', $row->id) ."' class='d-inline' method='POST'>
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
        return view('pages.admin.category.index', [
            'action' => route('category.create')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.category.form', [
            'action' => route('category.store'),
            'back' => route('category.index'),
            'type' => 'add',
            'name' => old('name'),
            'slug' => old('slug'),
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
            'image'     => 'required|image|mimes:jpeg,png,jpg',
            'name'     => 'required',
            'slug' => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/category', $image->hashName());

        Category::create([
            'name'     => $request->name,
            'slug'     => $request->slug,
            'image'     => $image->hashName(),
        ]);

        Alert::toast('Berhasil Disimpan', 'success');
        return redirect()->route('category.index');
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
        $category = Category::find($id);
        return view('pages.admin.category.form', [
            'action' => route('category.update', $id),
            'back' => route('category.index'),
            'type' => 'edit',
            'name' => old('name', $category->name),
            'slug' => old('slug', $category->slug),
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
        $category = Category::find($id);
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,png,jpg',
            'name'     => 'required',
            'slug' => 'required'
        ]);

        // upload image
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image->storeAs('public/category', $image->hashName());

            //delete old image
            Storage::delete('public/category/'.$category->image);

            $category->update([
                'name'     => $request->name,
                'slug'     => $request->slug,
                'image'     => $image->hashName(),
            ]);
        }
        else
        {
            $category->update([
                'name'     => $request->name,
                'slug'     => $request->slug
            ]);
        }

        Alert::toast('Berhasil Diubah', 'success');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        Storage::delete('public/category/'. $category->image);
        $category->delete();

        Alert::toast('Berhasil Dihapus', 'success');
        return redirect()->route('category.index');
    }
}
