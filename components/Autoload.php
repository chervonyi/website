<?php

    function __autoload ($class_name) {
        // List of all the class directions
        $array_path = array(
            'models/',
            'components/'
        );

        foreach ($array_path as $path) {
            $path = $path . $class_name . '.php';
            if (file_exists($path)) {
                include_once($path);
                break;
            }
        }
    }

?>
