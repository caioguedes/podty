<?php
namespace App;

use Illuminate\Support\Collection;


trait Format
{
    public function formatData($date)
    {
        return (new \DateTime($date))->format('d/m/Y H:i');
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
                'title' => strip_tags($episode['title']),
                'link' => $episode['link'],
                'published_date' => $this->formatData($episode['published_date']),
                'content' => $episode['content'],
                'summary' => $episode['summary'] ?? '',
                'image' => $episode['image'],
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
}
