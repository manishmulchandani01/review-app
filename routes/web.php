<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $items = get_item_list();
    return view('items.list')->with('items', $items);
});

function get_item_list()
{
    $sql = "select item.*, count(review.id) as reviews, avg(review.rating) as avg_rating from item left join review on item.id = review.item_id group by item.id";
    $items = DB::select($sql);
    return $items;
}

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
    $manufacturers = get_manufacturer_list();
    return view('items.add')->with('manufacturers', $manufacturers);
});

function get_manufacturer_list()
{
    $sql = "select * from manufacturer";
    $manufacturers = DB::select($sql);
    return $manufacturers;
}

Route::post('item/add/action', function () {
    $name = request('name');
    $type = request('type');
    $manufacturer_id = request('manufacturer_id');
    $manufacturer_name = request('manufacturer_name');

    $errors = [];
    if (strlen($name) <= 2 || preg_match('/[-_+]/', $name)) {
        $errors['name'] = 'Item name must have more than 2 characters and cannot have the following symbols: -, _, +';
    }
    if ($type != 'existing') {
        if (strlen($manufacturer_name) <= 2 || preg_match('/[-_+]/', $manufacturer_name)) {
            $errors['manufacturer_name'] = 'Manufacturer name must have more than 2 characters and cannot have the following symbols: -, _, +.';
        }
    }
    if (count($errors) > 0) {
        return redirect(url("/item/add/new"))->withErrors($errors)->withInput();
    }

    $id = add_item($name, $type, $manufacturer_id, $manufacturer_name);
    if ($id) {
        return redirect(url("item/$id"));
    } else {
        die("Error while adding item.");
    }
});

function add_item($name, $type, $manufacturer_id, $manufacturer_name = null)
{
    if ($type !== 'existing') {
        $manufacturer_id = fetch_or_add_manufacturer($manufacturer_name);
    }

    $sql = "insert into item (manufacturer_id, name) values (?, ?)";
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

    $odd_num_eliminated_username = odd_num_eliminated_username($username);
    if ($odd_num_eliminated_username !== $username) {
        $usernameModifiedMessage = "Username was changed to $odd_num_eliminated_username";
        session()->flash('username_changed', "Username was changed from '$username' to '$odd_num_eliminated_username' due to containg odd number.");
    }

    $errors = [];
    if (strlen($odd_num_eliminated_username) <= 2 || preg_match('/[-_+]/', $odd_num_eliminated_username)) {
        $errors['username'] = 'Username must have more than 2 characters and cannot have the following symbols: -, _, +.';
    }
    if (count($errors) > 0) {
        return redirect(url("review/add/$item_id"))->withErrors($errors)->withInput(['username' => $odd_num_eliminated_username, 'rating' => $rating, 'review' => $review]);
    }

    $exisiting_review = check_user_multiple_review($item_id, $username);
    if ($exisiting_review) {
        session()->flash('exisiting_review', 'Review already exists for this user.');
        return redirect(url("item/$item_id"));
    }

    $id = add_review($item_id, $odd_num_eliminated_username, $rating, $review);
    if ($id) {
        return redirect(url("item/$item_id"));
    } else {
        die("Error while adding item.");
    }
});

function odd_num_eliminated_username($username)
{
    preg_match_all('/\d+/', $username, $all_matches);
    foreach ($all_matches[0] as $number) {
        if ($number % 2 !== 0) {
            $username = str_replace($number, '', $username);
        }
    }

    return $username;

}

function check_user_multiple_review($item_id, $username)
{
    $sql = "select id from review where item_id = ? and name = ?";
    $reviews = DB::select($sql, array($item_id, $username));
    if ($reviews) {
        return true;
    } else {
        return false;
    }
}

function add_review($item_id, $odd_num_eliminated_username, $rating, $review)
{
    $sql = "insert into review (id, item_id, name, rating, review) values (null, ?, ?, ?, ?)";
    DB::insert($sql, array($item_id, $odd_num_eliminated_username, $rating, $review));
    $id = DB::getPdo()->lastInsertId();
    return $id;
}

Route::get('review/{id}/edit', function ($id) {
    $review = get_review($id);
    return view('reviews.edit')->with('review', $review);
});

function get_review($id)
{
    $sql = "select * from review where id = ?";
    $reviews = DB::select($sql, array($id));
    if (count($reviews) != 1) {
        die("Something has gone wrong, invalid query or result: $sql");
    }
    $review = $reviews[0];
    return $review;
}

Route::post('review/edit/action', function () {
    $id = request('id');
    $username = request('username');
    $rating = request('rating');
    $review = request('review');

    $odd_num_eliminated_username = odd_num_eliminated_username($username);
    if ($odd_num_eliminated_username !== $username) {
        $usernameModifiedMessage = "Username was changed to $odd_num_eliminated_username";
        session()->flash('username_changed', "Username was changed from '$username' to '$odd_num_eliminated_username' due to containg odd number.");
    }

    $errors = [];
    if (strlen($odd_num_eliminated_username) <= 2 || preg_match('/[-_+]/', $odd_num_eliminated_username)) {
        $errors['username'] = 'Username must have more than 2 characters and cannot have the following symbols: -, _, +';
    }
    if (count($errors) > 0) {
        return redirect(url("review/$id/edit"))->withErrors($errors)->withInput(['username' => $odd_num_eliminated_username, 'rating' => $rating, 'review' => $review]);
    }

    $item_id = edit_review($id, $odd_num_eliminated_username, $rating, $review);
    if ($id) {
        return redirect(url("item/$item_id"));
    } else {
        die("Error while editing review.");
    }
});

function edit_review($id, $odd_num_eliminated_username, $rating, $review)
{
    $sql = "update review set name = ?, rating = ?, review = ? where id = ?";
    $result = DB::update($sql, array($odd_num_eliminated_username, $rating, $review, $id));
    if ($result) {
        $sql = "select item_id from review where id = ?";
        $reviews = DB::select($sql, array($id));
        $item_id = $reviews[0]->item_id;
        return $item_id;
    } else {
        die("Error while editing review.");
    }
}

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
