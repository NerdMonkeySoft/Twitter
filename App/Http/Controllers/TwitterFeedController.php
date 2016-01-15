<?php namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Http\Traits\Environment;
use App\Views\TweetFeeds;

class TwitterFeedController
{
    use Environment;

    /**
     * @var Tweet
     */
    private $tweet;
    /**
     * @var TweetFeeds
     */
    private $view;

    /**
     * Instantiate the model and the view.
     */
    public function __construct()
    {
        $this->tweet = Tweet::getInstance();
        $this->view = TweetFeeds::getInstance();
    }

    /**
     * Get and render the tweets.
     *
     * If quantity not specified, fetch from env.
     *
     * @param null|int $quantity
     */
    public function get($quantity = null)
    {
        if (is_null($quantity))
        {
            $quantity = $this->env('feeds_quantity');
        }

        $this->view->toJson($this->tweet->getFeeds($quantity));
    }
}