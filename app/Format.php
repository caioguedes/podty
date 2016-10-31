<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;


trait Format
{
    public function formatData($date)
    {
        return (new \DateTime($date))->format('d/m/Y H:i');
    }

    public function formatDateForHumans($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    private function formatPodcastName($podcastName)
    {
        $separators = ['-', '/', '|'];
        return explode('-', str_replace($separators, '-', $podcastName))[0];
    }

    private function formatEpisodes(Collection $episodes)
    {
        return $episodes->map(function($episode) {
            return [
                'id' => $episode['id'],
                'podcast_id' => $episode['feed_id'],
                'podcast_name' => $episode['feed_name'] ?? '',
                'title' => strip_tags($episode['title']),
                'link' => $episode['link'],
                'published_date' => $this->formatData($episode['published_date']),
                'content' => $episode['content'],
                'summary' => $episode['summary'] ?? '',
                'image' => $episode['image'] ? $episode['image'] : $episode['feed_image'] ?? '',
                'duration' => $episode['duration'],
                'media_url' => $episode['media_url'],
                'media_type' => $episode['media_type'],
            ];
        });
    }

    private function formatPodcasts(Collection $podcasts)
    {
        return $podcasts->map(function($podcast) {
            return [
                "id" => $podcast['id'],
                "name" => $this->formatPodcastName($podcast['name']),
                "url" => $podcast['url'],
                "thumbnail_30" => $podcast['thumbnail_30'],
                "thumbnail_60" => $podcast['thumbnail_60'],
                "thumbnail_100" => $podcast['thumbnail_100'],
                "thumbnail_600" => $podcast['thumbnail_600'],
                "total_episodes" => $podcast['total_episodes'],
                "listeners" => $podcast['listeners'],
                "last_episode_at" => $this->formatData($podcast['last_episode_at'])
            ];
        });
    }

    public function formatHomePodcasts($podcast)
    {
        return [
            "id" => $podcast['id'],
            "name" => $this->formatPodcastName($podcast['name']),
            "thumbnail_30" => $podcast['thumbnail_30'],
            "thumbnail_600" => $podcast['thumbnail_600'],
            "total_episodes" => $podcast['total_episodes'],
            "listen_all" => $podcast['listen_all'],
            "last_episode_at" => $this->formatData($podcast['last_episode_at'])
        ];
    }

    public function formatUser($user)
    {
        $dateLimit = (new \DateTime())->modify('-6 hour');
        $last_activity = new \DateTime($user['last_update']);
        return [
            'username' => $user['username'],
            'profile_url' => 'profile/' . $user['username'],
            'email' => $user['email'],
            'email_hash' => md5(strtolower(trim($user['email']))),
            'last_seen' => $this->formatDateForHumans($user['last_update']),
            'was_recently_active' => ($last_activity > $dateLimit) ? true : false
        ];
    }
}
