<?php
namespace App\Http\Controllers;

use App\Podty\Users;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private $usersApi;

    public function __construct(Users $usersApi)
    {
        $this->usersApi = $usersApi;
    }

    public function get()
    {
        if (Auth::user()) {
            return $this->usersApi->get(Auth::user()->name)['data'];
        }
    }

    public function touch()
    {
        if (Auth::user()) {
            $this->usersApi->touch(Auth::user()->name);
        }
    }

}
