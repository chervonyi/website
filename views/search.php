    <h4>Знайдені рейси:</h4>

    <?php if ($data): ?>
        <?php foreach ($data as $row): ?>
            <div class="flight">

                    <table border="0" bordercolor="white" cellspacing="0" cellpadding="5" width="100%">
                        <tr>
                            <td width="26%">Рейс <?php echo $row['board_num']; ?></td>
                            <td width="26%">Взліт <?php echo date('H:i', strtotime($row['time_flight'])); ?></td>
                            <td width="27%">Переліт <?php echo Flight::getDuration($row['duration']); ?></td>
                            <td width="20%">Приліт <?php echo date('H:i', strtotime('+' . $row['duration'] . ' minutes' , strtotime($row['time_flight']))); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['date_flight']; ?></td>
                            <td></td>
                            <td><?php echo Flight::getDate($row['date_flight'], $row['time_flight'], $row['duration']); ?></td>
                        </tr>
                        <tr>
                            <td><?php switch ($class) {
                                case 'economy':
                                    echo 'Економ-клас';
                                    break;
                                case 'business':
                                    echo 'Бізнес-клас';
                                    break;
                            } ?></td>
                            <td>Львів, Україна</td>
                            <td></td>
                            <td><?php echo $row['city'] . ', ' . $row['country']; ?></td>
                        </tr>
                    </table>

                    <div id="price">
                        <div id="text">
                            Вартість: &nbsp
                            <?php if ($class == 'economy'): ?>
                                <?php echo number_format($row['price_economy'], 0, ',', ' ') . ' грн.'; ?>
                            <?php elseif ($class == 'business'): ?>
                                <?php echo number_format($row['price_business'], 0, ',', ' ') . ' грн.'; ?>
                            <?php else: ?>
                                <?php echo number_format($row['price_economy'], 0, ',', ' ') . ' грн. / ' . number_format($row['price_business'], 0, ',', ' ') . ' грн.'; ?>
                            <?php endif; ?>
                        </div>
                        <a href="/flights/<?php echo $row['ID']; ?>"><button type="button" name="button">Купити</button></a>
                    </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <h3>Not found ;(</h3>
    <?php endif; ?>
