@extends('layouts.app')
@section('title', 'Seafood | Category')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ $back }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>

                    <div class="card-body">
                        <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf

                            @if ($type == 'edit')
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $name }}">
                                @error('name')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug"
                                    class="form-control @error('name') is-invalid @enderror" name="slug"
                                    value="{{ $slug }}">
                                @error('slug')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

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
        $('#name').change(function() {
            $.get('{{ url('check_slug') }}', {
                    'name': $(this).val()
                },
                function(data) {
                    $('#slug').val(data.slug);
                }
            );
        });
    </script>
@endpush
