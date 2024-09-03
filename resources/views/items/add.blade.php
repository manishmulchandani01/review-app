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
            <input type="text" name="name" required>
        </div><br>
        <div>
            <label for="manufacturer_name">Manufacturer Name:</label>
            <input type="text" name="manufacturer_name" required>
        </div><br>
        <div>
            <input type="submit" value="Add Item"></input>
        </div>
    </form>
@endsection
