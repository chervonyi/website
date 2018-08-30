<?php
	// Get Router class
	define('ROOT', dirname(__FILE__));

	// Start the session
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include('components/Autoload.php');

	// Create object of Router
	$router = new Router();
	// Start routing
	$router->run();

 ?>
