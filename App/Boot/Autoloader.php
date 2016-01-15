<?php

class Autoloader
{
    /**
     * Array of the registered callable autoloads.
     *
     * @var array
     *
     */
    private $autoLoads = [];
    
    /**
     * Register new loader.
     * 
     * @param string $name
     * @param callable $loader
     * @throws Exception
     */
    public function register($name, $loader)
    {
        if (is_callable($loader))
        {
            $this->autoLoads[$name] = $loader;
            return;
        }

        throw new Exception("Loader ($name) must be callable.");
    }

    /**
     * Autoload the given class.
     *
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function load($name)
    {
        $path = $this->createPath($name);

        if (file_exists($path))
        {
            return require($path);
        }

        throw new Exception("Sorry, $name could not be loaded");
    }

    /**
     * Create a file path for the given name.
     *
     * @param string $name
     * @return string
     */
    private function createPath($name)
    {
        return BASEPATH . '/' . str_replace('\\', '/', $name) . '.php';
    }
}
