<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="../../www/css/header.css">
        <link rel="stylesheet" href="../../www/css/fonts.css">
        <link rel="stylesheet" href="../../www/css/cabinet.css">
        <link rel="stylesheet" href="../../www/css/flights.css">
        <link rel="stylesheet" href="../../www/css/flight.css">
        <link rel="stylesheet" href="../../www/css/forms.css">
        <link rel="stylesheet" href="../../www/css/main_page.css">
        <link rel="stylesheet" href="../../www/css/buy.css">
        <link rel="stylesheet" href="../../www/css/alert.css">
        <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">
    </head>
    <body>
        <?php $userLogged = User::getLogged(); ?>
        <header>
            <a href="/" id="home-button"><img src="../../www/images/home.jpg" alt="Not found home button"></a>
            <a href="/user/register" class="header-button">Реєстрація</a>

            <?php if($userLogged == false) :?>
                <a href="/user/login" class="header-button">Вхід</a>
            <?php else: ?>
                <a href="/cabinet" class="header-button">Мій кабінет</a>
                <a href="/user/logout" class="header-button">Вийти</a>
            <?php endif; ?>
        </header>

        <div class="alert">
            <?php View::render('layouts/alert') ?>
        </div>

        <div class="content">
            <?php View::render(); ?>
        </div>
    </body>
</html>
