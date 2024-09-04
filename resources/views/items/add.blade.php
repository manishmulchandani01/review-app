@extends('layouts.master')

@section('title')
    Add Item
@endsection

@section('content')
    <h3>Add Item</h3><br>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ url('item/add/action') }}">
        {{ csrf_field() }}
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" required value="{{ old('name') }}">
        </div><br>
        <div>
            <label for="type">Manufacturer Type:</label>
            <select name="type">
                <option value="existing" {{ old('type') == 'existing' ? 'selected' : '' }}>Existing Manufacturer</option>
                <option value="new" {{ old('type') == 'new' ? 'selected' : '' }}>New Manufacturer</option>
            </select>
        </div><br>
        <div>
            <label for="manufacturer_id">Existing Manufacturer</label>
            <select name="manufacturer_id">
                @foreach ($manufacturers as $manufacturer)
                    <option value="{{ $manufacturer->id }}"
                        {{ old('manufacturer_id') == $manufacturer->id ? 'selected' : '' }}>
                        {{ $manufacturer->name }}</option>
                @endforeach
            </select>
        </div><br>
        <div>
            <label for="manufacturer_name">New Manufacturer:</label>
            <input type="text" name="manufacturer_name" value="{{ old('manufacturer_name') }}">
        </div><br>
        <div>
            <input type="submit" value="Add Item"></input>
        </div>
    </form>
@endsection
