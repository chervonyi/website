        <div class="block-img">
            <div class="block">
                <form action="/flights" method="POST">
                    <div class="body-block">
                        <div class="column" id="from">
                            <input type="text" name="direction_from" class="direction_text" value="Львів" readonly> <br>
                            <input type="date" name="date" min="<?php echo date('Y-m-d')?>" value="2017-05-25">
                        </div>
                        <div class="column" id="to">
                            <input type="text" name="direction_to" class="direction_text" placeholder="Куди" value="Нью-Йорк"> <br>
                        </div>
                        <div class="column">
                            <select class="class" name="class" id="class">
                                <option value="any">Будь-який</option>
                                <option value="economy">Економ</option>
                                <option value="business">Бізнес</option>
                            </select>

                            <input type="number" name="seats" value="1" min="1" max="5" class="seats">


                        </div>
                        <div class="column last">
                            <input type="submit" name="submit" value="Шукати" id="main-page">
                        </div>
                    </div>
                </form>
            </div>
        </div>
