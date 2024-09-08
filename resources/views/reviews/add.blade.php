@extends('layouts.master')

@section('title')
    Add Review
@endsection

@section('content')
    <h1 class="text-center mb-4">Add Review</h1>
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
    <div class="card shadow p-2 mb-4">
        <div class="card-body">
            <form method="post" action="{{ url('review/add/action') }}" onsubmit="return validateForm()">
                {{ csrf_field() }}
                <input type="hidden" name="item_id" value={{ $item_id }}>
                @if (!session()->has('username'))
                    <div class="mb-4">
                        <label class="form-label" for="username">Username:</label>
                        <input class="form-control" type="text" name="username" value="{{ old('username') }}">
                    </div>
                @else
                    <div class="mb-4">
                        <label class="form-label" for="username">Username:</label>
                        <input class="form-control" type="text" readonly name="username_readonly"
                            value="{{ session('username') }}">
                    </div>
                @endif
                <div class="mb-4">
                    <label class="form-label" for="rating">Rating:</label>
                    <input class="form-control" type="text" id="rating" name="rating" value="{{ old('rating') }}">
                    <div class="text-danger" id="error_rating"></div>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="review">Review:</label>
                    <textarea class="form-control" id="review" name="review">{{ old('review') }}</textarea>
                    <div class="text-danger" id="error_review"></div>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Add Review"></input>
                </div>
            </form>
        </div>
    </div>
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
