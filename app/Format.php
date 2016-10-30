<?php
namespace App;


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
}
