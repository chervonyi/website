<?php
	class Router {

		private $routes;

		function __construct() {
			$routesPath = 'config/routes.php';
			$this->routes = include($routesPath);
		}

		public function run() {
			// Get actual uri
			$uri = $this->getUri();

			// Loop for array of routes
			foreach ($this->routes as $uriPattern => $path) {
				// Check on equality actual uri with saved
				if(preg_match("~$uriPattern~", $uri)) {
					$internalRoutes = preg_replace("~$uriPattern~", $path, $uri);

					// Split uriPattern on parts
					$parts = explode('/', $internalRoutes);

					// Set name of controller class
					$controllerName = array_shift($parts) . 'Controller';
					$controllerName = ucfirst($controllerName);

					// Set name of action method
					$actionName = 'action' . ucfirst(array_shift($parts));

					// Connect necessary controller file
					$controllerFile = 'controllers/' . $controllerName . '.php';

					if (file_exists($controllerFile)) {
						include_once($controllerFile);

						// Create object of controller Class
						$controllerObject = new $controllerName;

						// Run an appropriate method
						if(call_user_func_array(array($controllerObject, $actionName), $parts)) {
							break;
						}
					}


				}
			}
		}

		private function getUri() {
			if (!empty($_SERVER['REQUEST_URI'])) {
				return trim($_SERVER['REQUEST_URI'], '/');
			}
		}
	}
?>
