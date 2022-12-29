@extends('layouts.app')
@section('title', 'Seafood | Produk Gallery ' . $title)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                Produk {{ $title }}
                            </div>
                            <div class="col-md-4 float-right">
                                <a href="{{ $back }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i>
                                    Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product_id }}">

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" id="image"
                                    class="form-control @error('image') is-invalid @enderror" name="image">
                                @error('image')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
