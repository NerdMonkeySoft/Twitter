<?php namespace App\Http\Traits;

trait Environment
{
    /**
     * Fetch environment variable for the given name.
     *
     * @param string $name
     * @return string
     */
    public function env($name)
    {
        return \App\Http\Helpers\Environment\Environment::get($name);
    }
}