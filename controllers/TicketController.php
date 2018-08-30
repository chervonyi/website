<?php
    class TicketController {

        private function addTickets($seats, $id_people, $flight_id, $class, $type) {
            for ($i=0; $i < $seats; $i++) {
                Ticket::addTicket($id_people, $flight_id, $class, $type);
            }
        }

        public function actionBuy() {
            $data = false;

            if(isset($_SESSION['data'])) {
                $data = $_SESSION['data'];
            }

            if($data) {
                if(isset($_POST['submit'])) {
                    if(isset($data['id_people'])) {
                        $this->addTickets($data['seats'], $data['id_people'], $data['flight']['ID'], $data['class'], $data['type']);
                    } else {
                        // Register a new people
                        $people_id = User::addPeople($data['first_name'], $data['last_name'], $data['middle_name'], $data['phone_num']);

                        if($people_id) {
                            $this->addTickets($data['seats'], $people_id, $data['flight']['ID'], $data['class'], $data['type']);

                            Alert::alertMessage('Купівля успішно здійснена!', 'success');
                        }
                    }
                }
            }
            View::show('buy', $data);
        }
    }
?>
