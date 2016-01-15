<?php namespace App\Http\Helpers\Environment;

class Resources
{

    /**
     * Stores the environment variables.
     *
     * @var array
     */
    private $variables = [];

    /**
     * Fetch environment variables and store them in a attribute.
     */
    public function __construct()
    {
        $env = BASEPATH . '/env.ini';

        if (file_exists($env))
        {
            $this->variables = parse_ini_file($env);
        }
    }

    /**
     * Fetch the environment variable.
     *
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public function getVariable($name)
    {
        if(key_exists($name, $this->variables))
        {
            return $this->variables[$name];
        }

        throw new \Exception("Given environment variable ($name) does not exist.");
    }
}