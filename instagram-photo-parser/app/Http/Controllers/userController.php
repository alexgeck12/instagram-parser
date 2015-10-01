<?php
namespace App\Http\Controllers;

use DB;

class userController extends Controller{

    public function getUser($id){

        $username = DB::select('SELECT `user_name` FROM `users` WHERE id = ?',[$id]);
        $results = DB::select('SELECT * FROM `photos` WHERE photos.user_id = ?',[$id]);

        return view('user', ['user' => $results, 'username' => $username]);

    }

}