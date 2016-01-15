<?php namespace App\Http\Helpers\Environment;

class Environment
{
    /**
     * @var Resources
     */
    private static $instance;

    /**
     * Constructor disabled.
     */
    private function __construct()
    {

    }

    /**
     * Return environment resources or instantiate if necessary.
     *
     * @return Resources
     */
    private static function instantiate()
    {
        if(self::$instance == null)
        {
            self::$instance = new Resources();
        }

        return self::$instance;
    }

    /**
     * Fetch environment variable for given name.
     *
     * @param string $name
     * @return string
     */
    public static function get($name)
    {
        return self::instantiate()->getVariable($name);
    }
}