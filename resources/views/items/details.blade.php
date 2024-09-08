@extends('layouts.master')

@section('title')
    Item Details
@endsection

@section('content')
    <h1>Item Details</h1><br>
    @if (session('username_changed'))
        <div>
            <ul>
                <li>{{ session('username_changed') }}</li>
            </ul>
        </div>
    @endif
    @if (session('exisiting_review'))
        <div>
            <ul>
                <li>{{ session('exisiting_review') }}</li>
            </ul>
        </div>
    @endif
    <p><strong>Name: {{ $item->name }}</strong></p>
    <p>Manufacturer: {{ $manufacturer->name }}</p>
    @if ($item->year)
        <p>Year: {{ $item->year }}</p>
    @endif
    <h1>Reviews</h1><br>
    @if (count($reviews) > 0)
        <ul>
            @foreach ($reviews as $review)
                <li>
                    <strong>{{ $review->name }}</strong> ({{ $review->rating }}/5) on
                    {{ substr($review->created_at, 0, 10) }}<br>
                    Review: {{ $review->review }}<br>
                    @if (isset($review->possible_reasons) && $review->possible_reasons)
                        Possible Fake Review:<br>
                        <ul>
                            @foreach ($review->possible_reasons as $reason)
                                <li>
                                    {{ $reason }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <a href="{{ url("review/$review->id/edit") }}">Edit Review</a><br>
                </li>
            @endforeach
        </ul>
    @else
        <p>No reviews for this item.</p>
    @endif
    <a href="{{ url("review/add/$item->id") }}">Add Review</a><br>
    <a href="{{ url("item/$item->id/delete") }}">Delete Item</a><br>
@endsection
