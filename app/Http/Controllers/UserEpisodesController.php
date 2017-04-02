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

    public function detach($episodeId)
    {
        if (Auth::user()) {
            $this->userEpisode->detach(Auth::user()->name, $episodeId);
        }
    }

    public function detachAll($podcastId)
    {
        if(Auth::user()) {
            $this->userEpisode->detachAll(Auth::user()->name, $podcastId);
        }
        
    }

    public function favorite($episodeId)
    {
        if (Auth::user()) {
            $this->userEpisode->favorite(Auth::user()->name, $episodeId);
        }   
    }

    public function unfavorite($episodeId)
    {
        if (Auth::user()) {
            $this->userEpisode->unfavorite(Auth::user()->name, $episodeId);
        }
    }
}
