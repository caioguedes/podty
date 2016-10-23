<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function all()
    {
        $response = collect($this->getContentFrom(env('API_BASE_URL') . 'users/'. Auth::user()->name .'/friends'));

        $dateLimit = (new \DateTime())->modify('-6 hour');
        return $response->map(function($friend) use($dateLimit) {
            $last_activity = new \DateTime($friend['last_update']);
            return [
                'username' => $friend['username'],
                'profile_url' => 'profile/' . $friend['username'],
                'email' => $friend['email'],
                'email_hash' => md5(strtolower(trim($friend['email']))),
                'last_seen' => Carbon::createFromFormat('Y-m-d H:i:s',$friend['last_update'])->diffForHumans(),
                'was_recently_active' => ($last_activity > $dateLimit) ? true : false
            ];
        });
    }

    public function find($user)
    {
        $response = $this->getContentFrom(env('API_BASE_URL') . 'users/' . $user);

        $dateLimit = (new \DateTime())->modify('-1 day');

        $last_activity = new \DateTime($response['last_update']);

        return [
            'username' => $response['username'],
            'profile_url' => 'profile/' . $response['username'],
            'email' => $response['email'],
            'email_hash' => md5(strtolower(trim($response['email']))),
            'last_update' => $response['last_update'] ?? '',
            'was_recently_active' => ($last_activity > $dateLimit) ? true : false
        ];
    }

    private function getContentFrom($source)
    {
        $curl = curl_init($source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, env('API_AUTH_USER') . ":" . env('API_AUTH_PASS'));

        $data = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (!$data || $status_code >= 400) {
            return [];
        }

        return json_decode($data, true)['data'];
    }
}
