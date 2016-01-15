<?php

/*
|-------------------------------------------------------------------------
| Register the autoloader
|-------------------------------------------------------------------------
|
| To provide a simple and yet convenient way to automatically load
| classes, a load function with the spl, an autoload queue was
| implemented.
|
*/

require ('Autoloader.php');

spl_autoload_register([new Autoloader(), 'load']);