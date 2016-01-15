<?php namespace App\Http\Traits;


trait Curl
{
    /**
     * Perform curl with given options.
     *
     * @param array $options
     * @return response
     */
    protected function curl($options)
    {
        $ch = curl_init();

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        $this->curl_info = curl_getinfo($ch);

        $this->curl_error = curl_error($ch);

        curl_close($ch);

        return $response;
    }
}