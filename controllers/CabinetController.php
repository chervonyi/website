<?php
    class CabinetController {
        public function actionIndex () {
            // Get logged user id
            $ID = User::getLogged();

            // Check if a user is logged
            if ($ID) {
                // Get user info
                $user = User::getUserByID($ID);

                // Add all of the fields to Array
                $data = array(
                    'user' => $user
                );

                // Display 'cabinet'
                View::show('cabinet', $data);
            } else {
                // Move to login page
                Response::redirect('user/login');
            }
        }

        public function actionEdit () {
            // Get logged user id
            $ID = User::getLogged();

            // Check if a user is logged
            if ($ID) {
                $errors = null;

                // Get user info
                $user = User::getUserByID($ID);

                if (isset($_POST['submit'])) {
                    // Clicked 'Save'
                    $errors = array();

                    $requiredFields = array('first_name', 'last_name', 'phone_num');

                	extract(User::loadValueOfFields(array('first_name', 'last_name', 'middle_name', 'phone_num')), EXTR_OVERWRITE);

                    $allFields = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'middle_name' => $middle_name,
                        'phone_num' => $phone_num
                    );

                    $cache = User::checkAllFields($requiredFields, $allFields);
                    // Check if all fields are correct
                    if (User::isAssoc($cache)) {
                        // Escape special characters for all of the fields and set vars
    					extract($cache, EXTR_OVERWRITE);

                        // Save new information
                        if(User::saveInformation($ID, $first_name, $last_name, $middle_name, $phone_num)) {
                            // Send alert about succesfully save
                            Alert::alertMessage('Зміни успішно збережені!', 'success');

                            // Move to cabinet page
                            Response::redirect('cabinet');
                        } else {
                            $errors = 'Інформація не була редагована.';
                        }
                    } else {
                        $errors = $cache;
                    }
                }

                // Add all of the fields to Array
                $data = array(
                    'user' => $user,
                    'errors' => $errors
                );
                // Display view - 'cabinet'
                View::show('edit', $data);
            } else {
                // Move to login page
                Response::redirect('user/login');
            }
        }

        public function actionPassword() {
            $ID = false;
            // Get logged user id
            $ID = User::getLogged();

            // Check if a user is logged
            if ($ID != false) {
                $errors = null;

                // Get user info
                $user = User::getUserByID($ID);

                if (isset($_POST['submit'])) {
                    // Clicked 'Save'
                    $errors = array();

                    $requiredFields = array('old_password', 'new_password', 'repeat_password');

                    extract(User::loadValueOfFields($requiredFields), EXTR_OVERWRITE);

                    $allFields = array(
                        'old_password' => $old_password,
                        'new_password' => $new_password,
                        'repeat_password' => $repeat_password
                    );

                    $cache = User::checkAllFields($requiredFields, $allFields);

                    // Check if all fields are correct
                    if (User::isAssoc($cache)) {
                        // Escape special characters for all of the fields and set vars
    					extract($cache, EXTR_OVERWRITE);

                        // Save a new password in database
                        if(User::changePassword($ID, $new_password)) {
                            // Send alert into cabinet
                            $_SESSION['message'] = "Пароль успішно змінений!";

                            // Move to cabinet page
                            // header('Location: /cabinet');
                            Response::redirect('cabinet');
                        } else {
                            $errors = 'Не вдалося зберегти зміни. Спробуйте пізніше.';
                        }
                    } else {
                        $errors = $cache;
                    }
                }
            } else {
                // Move to login page
                // header('Location: /user/login');
                Response::redirect('user/login');
            }

            // Make array of all the information
            $data = array(
                'errors' => $errors
            );

            // Display view - 'password'
            View::show('password', $data);
        }
    }

?>
