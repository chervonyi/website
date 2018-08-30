<div>
    <div class="head-price">
        <div class="price-text">
            Вартість квитків:
        </div>
        <div class="price">
            <p>
                <u><?php echo $seats; ?></u>&nbsp
                <?php if ($seats == 1): ?>
                    квиток
                <?php elseif($seats < 5): ?>
                    квитки
                <?php else: ?>
                    квитків
                <?php endif; ?>
            </p>

            <?php if ($class == 'any'): ?>
                    <form class="select-form" name="select" action="" method="post">
                        <select class="class-flight" id="class" onchange="changeSelect()" name="class">
                            <option value="economy" selected>економ</option>
                            <option value="business">бізнес</option>
                        </select>
                    </form>
                <p style="margin-left: 0">класу.</p>
                <p>Вартість одного квитка: <span id="cost"></span> грн.</p>
                <p id="last">До оплати: <span id="total-cost"></span> грн.</p>
            <?php else: ?>
                <?php if ($class == 'economy'): ?>
                    економ-класу.
                <?php else: ?>
                    бізнес-класу.
                <?php endif; ?>
                 <p>Вартість одного квитка: <?php echo number_format($flight['price_' . $class], 0, ',', ' ') ?> грн.</p>
                 <p>До оплати: <?php echo number_format($flight['price_' . $class] * $seats, 0, ',', ' '); ?> грн. </p>
            <?php endif; ?>
        </div>
    </div>


    <div class="buy-block">
        <?php if (User::isGuest()): ?>
        <div class="new-user-block">
            <p>Немаєте облікового запису, але бажаєте купити білет? <br>Заповніть форму та перейдіть у вікно сплати.</p>
            <p id="important">*Придабний таким чином квиток відмінити буде <b><u>неможливо<u></b>!</p>
            <form action="" method="post" class="usual-form" name="guest" onsubmit="guestFunc()">
                <label for="first_name">Ім'я: <span id="red">*</span></label><br>
                <input type="text" name="first_name" id="first_name" value="Yuri"><br>

                <label for="last_name">Прізвище: <span id="red">*</span> </label><br>
                <input type="text" name="last_name" id="last_name" value="Chervoniy"><br>

                <label for="middle_name">По батькові:</label><br>
                <input type="text" name="middle_name" id="middle_name"><br>

                <label for="phone_num">Номер телефону: <span id="red">*</span></label><br>
                <input type="text" name="phone_num" id="phone_num" maxlength="13" placeholder="+380..." value="+380974112332"><br>

                <input type="hidden" name="class">

                <input type="submit" name="submit_guest" value="Купити" class='submit-button'>
            </form>
        </div>

        <div class="or-block">
            <img src="../../www/images/arrow.png" alt="not found">
        </div>

        <div class="user-block">
            <p>Маєте обліковий запис? <br> Авторизуйтеся для продовження купівлі</p>
            <form action="" method="post" name="login">
                <label for="email">Електронна пошта</label> <br>
                <input type="text" name="email" id="email" placeholder="E-mail.." autocomplete="off"> <br>

                <label for="password">Пароль</label> <br>
                <input type="password" name="password" id="password" onchange="" placeholder="Password.."> <br>

                <input type="submit" name="submit_login" value="Продовжити">
            </form>
        </div>
        <?php else: ?>
            <div class="one-click">
                <p>Купити або забронювати в один клік!</p>
                <div class="buttons">
                    <form name="button-form" action="" method="post" onsubmit="userFunc()">
                        <input type="hidden" name="class2">
                        <input type="submit" name="submit_user_buy" value="Купити" class="btn" >
                        <input type="submit" name="submit_user_reserve" value="Забронювати" class="btn">
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            changeSelect();
        }

        function userFunc() {
            var a = document.forms['select'].class.value;
            document.forms['button-form'].class2.value = a;
        }

        function guestFunc() {
            var a = document.forms['select'].class.value;
            document.forms['guest'].class.value = a;
        }

        function changeSelect() {
            var class_flight = document.getElementById("class").value;
            if(class_flight == 'economy') {
                document.getElementById('cost').innerHTML = <?php echo $flight['price_economy']; ?>
            } else {
                document.getElementById('cost').innerHTML = <?php echo $flight['price_business']; ?>
            }
            document.getElementById('total-cost').innerHTML = document.getElementById('cost').innerHTML * <?php echo $seats; ?>
        }
    </script>
</div>
