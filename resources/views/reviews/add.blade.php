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
    <form method="post" action="{{ url('review/add/action') }}" onsubmit="return validateForm()">
        {{ csrf_field() }}
        <input type="hidden" name="item_id" value={{ $item_id }}>
        @if (!session()->has('username'))
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" value="{{ old('username') }}">
            </div><br>
        @else
            <div>
                <strong>Username: {{ session('username') }}</strong>
            </div><br>
        @endif
        <div>
            <label for="rating">Rating:</label>
            <input type="text" id="rating" name="rating" value="{{ old('rating') }}">
            <div id="error_rating"></div>
        </div><br>
        <div>
            <label for="review">Review:</label>
            <textarea id="review" name="review">{{ old('review') }}</textarea>
            <div id="error_review"></div>
        </div><br>
        <div>
            <input type="submit" value="Add Review"></input>
        </div>
    </form>
    <script>
        function validateForm() {
            document.getElementById('error_rating').innerText = '';
            document.getElementById('error_review').innerText = '';
            const rating = document.getElementById('rating').value;
            const review = document.getElementById('review').value;
            let isValid = true;
            if (rating < 1 || rating > 5 || isNaN(rating)) {
                document.getElementById('error_rating').innerText = 'Rating must be a number and between 1 to 5.';
                isValid = false;
            }
            if ((review.trim().split(' ').filter(word => word.length > 0)).length < 3) {
                document.getElementById('error_review').innerText = 'Review must contain more than 3 words.';
                isValid = false;
            }
            return isValid;
        }
    </script>
@endsection
