@extends('layouts.app')
@section('title', 'Seafood | Product')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ $back }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>

                    <div class="card-body">
                        <form action="{{ $action }}" method="post">
                            @csrf

                            @if ($type == 'edit')
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title"
                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ $title }}">
                                @error('title')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug"
                                    class="form-control @error('slug') is-invalid @enderror" name="slug"
                                    value="{{ $slug }}">
                                @error('slug')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" id="description"
                                    class="form-control @error('description') is-invalid @enderror" name="description">{{ $description }}</textarea>
                                @error('description')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control @error('Category') is-invalid @enderror">
                                    @foreach($category_list as $cat)
                                        <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : null }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" id="price"
                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                    value="{{ $price }}">
                                @error('price')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            {{-- <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="text" id="stock"
                                    class="form-control @error('stock') is-invalid @enderror" name="stock"
                                    value="{{ $stock }}">
                                @error('stock')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div> --}}

                            <button type="submit"
                                class="btn btn-primary">{{ $type == 'add' ? 'Submit' : 'Save Changes' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#title').change(function() {
            $.get('{{ url('check_slug_product') }}', {
                    'title': $(this).val()
                },
                function(data) {
                    $('#slug').val(data.slug);
                }
            );
        });
    </script>
@endpush
