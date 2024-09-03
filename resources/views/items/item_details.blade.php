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
    <a href="{{ url("item/$item->id/add_review") }}">Add Review</a><br>
    <a href="{{ url("delete_item_action/$item->id") }}">Delete Item</a><br>
    <a href="{{ url("item_update/$item->id") }}">Update Item</a><br>
@endsection
