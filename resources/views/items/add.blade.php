@extends('layouts.master')

@section('title')
    Add Item
@endsection

@section('content')
    <h1 class="text-center mb-4">Add Item</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <div class="card shadow p-2 mb-4">
        <div class="card-body">
            <form method="post" action="{{ url('item/add/action') }}">
                {{ csrf_field() }}
                <div class="mb-4">
                    <label for="name" class="form-label">Name:</label>
                    <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="type">Manufacturer Type:</label>
                    <select name="type" class="form-select">
                        <option value="existing" {{ old('type') == 'existing' ? 'selected' : '' }}>Existing Manufacturer
                        </option>
                        <option value="new" {{ old('type') == 'new' ? 'selected' : '' }}>New Manufacturer</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="manufacturer_id">Existing Manufacturer</label>
                    <select name="manufacturer_id" class="form-select">
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}"
                                {{ old('manufacturer_id') == $manufacturer->id ? 'selected' : '' }}>
                                {{ $manufacturer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="manufacturer_name">New Manufacturer:</label>
                    <input class="form-control" type="text" name="manufacturer_name"
                        value="{{ old('manufacturer_name') }}">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="name">Year (optional):</label>
                    <input class="form-control" type="number" name="year" value="{{ old('year') }}">
                </div>
                <div class="text-center">
                    <input type="submit" value="Add Item" class="btn btn-success"></input>
                </div>
            </form>
        </div>
    </div>
@endsection
