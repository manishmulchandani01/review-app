@extends('layouts.master')

@section('title')
    Manufacturer Details
@endsection

@section('content')
    <h1 class="text-center mb-4">Manufacturer Details</h1>
    <div class="card shadow p-2 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="card-title text-success">Name: {{ $manufacturer->name }}</h2>
            <span class="badge bg-warning text-black">Average Rating:
                {{ $manufacturer->avg_rating ? number_format($manufacturer->avg_rating, 1) : '-' }}</span>
        </div>
    </div>
    <h2 class="mb-4">Items</h2>
    @if ($items)
        <ul class="list-group shadow">
            @foreach ($items as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a class="text-decoration-none text-success" href="{{ url("item/$item->id") }}">{{ $item->name }}</a>
                    <span class="badge bg-warning text-black">
                        Average Rating: {{ $item->avg_rating ? number_format($item->avg_rating, 1) : '-' }}
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info" role="alert">
            No items for this manufacturer.
        </div>
    @endif
@endsection
