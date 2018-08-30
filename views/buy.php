<div class="payment-block">
    <p>До оплати:
    <?php if ($class == 'economy'): ?>
        <?php echo $flight['price_economy'] *  $seats; ?>
    <?php else: ?>
        <?php echo $flight['price_business'] *  $seats; ?>
    <?php endif; ?>
     грн.</p>

     <form action="" method="post">
         <label for="input1">Payment..</label>
         <input type="text" name="" value="" id="input1">
         <input type="submit" name="submit" value="Підтвердити оплату">
     </form>
</div>
