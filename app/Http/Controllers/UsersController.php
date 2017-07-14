<?php
namespace App\Http\Controllers;

use App\Http\Middleware\AjaxAuth;
use App\Podty\Users;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private $usersApi;

    public function __construct(Users $usersApi)
    {
        $this->middleware(AjaxAuth::class);
        $this->usersApi = $usersApi;
    }

    public function get()
    {
        return $this->usersApi->get(Auth::user()->name)['data'];
    }

    public function touch()
    {
        $this->usersApi->touch(Auth::user()->name);
    }

}
