<form action="" method="post" class="usual">
    <label for="first_name">Ім'я: <span id="red">*</span></label><br>
    <input type="text" name="first_name" id="first_name" value="<?php echo $first_name ?>"><br>


    <label for="last_name">Прізвище: <span id="red">*</span> </label><br>
    <input type="text" name="last_name" id="last_name" value="<?php echo $last_name ?>"><br>


    <label for="middle_name">По батькові:</label><br>
    <input type="text" name="middle_name" id="middle_name" value="<?php echo $middle_name ?>"><br>


    <label for="phone_num">Номер телефону: <span id="red">*</span></label><br>
    <input type="text" name="phone_num" id="phone_num" value="<?php if($phone_num == "") echo '+380'; else echo $phone_num; ?>" maxlength="13" placeholder="+380..."><br>


    <label for="email">E-mail: <span id="red">*</span></label><br>
    <input type="text" name="email" id="email" value="<?php echo $email ?>"><br>


    <label for="password">Пароль: <span id="red">*</span></label><br>
    <input type="password" name="password" id="password"><br>


    <input type="submit" name="submit">
</form>
