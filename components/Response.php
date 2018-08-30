<?php
    class Response {
        public static function redirect ($uri, $data = null){
            if($data) {
                $_SESSION['data'] = $data;
            }

            header('Location: /' . $uri);
            exit;
        }

        public static function notFound404() {
            header("HTTP/1.0 404 Not Found");
        }
    }
?>
