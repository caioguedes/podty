<?php
namespace App\Http\Controllers;

use App\Format;
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

        return $response->map(function($friend){
            return $this->formatUser($friend);
        });
    }

    public function find($user)
    {
        $response = $this->users->get($user);

        if (!$response) {
            return response()->json("", 200);
        }

        return $this->formatUser($response['data']);
    }
}
