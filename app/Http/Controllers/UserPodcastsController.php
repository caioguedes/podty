<?php

namespace App\Http\Controllers;

use App\Podty\UserPodcasts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserPodcastsController extends Controller
{
    private $userPodcasts;

    public function __construct(UserPodcasts $userPodcasts)
    {
        $this->userPodcasts = $userPodcasts;
    }

    public function all()
    {
        return $this->userPodcasts->all(Auth::user()->name);
    }

    public function follow($podcastId)
    {
        Auth::user()->podcasts_count++;
        Auth::user()->save();

        if ($this->userPodcasts->follow(Auth::user()->name, $podcastId)) {
            return response('', 200);
        }

        return response('', 400);
    }

    public function unfollow($podcastId)
    {
        Auth::user()->podcasts_count--;
        Auth::user()->save();

        if ($this->userPodcasts->unfollow(Auth::user()->name, $podcastId)) {
            return response('', 200);
        }

        return response('', 400);
    }
}
