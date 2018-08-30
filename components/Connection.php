<?php
	// Singleton of connection to database
	class Connection {
		private static $connection = null;

		static function connect () {
			$pathToConfig = 'config/database_parameters.php';
			$parameters = include($pathToConfig);

			$conn = new mysqli(
				$parameters['host'],
				$parameters['user'],
				$parameters['password'],
				$parameters['database']
			);

			return $conn;

		}

		public static function getConnection() {
			if (self::$connection == null) {
				self::$connection = self::connect();
			}
			return self::$connection;
		}
	}
?>
