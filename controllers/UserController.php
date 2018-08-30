<?php

	class UserController {
		public function actionRegister() {
			// Anouncment vars
			$first_name = "";
			$last_name = "";
			$middle_name = "";
			$phone_num = "";
			$email = "";
			$password = "";
			$errors = null;

			// If click 'Submit'
			if (isset($_POST['submit'])) {
				$errors = array();

				// Array of fields
				$requiredFields = array('first_name', 'last_name', 'phone_num', 'email', 'password');
				$loadedFields = array('first_name', 'last_name', 'middle_name', 'phone_num', 'email', 'password');

				extract(User::loadValueOfFields($loadedFields), EXTR_OVERWRITE);

				$allFields = array(
					'first_name' => $first_name,
					'last_name' => $last_name,
					'middle_name' => $middle_name,
					'phone_num' => $phone_num,
					'email' => $email,
					'password' => $password
				);

				// If all fields are valid - returns assoc array of fields
				// Else - return array of errors
				$cache = User::checkAllFields($requiredFields, $allFields);


				if (!is_array($cache)) {
					// Check if email is not exist in database
					if(!User::checkEmailExist($email)) {
						// Email is free

						// Register a new user in database
						if(User::register($first_name, $last_name, $middle_name,
							$phone_num, $email, $password)) {
							// Get user ID
							$userID = User::checkExist($email, $password);

							if (is_int($userID)) {
								// Email and password are correct
								// Authorization a user
								User::authorization($userID);

								Alert::alertMessage('Реєстрація пройшла успішно!', 'success');
								// Display main paige
								Response::redirect('cabinet');
							}
						}
					} else {
						// Email is busy
						$errors = 'Введена вами електронна пошта зайнята.';
					}
				} else {
					$errors = $cache;
				}
			}

			// Add all of the fields to Array
			$data = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'middle_name' => $middle_name,
				'phone_num' => $phone_num,
				'email' => $email,
				'password' => $password
				//'errors' => $errors
			);
			Alert::alertMessage($errors, 'danger');
			// Display view - 'register.php'
			View::show('register', $data);
		}


		public function actionLogin() {
			$email = "";
			$password = "";
			$errors = null;

			if (isset($_POST['submit'])) {
				$errors = array();

				// Array of fields
				$requiredFields = array('email', 'password');

				extract(User::loadValueOfFields($requiredFields), EXTR_OVERWRITE);
				$allFields = array(
					'email' => $email,
					'password' => $password
				);

				// If all fields are valid - returns assoc array of fields
				// Else - return array of errors
				$cache = User::checkAllFields($requiredFields, $allFields);

				// Check if all fields are correct
				if (User::isAssoc($cache)) {
					// Escape special characters for all of the fields and set vars
					extract($cache, EXTR_OVERWRITE);

					// Verify that the email exists in the DB
					$userID = User::checkExist($email, $password);

					// Check of result of verify that the email exists in the DB
					if (is_int($userID)) {
						// Email and password are correct
						// Authorization a user
						User::authorization($userID);

						// Display main paige
						//header('Location: /cabinet');
						Response::redirect('cabinet');
					} else {
						// Add to errors information about
						$errors = $userID;
					}
				} else {
					$errors = $cache;
				}
			}

			// Add all of the fields to Array
			$data = array (
				'email' => $email,
				'password' => $password
				//'errors' => $errors
			);
			Alert::alertMessage($errors, 'danger');
			// Display view - 'Login.php'
			View::show('login', $data);
		}

		public function actionLogout() {
			unset($_SESSION['user']);
			Response::redirect('');
		}
	}
 ?>
