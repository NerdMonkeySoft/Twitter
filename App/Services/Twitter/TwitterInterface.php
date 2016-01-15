<?php namespace App\Services\Twitter;

interface TwitterInterface
{
    /**
     * @param int $quantity
     * @return mixed
     */
    public function getFeed($quantity);
}