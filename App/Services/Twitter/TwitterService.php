<?php namespace App\Services\Twitter;

use App\Http\Traits\Curl;
use App\Http\Traits\Environment;
use App\Interfaces\SingleInstance;

class TwitterService implements TwitterInterface, SingleInstance
{

    use Curl, Environment;
    /**
     * @var null|self
     */
    protected static $instance;

    /**
     * @var OAuth
     */
    private $authentication;

    /**
     * Setup the OAuth authentication.
     */
    protected function __construct()
    {
        $this->authentication = new OAuth();
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
            $class = get_called_class();

            self::$instance = new $class();
        }

        return self::$instance;
    }

    /**
     * Get the Twitter Feeds.
     *
     * @param int $quantity
     * @return mixed
     */
    public function getFeed($quantity)
    {

        $token = $this->authentication->token();

        $response = $this->curl($this->getCurlArrayOptions($quantity, $token));

        return json_decode($response);
    }

    /**
     * Get the curl Array Options.
     *
     * @param int $quantity
     * @param array $token
     * @return array
     */
    private function getCurlArrayOptions($quantity, $token)
    {
        return [
            CURLOPT_URL            => $this->getCurlArrayOptionsUrl($quantity),
            CURLOPT_HTTPHEADER     => $this->getCurlArrayOptionsHeaders($token),
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ];
    }

    /**
     * Generate curl array url option.
     *
     * @param int $quantity
     * @return string
     */
    private function getCurlArrayOptionsUrl($quantity)
    {
        return $this->env('user_timeline_api') . '?' . http_build_query([
            'count' => $quantity,
            'screen_name' => $this->env('screen_name')
        ]);
    }

    /**
     * Generate curl array headers option.
     *
     * @param string $token
     * @return array
     */
    private function getCurlArrayOptionsHeaders($token)
    {
        return ['Authorization: Bearer ' . $token];
    }
}