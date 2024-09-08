@extends('layouts.master')

@section('title')
    Add Review
@endsection

@section('content')
    <h1>Add Review</h1><br>
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
    <form method="post" action="{{ url('review/add/action') }}">
        {{ csrf_field() }}
        <input type="hidden" name="item_id" value={{ $item_id }}>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" value="{{ old('username') }}">
        </div><br>
        <div>
            <label for="rating">Rating:</label>
            <input type="number" name="rating" value="{{ old('rating') }}">
        </div><br>
        <div>
            <label for="review">Review:</label>
            <textarea name="review" required>{{ old('review') }}</textarea>
        </div><br>
        <div>
            <input type="submit" value="Add Review"></input>
        </div>
    </form>
@endsection
