<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 05.11.2017
 * Time: 19:02
 */
require_once('./db_data.php');
try {
    $DBH = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
    $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $query = $DBH->prepare("SELECT ul.id, ul.user_name, ul.user_email, t2.total
        FROM users_login AS ul
        JOIN (
          SELECT user_id, COUNT(*) AS total
          FROM customer_data
          GROUP BY user_id
        ) AS t2 ON t2.user_id = ul.id");
    $query->execute();
    $result = $query->fetchAll();
} catch (PDOException $e) {
    file_put_contents('./log/PDOErrors.txt',$e->getMessage(),FILE_APPEND);
}
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
                       echo "<h2>Админ панель</h2>";
                       echo "<table>
                            <tr>
                                <th>№</th><th>Имя</th><th>Почта</th><th>Колличество заказов</th>
                            </tr>";
                       foreach ($result as $value) {
                           echo "<tr><td>".$value['id']."</td>";
                           echo "<td>".$value['user_name']."</td>";
                           echo "<td>".$value['user_email']."</td>";
                           echo "<td>".$value['total']."</td></tr>";
                       }
                       echo "</table>";
                    ?>
                </div>
            </section>
        </div>
    </div>
</body>
</html>