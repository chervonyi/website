<?php
	class User {
		public static function checkEmail($email) {
			// Create pattern for regular expression for email format
			// Email format: example@gmail.com.ua
			$pattern_email = '/\w+@[a-z]+(\.[a-z]{2,6}){1,4}$/';

			// Create array of errors
			$errorsOfEmail = array();

			// Check email with regualar expression
			if (!preg_match($pattern_email, $email)){
				$errorsOfEmail[] = 'Введена електронна пошта не відповідає вимогам. (example@gmail.com)';
			}

			// Check lenght of email (45 maxLength in DB)
			if (strlen($email) > 45) {
				$errorsOfEmail[] = 'Довжина електронної пошти надто велика. Максимальна довжина - 45 символів.';
			}

			return $errorsOfEmail;
		}

		public static function checkPassword($password) {
			// Create array of errors
			$errorsOfPassword = array();

			// Check min lenght of password
			$lenghtOfPassword = strlen($password);
			if ($lenghtOfPassword < 6) {
				$errorsOfPassword[] = 'Пароль повинен складатися не менше ніж 5 символів.';
			}

			// Check max lenght of password
			if ($lenghtOfPassword > 30) {
				$errorsOfPassword[] = 'Занадтно довгий пароль.  Максимальна довжина - 30 символів.';
			}

			return $errorsOfPassword;
		}

		public static function checkExist($email, $password) {
			// Get result of query
			$row = MySQL::fetchOneRow("SELECT * FROM user WHERE email = '$email' AND password = '$password'");

			// Check number of rows of result
			if($row) {
				// Return ID of user
				return intval($row['ID']);
			} else {
				return 'Неправильний адрес електронної пошти або ж пароль.';
			}
		}

		public static function authorization($userID) {
			// Set user ID
			$_SESSION['user'] = $userID;
		}

		public static function checkName($name) {
			// Create pattern of regualar expression for a names
			// First letter must be uppercase. Example: Alan Josh
			//$pattern = '/^\p{Lu}\p{Ll}+$/';
			$pattern = '/^[A-Z][a-z]+$/';

			// create array of errors
			$errors = array();

			// Check regular expression
			if(!preg_match($pattern, $name)) {
				$errors[] = "Пріщвище, ім'я та по батькові повинні розпочинатися з великих літер, та повинні бути написаними латиськими літерами.";
			}

			// Check length of name. (35 max in database)
			if(strlen($name) > 35) {
				$errors[] = 'Довжина прізвища, імені та по батькові не повинна перевищувати 35 символів.';
			}

			return $errors;
		}

		public static function checkPhoneNum($phoneNum) {
			// Create pattern of regular expression
			// 8 digital number
			// $pattern = '/^[0-9]{9}$/';
			$pattern = '/^\+380[0-9]{9}$/';

			// Create array of errors
			$errors = array();

			// Check regular expression
			if (!preg_match($pattern, $phoneNum)) {
				$errors[] = 'Номер телефону повинен складатися з 9 цифр. (Без урахування: +380..)';
			}

			return $errors;
		}

		public static function checkEmailExist($email) {
			$email = MySQL::getRealEscapeString($email);

			// Check number of rows of result
			if(!MySQL::fetchOneRow("SELECT * FROM user WHERE email = '$email'")) {
				// Email is not found in database
				return false;
			} else {
				// Email is exist in database
				return true;
			}
		}

		public static function register($first_name, $last_name, $middle_name,
			$phone_num, $email, $password) {
			// Escape speical characters
			$first_name = MySQL::getRealEscapeString($first_name);
			$last_name = MySQL::getRealEscapeString($last_name);
			$middle_name = MySQL::getRealEscapeString($middle_name);
			$phone_num = MySQL::getRealEscapeString($phone_num);
			$email = MySQL::getRealEscapeString($email);
			$password = MySQL::getRealEscapeString($password);

			// Execute query and check count of affected rows
			// If was successful inserting into people table
			if (MySQL::nonQuery("INSERT INTO people VALUES(NULL, '$first_name',
						'$last_name', '$middle_name', '$phone_num')")) {

				// Get generated id from previous query
				$people_id = MySQL::getInsertId();

				// Execute query and check count of affected rowsCheck if register a new user
				return MySQL::nonQuery("INSERT INTO user VALUES(NULL, '$email', '$password', '$people_id')") == 1;
			}
		}

		public static function isGuest() {
			// Check if user has been logged
			if(isset($_SESSION['user'])) {
				return false;
			}
			return true;
		}

		public static function getLogged() {
			// Check if user has been logged
			if(isset($_SESSION['user'])) {
				// Return ID of a user
				return $_SESSION['user'];
			}
			return false;
		}

		public static function getUserByID($ID) {
			// Escape special characters
			$ID = MySQL::getRealEscapeString($ID);

			// Make a sql query
			$sql = "SELECT u.ID, u.email, u.password, p.first_name, p.last_name, p.middle_name, p.phone_num, u.id_people
				FROM user AS u
				INNER JOIN people AS p
				ON u.id_people = p.ID
				WHERE u.ID = $ID";

			// Return row as a result of query
			return MySQL::fetchOneRow($sql);
		}


		public static function saveInformation($ID, $first_name, $last_name, $middle_name, $phone_num) {
			// Escape speical characters
			$ID = MySQL::getRealEscapeString($ID);
			$first_name = MySQL::getRealEscapeString($first_name);
			$last_name = MySQL::getRealEscapeString($last_name);
			$middle_name = MySQL::getRealEscapeString($middle_name);
			$phone_num = MySQL::getRealEscapeString($phone_num);

			// Make a sql query
			$sql = "UPDATE people
				SET first_name = '$first_name',
					last_name = '$last_name',
					middle_name = '$middle_name',
					phone_num = '$phone_num'
				WHERE ID = (SELECT id_people FROM user WHERE ID = $ID)";

			// Execute query and check count of affected rows
			if(MySQL::nonQuery($sql)) {
				return true;
			}
			return false;
		}

		public static function changePassword($ID, $new_password) {
			// Escape speical characters
			$ID = MySQL::getRealEscapeString($ID);
			$new_password = MySQL::getRealEscapeString($new_password);;

			// Execute query and check count of affected rows
			if (MySQL::nonQuery("UPDATE user SET password = '$new_password' WHERE ID = $ID")) {
				return true;
			}
			return false;
		}

		public static function checkOnEmptyFields($requiredFields) {
			$errors = array();

			foreach ($requiredFields as $field) {
				if (empty($_POST[$field])) {
					switch($field) {
						case 'first_name':
							$errors[] = "Введіть ім'я.";
							break;
						case 'last_name':
							$errors[] = "Введіть прізвище.";
							break;
						case 'phone_num':
							$errors[] = "Введіть номер телефону.";
							break;
						case 'email':
							$errors[] = "Введіть адрес електронної пошти.";
							break;
						case 'password':
							$errors[] = "Введіть пароль";
							break;
					}
				}
			}
			return $errors;
		}

		public static function validateFields($arrayFields) {
			$errors = array();

			foreach ($arrayFields as $field => $value) {
				switch($field) {
					case (preg_match('/\w+_name/', $field) ? true : false):
						if (!empty($value)) {
							$errors = array_merge($errors, self::checkName($value));
						}
						break;
					case 'phone_num':
						$errors = array_merge($errors, self::checkPhoneNum($value));
						break;
					case 'email':
						$errors = array_merge($errors, self::checkEmail($value));
						break;
					case (preg_match('/\w*password/', $field) ? true : false):
						$errors = array_merge($errors, self::checkPassword($value));
						break;
				}
			}
			// Remove duplicate
			$errors = array_unique($errors);

			return $errors;
		}

		public static function checkAllFields($requiredFields, $allFields) {
			$errors = array();

			// Ckeck on empty fields
			$errors = self::checkOnEmptyFields($requiredFields);

			// Check count empty fields
			if (count($errors) == 0) {
				// All of the fields has been introduced

				// Validation all of the fields
				$errors = self::validateFields($allFields);

				if (count($errors) == 0) {
					return true;
				}
			}

			return $errors;
		}

		public static function isAssoc($array) {
			if (array() === $array) {
				return false;
			}
   			return array_keys($array) !== range(0, count($array) - 1);
		}

		public static function loadValueOfFields($loadedFields) {
			$tmp = array();
			foreach ($loadedFields as $field) {
				$tmp[$field] = $_POST[$field];
			}
			return $tmp;
		}

		public static function addPeople($first_name, $last_name, $middle_name, $phone_num) {
			$first_name = MySQL::getRealEscapeString($first_name);
			$last_name = MySQL::getRealEscapeString($last_name);
			$middle_name = MySQL::getRealEscapeString($middle_name);
			$phone_num = MySQL::getRealEscapeString($phone_num);

			if (MySQL::nonQuery("INSERT INTO people VALUES(NULL, '$first_name',
						'$last_name', '$middle_name', '$phone_num')")) {

				return MySQL::getInsertId();
			}
			return false;
		}
	}
?>
