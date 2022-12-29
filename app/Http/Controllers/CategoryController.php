<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;

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
                            <form action='". route('category.destroy', $row->id) ."' class='d-inline'>
                                ". csrf_field() ."
                                ". \method_field('DELETE') ."
                                <button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?')\"><i class='fas fa-trash'></i> Delete</button>
                            </form>
                        ";
                        return $btn;
                    })
                    ->addColumn('image', function($row){
                        return $row->image;
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
            'name' => old('name')
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
