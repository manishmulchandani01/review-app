@extends('layouts.master')

@section('title')
    Item List
@endsection

@section('content')
    <h1>All Desks</h1>
    @if ($items)
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
