<?php
    class Ticket {
        public static function addTicket($people_id, $flight_num, $class, $type) {
            $people_id = MySQL::getRealEscapeString($people_id);
            $flight_num = MySQL::getRealEscapeString($flight_num);
            $class = MySQL::getRealEscapeString($class);

            // Add parameters: $type, like: 'bought' or 'reserved' in table 'ticket'!
            return MySQL::nonQuery("INSERT INTO ticket VALUES(NULL, $people_id, $flight_num, '$class', '$type')");
        }


    }
?>
