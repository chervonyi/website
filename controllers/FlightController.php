<?php
    class FlightController {
        public function actionSearch() {
            // Announcement variables
            $date = "";
            $direction_to = "";
            $class = "";
            $seats = "";
            $data = false;

            // If clicked 'Search'
            if (isset($_POST['submit'])) {
                $errors = array();

                // Check on empty fields
                if(empty($_POST['date'])) {
                    $errors[] = 'Заповніть дату відправлення.';
                } else {
                    $date = $_POST['date'];
                }

                if(empty($_POST['direction_to'])) {
                    $errors[] = 'Введіть пункт призначення.';
                } else {
                    $direction_to = $_POST['direction_to'];
                }

                if(empty($_POST['class'])) {
                    $errors[] = 'Оберіть потрібний клас в літаку.';
                } else {
                    $class = $_POST['class'];
                }

                if(empty($_POST['seats'])) {
                    $errors[] = 'Оберіть потрібну кількість квитків.';
                } else {
                    $seats = $_POST['seats'];
                }

                // Check count of empty fields
                if (count($errors) == 0) {
                    // All of the fields has been introduced

                    // Validate name of city
                    $errors = array_merge($errors, Flight::checkCityName($direction_to));

                    // Validate count of tickets (MAX - 5): FLight::checkCountTickets($tickets);
                    $errors = array_merge($errors, Flight::checkCountTickets($seats));

                    // Validate date
                    $errors = array_merge($errors, Flight::checkDate($date));

                    // Check id all of the fields are correct
                    if (count($errors) == 0) {
                        // Execute search
                        $data = Flight::searchFlights($direction_to, $date, $class, $seats);

                        $_SESSION['class'] = $class;
                        $_SESSION['seats'] = $seats;
                    }
                }
            }

            if (count($errors)) {
                Alert::alertMessage($errors, 'danger');
            }

            View::show('search', array('data' => $data, 'class' => $class));

        }

        private function submit_login() {
            $errors = array();

            // Array of fields
            $requiredFields = array('email', 'password');

            extract(User::loadValueOfFields($requiredFields), EXTR_OVERWRITE);
            $allFields = array(
                'email' => $email,
                'password' => $password
            );

            $cache = User::checkAllFields($requiredFields, $allFields);

            // Check if all fields are correct
            if (User::isAssoc($cache)) {
                // Escape special characters for all of the fields and set vars
                extract($cache, EXTR_OVERWRITE);

                $userID = User::checkExist($email, $password);
                if (is_int($userID)) {
                    User::authorization($userID);
                }
            } else {
                Alert::alertMessage('Хибні дані!', 'danger');
                Response::redirect('user/login');
            }
        }


        private function submit_guest($data, $class, $seats) {
            $first_name = "";
            $last_name = "";
            $middle_name = "";
            $phone_num = "";

            $errors = array();

            $requiredFields = array('first_name', 'last_name', 'middle_name', 'phone_num');

            extract(User::loadValueOfFields($requiredFields), EXTR_OVERWRITE);

            $allFields = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'middle_name' => $middle_name,
                'phone_num' => $phone_num,
            );

            $cache = User::checkAllFields($requiredFields, $allFields);

            if (User::isAssoc($cache)) {
                // Escape special characters for all of the fields and set vars
                extract($cache, EXTR_OVERWRITE);

                $fields = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'middle_name' => $middle_name,
                    'phone_num' => $phone_num,
                    'seats' => $seats,
                    'flight' => $data,
                    'type' => 'bought'
                );

                if($class == 'any') {
                    $fields['class'] = $_POST['class'];
                } else {
                    $fields['class'] = $class;
                }

                Response::redirect('tickets/buy', $fields);
            } else {
                Alert::alertMessage($cache, 'warning');
            }
        }

        private function submit_user_buy($data, $class, $seats) {
            // Get logged user id
            $ID = User::getLogged();

            if ($ID) {
                $user = User::getUserByID($ID);

                $fields = array(
                    'id_people' => $user['id_people'],
                    'seats' => $seats,
                    'flight' => $data,
                    'type' => 'bought'
                );

                if($class == 'any') {
                    $fields['class'] = $_POST['class2'];
                } else {
                    $fields['class'] = $class;
                }

                Response::redirect('tickets/buy', $fields);
            }
        }

        private function submit_user_reserve($data, $class, $seats) {
            $ID = User::getLogged();

            if($class == 'any') {
                $tmp = 'any';
                $class = $_POST['class2'];
            }

            if ($ID) {
                $user = User::getUserByID($ID);
                $errors = false;

                for ($i=0; $i < $seats; $i++) {
                    if(!Ticket::addTicket($user['id_people'], $data['ID'], $class, 'reserved')) {
                        $errors = true;
                    }
                }

                if(isset($tmp)) {
                    $class = $tmp;
                }

                if(!$errors) {
                    // Go to with alert!
                    Alert::alertMessage('Квиток успішно заброньовано', 'success');
                    Response::redirect('cabinet', $fields);
                }
            }
        }

        public function actionView($parameters) {
            $class = '';
            $seats = '';
            $data = false;
            $password = '';
            $email = '';

            if (isset($_SESSION['class']) && isset($_SESSION['seats'])) {
                $class = $_SESSION['class'];
                $seats = $_SESSION['seats'];
            }

            $data = Flight::getFlightByID($parameters);

            if(isset($_POST['submit_login'])) {
                $this->submit_login();
            }

            if(isset($_POST['submit_guest'])) {
                $this->submit_guest($data, $class, $seats);
            }

            if(isset($_POST['submit_user_buy'])) {
                $this->submit_user_buy($data, $class, $seats);
            }

            if(isset($_POST['submit_user_reserve'])) {
                $this->submit_user_reserve($data, $class, $seats);
            }

            View::show('flight', array('class' => $class, 'seats' => $seats, 'flight' => $data));
        }
    }

?>
