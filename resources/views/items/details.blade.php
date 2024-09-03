@extends('layouts.master')

@section('title')
    Item Details
@endsection

@section('content')
    <h3>Item Details</h3><br>
    @if (session('username_changed'))
        <div>
            <ul>
                <li>{{ session('username_changed') }}</li>
            </ul>
        </div>
    @endif
    <p><strong>Name: {{ $item->name }}</strong></p>
    <p>Manufacturer: {{ $manufacturer->name }}</p>
    <h3>Reviews</h3><br>
    @if (count($reviews) > 0)
        <ul>
            @foreach ($reviews as $review)
                <li>
                    <strong>{{ $review->name }}</strong> ({{ $review->rating }}/5) on
                    {{ substr($review->created_at, 0, 10) }}<br>
                    Review: {{ $review->review }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No reviews for this item.</p>
    @endif
    <a href="{{ url("review/add/$item->id") }}">Add Review</a><br>
    <a href="{{ url("item/$item->id/delete") }}">Delete Item</a><br>
@endsection
