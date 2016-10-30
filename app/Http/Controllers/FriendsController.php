<?php
namespace App\Http\Controllers;

use App\Podty\ApiClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function all()
    {
        $response = collect($this->getContentFrom('users/'. Auth::user()->name .'/friends'));

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
        $response = $this->getContentFrom('users/' . $user);

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
        $response = (new ApiClient)->get($source);

        if (!$response) {
            return [];
        }

        return $response['data'];
    }
}
