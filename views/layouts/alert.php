
<?php if (Alert::getMessage()): ?>
    <div class="message message-<?php echo Alert::getType() ?>">
        <span class="closebtn">&times;</span>
        <?php if (is_array(Alert::getMessage())): ?>
            <ul>
                <?php foreach (Alert::getMessage() as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
                <?php echo Alert::getMessage(); ?>
        <?php endif; ?>
        <?php Alert::unsetMessage(); ?>
    </div>
<?php endif; ?>

<script>
    var close = document.getElementsByClassName("closebtn");

    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function(){
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function(){ div.style.display = "none"; }, 600);
        }
    }

    var a = document.getElementsByClassName("message");
    window.onload = function() {
        setTimeout(function(){
            a[0].style.opacity = "0";
            setTimeout(function(){
                a[0].style.display = "none";
            }, 500);
        }, 2000);

    };
</script>
