@extends('layouts.master')

@section('title')
    Edit Review
@endsection

@section('content')
    <h1 class="text-center mb-4">Edit Review</h1>
    @if (session('username_changed'))
        <div class="alert alert-danger" role="alert">
            {{ session('username_changed') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="{{ url('review/edit/action') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value={{ $review->id }}>
                <input type="hidden" name="item_id" value={{ $review->item_id }}>
                <div class="mb-4">
                    <label class="form-label" for="username">Username:</label>
                    <input class="form-control" type="text" name="username" value="{{ old('username', $review->name) }}">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="rating">Rating:</label>
                    <input class="form-control" type="number" name="rating" value="{{ old('rating', $review->rating) }}">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="review">Review:</label>
                    <textarea class="form-control" name="review"> {{ old('review', $review->review) }}</textarea>
                </div>
                <div class="text-center">
                    <input class="btn btn-warning" type="submit" value="Edit Review"></input>
                </div>
            </form>
        </div>
    </div>
@endsection
