@extends('layouts.master')

@section('title')
    Item Details
@endsection

@section('content')
    <h1 class="text-center mb-4">Item Details</h1>
    <div class="card shadow p-2 mb-4">
        <div class="card-body">
            <h2 class="card-title text-success">{{ $item->name }}</h2>
            <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-secondary" style="font-size: 16px">
                    Manufacturer: {{ $manufacturer->name }}
                </span>
                @if ($item->year)
                    <span class="badge bg-warning text-black" style="font-size: 16px">Year: {{ $item->year }}</span>
                @endif
            </div>
        </div>
    </div>
    <h2 class="mb-4">Reviews</h2>
    @if (session('username_changed'))
        <div class="alert alert-warning" role="alert">
            {{ session('username_changed') }}
        </div>
    @endif
    @if (session('exisiting_review'))
        <div class="alert alert-danger" role="alert">
            {{ session('exisiting_review') }}
        </div>
    @endif
    @if (count($reviews) > 0)
        <ul class="list-group">
            @foreach ($reviews as $review)
                <li class="list-group-item d-flex flex-column p-4">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <h4 class="m-0">{{ $review->name }}</h4>
                        @if (isset($review->possible_reasons) && $review->possible_reasons)
                            <span class="badge bg-danger">Possible Fake Review</span>
                        @endif
                    </div>
                    <span class="mt-2">Rating: ({{ $review->rating }}/5) on
                        {{ substr($review->created_at, 0, 10) }}</span>
                    <span>Review: {{ $review->review }}</span>
                    @if (isset($review->possible_reasons) && $review->possible_reasons)
                        <div class="mt-2">
                            <strong>Potential Reasons:</strong>
                            <ul class="list-group list-group-flush">
                                @foreach ($review->possible_reasons as $reason)
                                    <li class="list-group-item">{{ $reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <a class="mt-2 btn btn-warning btn-sm align-self-start"
                        href="{{ url("review/$review->id/edit") }}">Edit
                        Review</a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info" role="alert">
            No reviews for this item.
        </div>
    @endif
    <div class="mt-4 d-flex gap-2">
        <a href="{{ url("review/add/$item->id") }}" class="btn btn-primary">Add Review</a>
        <a href="{{ url("item/$item->id/delete") }}" class="btn btn-danger">Delete Item</a>
    </div>
@endsection
