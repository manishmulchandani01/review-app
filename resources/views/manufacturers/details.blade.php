@extends('layouts.master')

@section('title')
    Manufacturer Details
@endsection

@section('content')
    <h1>Manufacturer Details</h1><br>
    <p><strong>Name: {{ $manufacturer->name }}</strong></p>
    <p>Items:</p>
    @if ($items)
        <ul>
            @foreach ($items as $item)
                <li><a href="{{ url("item/$item->id") }}">{{ $item->name }}</a> (Average
                    Rating: {{ $item->avg_rating ? number_format($item->avg_rating, 1) : '-' }})</li>
            @endforeach
        </ul>
    @else
        <p>No data.</p>
    @endif
@endsection
