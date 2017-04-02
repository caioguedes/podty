<?php
namespace App\Http\Controllers;

use App\Podty\UserEpisodes;
use App\Podty\UserFavorites;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserFavoritesController extends Controller
{
    private $userFavorites;

    public function __construct(UserFavorites $userFavorites)
    {
        $this->userFavorites = $userFavorites;
    }

    public function all()
    {
        $favorites = $this->userFavorites->all(Auth::user()->name);
        $favorites = collect($favorites['data'] ?? []);

        return view('favorites')->with([
            'favorites' => $favorites
        ]);
    }

    public function create($episodeId)
    {
        if (Auth::user()) {
            $this->userFavorites->create(Auth::user()->name, $episodeId);
        }
    }

    public function delete($episodeId)
    {
        if (Auth::user()) {
            $this->userFavorites->delete(Auth::user()->name, $episodeId);
        }
    }
}
