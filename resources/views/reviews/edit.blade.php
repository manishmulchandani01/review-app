@extends('layouts.master')

@section('title')
    Edit Review
@endsection

@section('content')
    <h1>Edit Review</h1><br>
    @if (session('username_changed'))
        <div>
            <ul>
                <li>{{ session('username_changed') }}</li>
            </ul>
        </div>
    @endif
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ url('review/edit/action') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id" value={{ $review->id }}>
        <input type="hidden" name="item_id" value={{ $review->item_id }}>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" value="{{ old('username', $review->name) }}">
        </div><br>
        <div>
            <label for="rating">Rating:</label>
            <input type="number" name="rating" value="{{ old('rating', $review->rating) }}">
        </div><br>
        <div>
            <label for="review">Review:</label>
            <textarea name="review"> {{ old('review', $review->review) }}</textarea>
        </div><br>
        <div>
            <input type="submit" value="Edit Review"></input>
        </div>
    </form>
@endsection
