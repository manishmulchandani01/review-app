@extends('layouts.master')

@section('title')
    Manufacturers List
@endsection

@section('content')
    <h1>All Manufacturers</h1><br>
    @if ($manufacturers)
        <ul>
            @foreach ($manufacturers as $manufacturer)
                <li><a href="{{ url("manufacturers/$manufacturer->id") }}">{{ $manufacturer->name }}</a> (Average
                    Rating: {{ $manufacturer->avg_rating ? number_format($manufacturer->avg_rating, 1) : '-' }})</li>
            @endforeach
        </ul>
    @else
        <p>No data.</p>
    @endif
@endsection
