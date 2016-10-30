<?php

namespace App\Http\Controllers;

use App\Podty\UserEpisodes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserEpisodesController extends Controller
{
    private $userEpisode;

    public function __construct(UserEpisodes $userEpisode)
    {
        $this->userEpisode = $userEpisode;
    }

    public function touch($episodeId, $currentTime)
    {
        if (Auth::user()) {
            $this->userEpisode->touch(Auth::user()->name, $episodeId, $currentTime);
        }
    }
}
