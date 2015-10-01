<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class grabController extends Controller{

    public function postGrab(Request $request){

        $username = $request->input('username');

        if(!empty($username)){
            $username = str_replace(" ","",$username);
            $usernameArr = explode('@', $username);

            if($usernameArr[0] === ''){
                array_shift($usernameArr);
                return $this->setRequests($usernameArr);
            }
            return $this->setRequests($usernameArr);
        }else{
            return view('index', ['message' => 'please input @username']);
        }

    }

    public function setRequests($array){

        // set a timeout context
        $context = stream_context_create(array(
                'http' => array(
                    'timeout' => 10 // in seconds
                )
            )
        );
        $count = count($array);

        for($i = 0; $i < $count; $i++){

            $check = DB::select('select * from users where user_name = ?', [$array[$i]]);
            if(empty($check)){
                $requestType = $array[$i];
                $dataFile = @ file_get_contents("http://instagram.com/".$array[$i],  NULL, $context);
                $jsonData = $this->processData($dataFile, $requestType);
                $profileData = json_decode($jsonData);
                $profile = $profileData->entry_data->ProfilePage[0];
                $this->insertDBProfile($profile);
                return redirect('users');
            }else{
                echo 'user @'.$array[$i].' already was checked </br>';
            }

        }
    }

    function processData($dataFile, $requestType){
        $data_length = strlen($dataFile); // validate if $dataFile didn't come empty
        if( $data_length > 0 ){
            $start_position = strpos( $dataFile ,'{"static_root"' ); // start position
            $trimmed_before = trim( substr($dataFile, $start_position) ); // trim preceding content
            $end_position = strpos( $trimmed_before, '</script>'); // end position
            $trimmed = trim( substr( $trimmed_before, 0, $end_position) ); // trim content
            $jsonData = substr( $trimmed, 0, -1); // remove extra trailing ";"
            return $jsonData;
        } else {
            die(view('index', ['message' => "invalid username @$requestType"]));
        }
    }

    function insertDBProfile($profile){

        $username = $profile->user->username;
        $media = $profile->user->media->nodes;

        DB::insert('insert into users (user_name) values (?)', [$username]);
        $userId = DB::getPdo()->lastInsertId();

        $count = count($media);
        for($i = 0; $i < $count; $i++){
            DB::insert('insert into photos (url, caption, likes, comments, user_id) values (?,?,?,?,?)', [$media[$i]->display_src, $media[$i]->caption, $media[$i]->likes->count, $media[$i]->comments->count, $userId]);
        }

    }
}
