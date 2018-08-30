<?php
    class View {
        public static $view = null;
        private static $variables = array();
        // Display views
        public static function render($view = null) {
            // Extract variables
            // Before: $variales['first_name']
            // After: $first_name;
            extract(self::$variables);

            // Make path to necessary file
            if($view) {
                $path = 'views/' . $view . '.php';
            } else {
                $path = 'views/' . self::$view . '.php';
            }

            // Include a view
            if (file_exists($path)) {
                require_once($path);
            } else {
                // 404
            }
        }

        public static function show($pathView, $variables = array()) {
            // Get paramters
            self::$variables = $variables;
            self::$view = $pathView;

            // Set path to template view
            $templatePath = 'views/layouts/main.php';

            // Open template view
            require_once($templatePath);
        }
    }

?>
