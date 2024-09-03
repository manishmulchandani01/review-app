<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $sql = "select * from item";
    $items = DB::select($sql);
    return view('items.list')->with('items', $items);
});

Route::get('item/{id}', function ($id) {
    $item = get_item($id);
    $manufacturer = get_item_manufacturer($item->manufacturer_id);
    $reviews = get_item_reviews($id);
    return view('items.details')->with('item', $item)->with('manufacturer', $manufacturer)->with('reviews', $reviews);
});

function get_item($id)
{
    $sql = "select * from item where id = ?";
    $items = DB::select($sql, array($id));
    if (count($items) != 1) {
        die("Something has gone wrong, invalid query or result: $sql");
    }
    $item = $items[0];
    return $item;
}

function get_item_manufacturer($id)
{
    $sql = "select name from manufacturer where id = ?";
    $manufacturer = DB::select($sql, array($id));
    if (count($manufacturer) != 1) {
        die("Something has gone wrong, invalid query or result: $sql");
    }
    $manufacturer = $manufacturer[0];
    return $manufacturer;
}

function get_item_reviews($id)
{
    $sql = "select * from review where item_id = ?";
    $reviews = DB::select($sql, array($id));
    return $reviews;
}

Route::get('item/add/new', function () {
    return view('items.add');
});

Route::post('item/add/action', function () {
    $name = request('name');
    $manufacturer_name = request('manufacturer_name');

    $errors = [];
    if (strlen($name) <= 2 || preg_match('/[-_+]/', $name)) {
        $errors['name'] = 'Item name must have more than 2 characters and cannot have the following symbols: -, _, +';
    }
    if (strlen($manufacturer_name) <= 2 || preg_match('/[-_+]/', $manufacturer_name)) {
        $errors['manufacturer_name'] = 'Manufacturer name must have more than 2 characters and cannot have the following symbols: -, _, +.';
    }
    if (count($errors) > 0) {
        return redirect(url("/item/add/new"))->withErrors($errors);
    }

    $id = add_item($name, $manufacturer_name);
    if ($id) {
        return redirect(url("item/$id"));
    } else {
        die("Error while adding item.");
    }
});

function add_item($name, $manufacturer_name)
{
    $manufacturer_id = fetch_or_add_manufacturer($manufacturer_name);
    $sql = "insert into item values (null, ?, ?)";
    DB::insert($sql, array($manufacturer_id, $name));
    $id = DB::getPdo()->lastInsertId();
    return $id;
}

function fetch_or_add_manufacturer($manufacturer_name)
{
    $sql = "select id from manufacturer where name = ?";
    $manufacturer = DB::select($sql, array($manufacturer_name));
    if (count($manufacturer) > 0) {
        $manufacturer_id = $manufacturer[0]->id;
    } else {
        $sql = "insert into manufacturer values (null, ?)";
        $manufacturer = DB::insert($sql, array($manufacturer_name));
        $manufacturer_id = DB::getPdo()->lastInsertId();
    }
    return $manufacturer_id;
}

Route::get('review/add/{id}', function ($id) {
    return view('reviews.add')->with('item_id', $id);
});

Route::post('review/add/action', function () {
    $item_id = request('item_id');
    $username = request('username');
    $rating = request('rating');
    $review = request('review');

    $odd_num_eliminated_username = preg_replace('/[0-9]/', '', $username);
    if ($odd_num_eliminated_username !== $username) {
        $usernameModifiedMessage = "Username was changed to $odd_num_eliminated_username";
        session()->flash('username_changed', "Username was changed from '$username' to '$odd_num_eliminated_username' due to containg odd number.");
    }

    $errors = [];
    if (strlen($odd_num_eliminated_username) <= 2 || preg_match('/[-_+]/', $odd_num_eliminated_username)) {
        $errors['username'] = 'Username must have more than 2 characters and cannot have the following symbols: -, _, +';
    }
    if (count($errors) > 0) {
        return redirect(url("review/add/$item_id"))->withErrors($errors)->withInput(['username' => $odd_num_eliminated_username, 'rating' => $rating, 'review' => $review]);
    }

    $id = add_review($item_id, $odd_num_eliminated_username, $rating, $review);
    if ($id) {
        return redirect(url("item/$item_id"));
    } else {
        die("Error while adding item.");
    }
});

function add_review($item_id, $odd_num_eliminated_username, $rating, $review)
{
    $sql = "insert into review (id, item_id, name, rating, review) values (null, ?, ?, ?, ?)";
    DB::insert($sql, array($item_id, $odd_num_eliminated_username, $rating, $review));
    $id = DB::getPdo()->lastInsertId();
    return $id;
}

// item update to be deleted

Route::get('item_update/{id}', function ($id) {
    $item = get_item($id);
    return view('items.item_update')->with('item', $item);
});

Route::post('item_update_action', function () {
    $id = request('id');
    $summary = request('summary');
    $details = request('details');
    $result = update_item($id, $summary, $details);
    if ($result) {
        return redirect(url("item/$id"));
    } else {
        die("Error while updating item.");
    }
});

function update_item($id, $summary, $details)
{
    $sql = "update item set summary = ?, details = ? where id = ?";
    $result = DB::update($sql, array($summary, $details, $id));
    return $result;
}

// item update to be deleted

Route::get('item/{id}/delete', function ($id) {
    $result = delete_item($id);
    if ($result) {
        return redirect(url("/"));
    } else {
        die("Error while deleting item.");
    }
});

function delete_item($id)
{
    $sql = "delete from item where id = ?";
    $result = DB::delete($sql, array($id));
    return $result;
}
