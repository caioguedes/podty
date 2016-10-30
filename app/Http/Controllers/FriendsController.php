<?php
namespace App\Http\Controllers;

use App\Format;
use App\Podty\ApiClient;
use App\Podty\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    use Format;

    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function all()
    {
        if(!Auth::user()) {
            return [];
        }

        $response = $this->users->friends(Auth::user()->name);

        $dateLimit = (new \DateTime())->modify('-6 hour');
        return $response->map(function($friend) use($dateLimit) {
            $last_activity = new \DateTime($friend['last_update']);
            return [
                'username' => $friend['username'],
                'profile_url' => 'profile/' . $friend['username'],
                'email' => $friend['email'],
                'email_hash' => md5(strtolower(trim($friend['email']))),
                'last_seen' => $this->formatDateForHumans($friend['last_update']),
                'was_recently_active' => ($last_activity > $dateLimit) ? true : false
            ];
        });
    }

    public function find($user)
    {
        $response = $this->users->get($user)['data'];

        $dateLimit = (new \DateTime())->modify('-1 day');

        $last_activity = new \DateTime($response['last_update']);

        return [
            'username' => $response['username'],
            'profile_url' => 'profile/' . $response['username'],
            'email' => $response['email'],
            'email_hash' => md5(strtolower(trim($response['email']))),
            'last_seen' => $this->formatDateForHumans($response['last_update']),
            'was_recently_active' => ($last_activity > $dateLimit) ? true : false
        ];
    }
}
