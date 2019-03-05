<?php

require_once '../vendor/autoload.php';
$pdo = new PDO("mysql:host=localhost;dbname=orders", 'root', 1234);
$query = $pdo->prepare("Select * from users");
$query->execute();
$usersList = $query->fetchAll(PDO::FETCH_ASSOC);

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

$orderList = $pdo->prepare("SELECT od.id as 'Order number', u.`name`,
u.phone, u.email, od.street, od.home, od.floor from users as u
LEFT JOIN order_details as od ON u.id = od.user_id;");
$orderList->execute();
$usersListResult = $orderList->fetchAll(PDO::FETCH_ASSOC);


$template = $twig->loadTemplate('admin.html');
echo $template->render(['users' => $usersList, 'orders' => $usersListResult]);
