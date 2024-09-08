@extends('layouts.master')

@section('title')
    Item List
@endsection

@section('content')
    <h1 class="text-center mb-4">All Desks</h1>
    @if ($items)
        <div class="card shadow p-2 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ url('/') }}"
                    class="d-flex flex-row justify-content-between gap-4 align-items-center">
                    <div class="row">
                        <div class="col-auto">
                            <label for="sort_by" class="form-label">Sort by:</label>
                            <select name="sort_by" class="form-select">
                                <option value="reviews" {{ request('sort_by') == 'reviews' ? 'selected' : '' }}>Number of
                                    Reviews
                                </option>
                                <option value="avg_rating" {{ request('sort_by') == 'avg_rating' ? 'selected' : '' }}>
                                    Average
                                    Rating
                                </option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="order_by" class="form-label">Order by:</label>
                            <select name="order_by" class="form-select">
                                <option value="desc" {{ request('order_by') == 'desc' ? 'selected' : '' }}>Descending
                                </option>
                                <option value="asc" {{ request('order_by') == 'asc' ? 'selected' : '' }}>Ascending
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <input type="submit" value="Sort" class="btn btn-primary"></input>
                    </div>
                </form>
            </div>
        </div>
        <h2 class="mb-4">Items</h2>
        <ul class="list-group shadow">
            @foreach ($items as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a class="text-decoration-none text-success" href="{{ url("item/$item->id") }}">{{ $item->name }}</a>
                    <div>
                        <span class="badge bg-secondary">Reviews:
                            {{ $item->reviews }}</span>
                        <span class="badge bg-warning text-black">
                            Average
                            Rating: {{ $item->avg_rating ? number_format($item->avg_rating, 1) : '-' }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info" role="alert">
            No data.
        </div>
    @endif
@endsection
