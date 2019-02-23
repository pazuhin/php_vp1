<?php
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$street = $_POST['street'];
$home = $_POST['home'];
$appt = $_POST['appt'];
$floor = $_POST['floor'];
$comments = $_POST['comment'];
$cash = $_POST['cash'];
$card = $_POST['card'];
$callback = $_POST['callback'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=orders", 'root', '');
    } catch (PDOException $e) {
        echo $e->getMessage();
        die;
    };
    $query = $pdo->prepare("Select id from users where email like :email__created");
    $query->execute(['email__created' => $email]);
    $result = $query->fetchColumn();
    if ($result > 0) {
        echo 'Ваш заказ успешно обработан.';
    } else {
        echo 'Добро пожаловать! Ваш заказ успешно обработан.';
        $STH = $pdo->prepare("INSERT INTO users (name, phone, email) values (:name, :phone, :email)");
        $STH->execute(['name' => $name, 'phone' => $phone, 'email' => $email]);
        $newQuery = $pdo->prepare("Select id from users where email like :email__created");
        $newQuery->execute(['email__created' => $email]);
        $newId = $newQuery->fetchColumn();
        $result = $newId;
    }
    $order = $pdo->prepare("INSERT INTO order_details (user_id, street, home, appt, floor, comments, card, cash, callback) 
    values (:user_id, :street, :home, :appt, :floor, :comments, :card, :cash, :callback)");
    $order->execute(['user_id' => $result, 'street' => $street, 'home' => $home, 'appt' => $appt,
        'floor' => $floor, 'comments' => $comments, 'card' => $card, 'cash' => $cash, 'callback' => $callback]);
    $orderResult = $order->fetchAll(PDO::FETCH_ASSOC);
    $date = date("d F Y H:i");
//Получение кол-ва заказов одного пользователя.
    $queryCount = $pdo->prepare("Select * from order_details where 
user_id  = :user_id");
    $queryCount->execute(['user_id' => $result]);
    $orderCountNum = count($queryCount->fetchAll(PDO::FETCH_ASSOC));
//Получение номера последнего заказа
    $orderNum = $pdo->query("Select * from order_details");
    $orderNum->execute();
    $orderLastNum = array_pop($orderNum->fetchAll(PDO::FETCH_ASSOC))['id'];
    $text = "Номер заказа : $orderLastNum\nДата заказа : $date
DarkBeefBurger за 500 рублей, 1 шт.
Ваш заказ будет доставлен по адресу : 
ул.$street д.$home, корп.$appt, этаж $floor.
Спасибо! Это уже $orderCountNum заказ(ов)";
    file_put_contents("orders/$orderLastNum.txt", $text);
} else {
    echo 'Некорректный email';
}
/**
 * Отправка email
 * $to = 'test';
 * $subject = 'Заказ' . $orderLastNum;
 * $message = "DarkBeefBurger за 500 рублей, 1 шт.\nВаш заказ будет доставлен по адресу : $street д. $home, корп. $appt, этаж $floor.\nСпасибо! Это уже $orderCountNum заказ(ов)";
 * $mail = mail($to, $subject, $message);
 * if ($mail) {
 * echo 'Сообщение успешно отправлено';
 * } else {
 * echo 'Сообщение не отправлено';
 * }
 */
