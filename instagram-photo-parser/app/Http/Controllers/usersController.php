<?php
namespace App\Http\Controllers;

use DB;

class usersController extends Controller{

    public function getUsers(){

        $results = DB::select('SELECT users.user_name, users.id,
                                COUNT(photos.id) AS countPhotos,
                                SUM(photos.likes) AS countLikes,
                                SUM(photos.comments) AS countComments
                                FROM photos
                                LEFT JOIN users
                                ON users.id=photos.user_id
                                GROUP BY user_name');

        return view('users', ['users' => $results]);

    }

}