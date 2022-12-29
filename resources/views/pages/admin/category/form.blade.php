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
                        <form action="{{ $action }}" method="post">
                            @csrf

                            @if ($type == 'edit')
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" name="name"
                                    value="{{ $name }}">
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
