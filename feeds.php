<?php

define('BASEPATH', __DIR__);

include (BASEPATH . '/App/Boot/Bootstrap.php');

$twitter = new \App\Http\Controllers\TwitterFeedController();
$twitter->get();