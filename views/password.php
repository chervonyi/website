

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
    <label for="old_password">Попередній пароль: </label> <br>
    <input type="password" name="old_password" id="old_password">

    <label for="new_password"> Новий пароль:</label> <br>
    <input type="password" name="new_password" id="new_password" onchange="checkRepeat()">

    <label for="repeat_password">Повторіть новий пароль:</label> <br>
    <input type="password" name="repeat_password" id="repeat_password" onchange="checkRepeat()">

    <input type="submit" name="submit" value="Save" id="submit" disabled>
</form>

<script type="text/javascript">
    function checkRepeat() {
        var fieldOld = document.getElementById("old_password");
        var fieldNew = document.getElementById("new_password");
        var fieldRepeat = document.getElementById("repeat_password");
        var submit = document.getElementById("submit");

        if (fieldNew.value != fieldRepeat.value) {
            fieldNew.style.backgroundColor = "white";
            fieldRepeat.style.backgroundColor = "#ffb2b2";

        } else {
            fieldNew.style.backgroundColor = "#cbe7c4";
            fieldRepeat.style.backgroundColor = "#cbe7c4";
            document.getElementById("submit").disabled=false;

        }
    }
</script>
