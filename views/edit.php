
<?php if(isset($errors)) :
    if (is_array($errors)) : ?>
        <div class="errors">
            <h4>Errors:</h4>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else : ?>
                <h4><?php echo $errors ?></h4>
        </div>
    <?php endif; ?>
<?php endif; ?>

<form action="" method="post" class="usual">
    <label for="first_name">Ім'я: <span>*</span></label> <br>
    <input type="text" name="first_name" id="first_name" placeholder="New name.." value="<?php echo $user['first_name']; ?>"> <br>

    <label for="last_name">Прізвище: <span>*</span></label> <br>
    <input type="text" name="last_name" id="last_name" placeholder="New surname.." value="<?php echo $user['last_name']; ?>"> <br>

    <label for="middle_name">По батькові:</label> <br>
    <input type="text" name="middle_name" id="middle_name" placeholder="New middle name.." value="<?php echo $user['middle_name']; ?>"> <br>

    <label for="phone_num">Номер телефону: <span>*</span></label> <br>
    <input type="text" name="phone_num" id="phone_num" placeholder="New phone number.." value="<?php echo $user['phone_num']; ?>" maxlength="13" placeholder="+380.."> <br>

    <input type="submit" name="submit" value="Save">
</form>
