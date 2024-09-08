@extends('layouts.master')

@section('title')
    Item List
@endsection

@section('content')
    <h1>All Desks</h1><br>
    @if ($items)
        <form method="GET" action="{{ url('/') }}">
            <label for="sort_by">Sort by:</label>
            <select name="sort_by">
                <option value="reviews" {{ request('sort_by') == 'reviews' ? 'selected' : '' }}>Number of Reviews</option>
                <option value="avg_rating" {{ request('sort_by') == 'avg_rating' ? 'selected' : '' }}>Average Rating</option>
            </select>
            <label for="order_by">Order by:</label>
            <select name="order_by">
                <option value="desc" {{ request('order_by') == 'desc' ? 'selected' : '' }}>Descending</option>
                <option value="asc" {{ request('order_by') == 'asc' ? 'selected' : '' }}>Ascending</option>
            </select><br><br>
            <input type="submit" value="Sort"></input>
        </form><br>
        <ul>
            @foreach ($items as $item)
                <li><a href="{{ url("item/$item->id") }}">{{ $item->name }}</a> (Reviews: {{ $item->reviews }}, Average
                    Rating: {{ $item->avg_rating ? number_format($item->avg_rating, 1) : '-' }})</li>
            @endforeach
        </ul>
    @else
        <p>No data.</p>
    @endif
@endsection
