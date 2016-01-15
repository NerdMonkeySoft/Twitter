<?php namespace App\Models;

use App\Services\Twitter\TwitterService;

class Tweet
{
    /**
     * @var null|$this
     */
    private static $instance;

    /**
     * @var TwitterService
     */
    private $twitterService;


    /*
     * Disable the constructor. Fetch Twitter Service.
     */
    private function __construct()
    {
        $this->twitterService = TwitterService::getInstance();
    }

    /**
     * Instantiate the class.
     *
     * Fetch existing instance or create a new one if necessary.
     *
     * @return $this
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }


    /**
     * Get Twitter feeds.
     *
     * @param int $quantity
     * @return array
     */
    public function getFeeds($quantity)
    {
        $feeds = $this->twitterService->getFeed($quantity);

        return $this->onlyNecessary($feeds);
    }

    /**
     * Filter tweets and return only necessary data.
     *
     * @param array $feeds
     * @return array
     */
    private function onlyNecessary($feeds)
    {
        $clearedFeeds = [];

        foreach ($feeds as $key => $tweet)
        {
            $clearedFeeds[$key]['username'] = $tweet->user->name;
            $clearedFeeds[$key]['screen_name'] = $tweet->user->screen_name;
            $clearedFeeds[$key]['profile_image'] = $tweet->user->profile_image_url;
            $clearedFeeds[$key]['tweet_content'] = $tweet->text;
            $clearedFeeds[$key]['retweeted'] = $tweet->retweet_count;
        }

        return $clearedFeeds;
    }
}