<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    const API_ROOT_URL = 'http://brnapi.us-east-1.elasticbeanstalk.com/v1/';

    public function all()
    {
        $response = collect($this->getContentFrom(self::API_ROOT_URL . 'users/'. Auth::user()->name .'/friends'));

        $dateLimit = (new \DateTime())->modify('-1 day');
        return $response->map(function($friend) use($dateLimit) {
            $last_activity = new \DateTime($friend['last_update']);
            return [
                'username' => $friend['username'],
                'profile_url' => 'profile/' . $friend['username'],
                'email' => $friend['email'],
                'email_hash' => md5(strtolower(trim($friend['email']))),
                'last_update' => $friend['last_update'],
                'was_recently_active' => ($last_activity > $dateLimit) ? true : false
            ];
        });
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
