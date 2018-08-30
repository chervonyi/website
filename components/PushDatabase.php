<?php
    class PushDatabase {
        private $arraySql = null;
        private $lastDate = null;
        private $REPEAT = 20;

        function __construct() {
            $pathToSQL = "config/mysql.php";
            $this->arraySql = include($pathToSQL);

            // Get last used date in database
            $this->lastDate = $this->getLastDate();
        }

        public function push() {
            $array = array();

            // Loop for array of sql queries
            foreach ($this->arraySql as $value) {
                // Push into array result of increments SQL
                $array = array_merge($array, $this->incrementSQL($value));
            }

            // Display queries:
            foreach ($array as $value) {
                echo $value . '<br>';
            }
            echo count($array);

            // Make query;
            $sql = "";
            foreach ($array as $query) {
                $sql .= $query . ' ';
            }
            // Run query
            if(MySQL::multiQuery($sql)) {
                echo "true";
            }
        }


        private function incrementSQL($sql) {
            $resSqlArray = array();
            $pattern_date = '/20[0-9]{2}-[0-9]{2}-([0-9]{2})/';

            $incDate = $this->lastDate;

            $res = preg_match($pattern_date, $sql, $day);
            $day = $day[1];

            if ($day == 21) {
                $incDate = $this->changeDate($incDate, "+1");
            }

            // loop for N days for each sql queries
            for ($i=0; $i < $this->REPEAT; $i++) {
                // Get incremented date
                $incDate = $this->changeDate($incDate, "+2");

                // Replce incremented date into $sql
                $resSQl = preg_replace($pattern_date, $incDate, $sql);

                // Push resultSql into arraySql
                $resSqlArray[] = $resSQl;
            }

            // Return array of incremented Sql
            return $resSqlArray;
        }

        // Increment date on 1 day
        private function changeDate($date, $day) {
            $tmp = strtotime("$day day", strtotime($date));
            return date("Y-m-d", $tmp);
        }

        private function getLastDate() {
            // Make sql query
            $sql = "SELECT date_flight FROM flight_num ORDER BY date_flight DESC;";

            // Execute query and get last date_flight
            $lastDate = MySQL::fetchSingleField($sql);


            return $this->changeDate($lastDate, "-1");
        }
    }

?>
