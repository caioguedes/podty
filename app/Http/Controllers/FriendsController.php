<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    const API_ROOT_URL = 'http://brnapi.us-east-1.elasticbeanstalk.com/v1/';

    public function all()
    {
        $response = $this->getContentFrom(self::API_ROOT_URL . 'users/'. Auth::user()->name .'/friends');


        return array_map(function($friend){
            return [
                'username' => $friend['username'],
                'profile_url' => 'profile/' . $friend['username'],
                'email' => $friend['email'],
                'email_hash' => md5(strtolower(trim($friend['email']))),
            ];
        }, $response);
    }

    private function getContentFrom($source)
    {
        $curl = curl_init($source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, 'brnbp' . ":" . 'brnbp');

        $data = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!$data || $status_code >= 400) {
            return [];
        }

        return json_decode($data, true)['data'];
    }
}
