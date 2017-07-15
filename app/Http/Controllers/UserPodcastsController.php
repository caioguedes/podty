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
        $podcastId = $this->normalizePodcastId($podcastId);
        
        if (!$podcastId) {
            return response('', 400);
        }

        Auth::user()->podcasts_count++;
        Auth::user()->save();

        if ($this->userPodcasts->follow(Auth::user()->name, $podcastId)) {
            return response('', 200);
        }

        return response('', 400);
    }

    public function unfollow($podcastId)
    {
        $podcastId = $this->normalizePodcastId($podcastId);

        if (!$podcastId) {
            return response('', 400);
        }

        Auth::user()->podcasts_count--;
        Auth::user()->save();

        if ($this->userPodcasts->unfollow(Auth::user()->name, $podcastId)) {
            return response('', 200);
        }

        return response('', 400);
    }

    private function normalizePodcastId($podcastId)
    {
        $podcastId = explode('-', $podcastId)[0];
    
        return is_numeric($podcastId) ? $podcastId : false;
    }


}
