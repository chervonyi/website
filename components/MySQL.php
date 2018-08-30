<?php
    class MySQL {
        private static $result;
        private static $affected_rows;
        private static $insert_id;

        public static function fetchTable($sql) {
            // Get connection to database
            $conn = Connection::getConnection();

            // Execute query
            self::$result = $conn->query($sql);

            $resArray = array();
            while($row = self::$result->fetch_assoc()) {
                $resArray[] = $row;
            }

            return $resArray;
        }


        public static function fetchOneRow($sql) {
            // Get connnection to database
            $conn = Connection::getConnection();

            // Execute query
            self::$result = $conn->query($sql);

            if ($row = self::$result->fetch_assoc()) {
                // Return one row from table
                return $row;
            }

            return false;
        }

        public static function fetchSingleField($sql) {
            // Get connnection to database
            $conn = Connection::getConnection();

            // Execute query
            self::$result = $conn->query($sql);

            if ($row = self::$result->fetch_array(MYSQLI_NUM)) {
                // Return one first (single) field from row
                return $row[0];
            }
            return false;
        }



        public static function nonQuery($sql) {
            // Get connnection to database
            $conn = Connection::getConnection();

            // Execute query
            self::$result = $conn->query($sql);

            // Get a insert id
            self::$insert_id = $conn->insert_id;

            // Get affected rows
            self::$affected_rows = $conn->affected_rows;

            // Return count of affected rrows
            return self::$affected_rows;
        }

        public static function getAffectedRows() {
            return self::$num_rows;
        }

        public static function getInsertId() {
            return self::$insert_id;
        }


        public static function multiQuery($sql) {
            // Get connnection to database
            $conn = Connection::getConnection();

            if ($conn->multi_query($sql)) {
                return true;
            }
            return false;
        }


        public static function getRealEscapeString($string) {
			// Get connection
			$conn = Connection::getConnection();

			// Escape special symbols
			return $conn->real_escape_string($string);
		}
    }
?>
