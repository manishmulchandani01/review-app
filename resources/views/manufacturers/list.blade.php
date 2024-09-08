@extends('layouts.master')

@section('title')
    Manufacturers List
@endsection

@section('content')
    <h1 class="text-center mb-4">All Manufacturers</h1>
    @if ($manufacturers)
        <ul class="list-group shadow">
            @foreach ($manufacturers as $manufacturer)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a class="text-decoration-none text-success"
                        href="{{ url("manufacturers/$manufacturer->id") }}">{{ $manufacturer->name }}</a>
                    <span class="badge bg-warning text-black">
                        Average Rating: {{ $manufacturer->avg_rating ? number_format($manufacturer->avg_rating, 1) : '-' }}
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info" role="alert">
            No data.
        </div>
    @endif
@endsection
