<?php
    class Alert {
        private static $message;
        private static $type;

        public static function alertMessage($message, $type) {
            $_SESSION['message'] = $message;
            $_SESSION['type'] = $type;
        }

        public static function unsetMessage() {
            unset($_SESSION['message']);
            unset($_SESSION['type']);
        }

        public static function getMessage() {
            if(isset($_SESSION['message'])) {
                return  $_SESSION['message'];
            }
            return false;
        }

        public static function getType() {
            if(isset($_SESSION['type'])) {
                return  $_SESSION['type'];
            }
            return false;
        }
    }
?>
