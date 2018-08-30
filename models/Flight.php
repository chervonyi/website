<?php
    class Flight {
        private static $MAX_TICTETS = 5;

        public static function checkCityName($city) {
            $error = array();
            // Execute query
            $row = MySQL::fetchOneRow("SELECT * FROM city WHERE name = '$city'");

            // Check if returns someone
            if(!$row) {
                $error[] = 'Місто відправлення не дійсне.';
            }
            return $error;
        }

        public static function checkCountTickets($tickets) {
            $error = array();
            if ($tickets > self::$MAX_TICTETS) {
                $error[] = 'Максимальна кількість білетів для однійєї купівлі - ' . self::$MAX_TICTETS . '.';
            }
            return $error;
        }

        public static function checkDate($date) {
            $error = array();
            if ($date < date('Y-m-d')) {
                $error[] = 'Обрана дата не дійсна.';
            }
            return $error;
        }


        public static function searchFlights($direction_to, $date, $class, $seats) {
            // Escape special characters
            $direction_to = MySQL::getRealEscapeString($direction_to);
            $date = MySQL::getRealEscapeString($date);
            $class = MySQL::getRealEscapeString($class);
            $seats = MySQL::getRealEscapeString($seats);

            // Make sql query
            $sql = "SELECT f.ID, date_flight, time_flight, price_economy, price_business, duration, c.name AS 'city',
                            c.country, p.board_num, a.name, ABS(DATEDIFF(f.date_flight, '$date')) AS 'dates'
                    FROM flight_num AS f
                    JOIN city AS c
                    ON c.ID = f.city_to
                    JOIN plane AS p
                    ON p.ID = f.plane_id
                    JOIN airliner AS a
                    ON a.ID = p.airliner_id
                    WHERE c.name = '$direction_to'
                    AND $seats <= get_count_free_seats(f.ID, '$class')
                    AND  DATEDIFF(f.date_flight, CURRENT_DATE()) >= 1
                    ORDER BY dates
                    LIMIT 6";

            // Return table of information
            return MySQL::fetchTable($sql);
        }


        public static function getDuration($duration) {
            $hours = intdiv($duration, 60);
            $min = $duration % 60;

            if($min) {
                $min = $min . ' хв.';
            } else {
                $min = '';
            }

            if($hours) {
                $hours = $hours . ' год. ';
            } else {
                $hours = '';
            }

            return $hours . $min;
        }

        public static function getDate($date, $time, $duration) {
            return date('Y-m-d', strtotime('+' . $duration . ' minutes' ,strtotime($date . ' ' . $time)));
        }

        public static function getFlightByID($id) {
            $id = MySQL::getRealEscapeString($id);

            $sql = "SELECT f.ID, date_flight, time_flight, price_economy, price_business, duration, c.name AS 'city',
                            c.country, p.board_num, a.name, ABS(DATEDIFF(f.date_flight, '2017-05-25')) AS 'dates'
                    FROM flight_num AS f
                    JOIN city AS c
                    ON c.ID = f.city_to
                    JOIN plane AS p
                    ON p.ID = f.plane_id
                    JOIN airliner AS a
                    ON a.ID = p.airliner_id
                    WHERE f.ID = $id";

            return MySQL::fetchOneRow($sql);
        }
    }
?>
