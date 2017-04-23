<?php
// Require configuration of app
require_once("config.php");

// Require autloader
require_once("/vendor/autoload.php");

// Create new instance of app
$application = new App\Utilities\Bootstrap();

// Run app
$application->run();

//$application->restart();

