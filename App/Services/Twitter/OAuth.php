<?php namespace App\Services\Twitter;

use App\Http\Traits\Curl;
use App\Http\Traits\Environment;

class OAuth
{
    use Curl, Environment;

    /**
     * @var array
     */
    private $authData = [
        'consumer_key'        => null,
        'consumer_secret_key' => null,
        'access_token'        => null,
        'access_token_secret' => null,
        'apponly_oauth_api'   => null,

    ];

    /**
     * Initiate config.
     */
    public function __construct()
    {
        $this->config();
    }

    /**
     * Get the token.
     *
     * @return bool|array
     * @throws
     */
    public function token()
    {
        $token = $this->getBearerToken();

        if (!$token)
        {
            throw Exception("I was unable to get bearer token.");
        }

        return $token;
    }

    /**
     * Setup all necessary data.
     * return void
     */
    private function config()
    {
        foreach ($this->authData as $varName => $value)
        {
            $this->authData[$varName] = $this->env($varName);
        }
    }

    /**
     * Get the Bearer token.
     *
     * @return bool|array
     */
    private function getBearerToken()
    {
        $response = $this->curl($this->getCurlOptions());

        $data = json_decode($response);

        if ($data->token_type && $data->token_type == 'bearer')
        {
            return $data->access_token;
        }

        return false;
    }

    /**
     * Get available curl options.
     *
     * @return array
     */
    private function getCurlOptions()
    {
        return [
            CURLOPT_URL            => $this->authData['apponly_oauth_api'],
            CURLOPT_HTTPHEADER     => $this->createHeaders(),
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => "grant_type=client_credentials",
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ];
    }

    /**
     * Generate curl headers.
     *
     * @return array
     */
    private function createHeaders()
    {
        $authorizationHeader = base64_encode(urlencode($this->authData['consumer_key']) . ":" . urlencode($this->authData['consumer_secret_key']));

        return ['Authorization: Basic ' . $authorizationHeader, 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'];
    }

}