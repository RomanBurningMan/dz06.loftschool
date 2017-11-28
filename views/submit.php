<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 26.11.2017
 * Time: 16:47
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная страница</title>
    <link rel="stylesheet" href="./css/vendors.min.css">
    <link rel="stylesheet" href="./css/main.min.css">
</head>
<body>
<div class="wrapper">
    <div class="maincontent">
        <section class="section">
            <div class="container">
                <?php
                if ($data[0] == '') {
                    echo "<h2>Для авторизации, нам нужна ваша почта.</h2>
                            <form action='./submit_form.php' method='POST'>
                                <div><label>Введите эл. почту: <input type='email'></label></div>
                                <div><input type='submit' value='Заказать'></div>
                            </form>";
                    exit();
                }
                if ($data[0] != '') echo "<p>Здравствуйте, ".$data[0]."</p>";
                if ($data[1] != '') echo "<p>Спасибо за заказ. Вся информация была ".
                    "выслана вам на эл. почту, по адресу <b>".$data[1]."</b></p>";
                ?>
            </div>
        </section>
    </div>
</div>
</body>
</html>
