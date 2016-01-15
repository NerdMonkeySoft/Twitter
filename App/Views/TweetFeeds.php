<?php namespace App\Views;

use App\Interfaces\SingleInstance;

class TweetFeeds implements SingleInstance
{
    /**
     * @var null|$this
     */
    private static $instance;

    /**
     * Render data to Json and print.
     *
     * @param array $data
     */
    public function toJson($data)
    {
        print json_encode($data);
        exit;
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
        if(self::$instance == null)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Disable the constructor.
     */
    private function __construct()
    {

    }
}