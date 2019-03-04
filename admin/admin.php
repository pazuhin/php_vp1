<?php
//Список пользователей
$pdo = new PDO("mysql:host=localhost;dbname=orders", 'root', 1234);
$query = $pdo->prepare("Select * from users");
$query->execute();
$usersList = $query->fetchAll(PDO::FETCH_ASSOC);
echo '<h2>Список пользователей : </h2>' . '<br>';
foreach ($usersList as $item) {
    echo $item['name'] . "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . $item['phone'] . "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . $item['email'] . '<br>';
}
echo '<br>';
echo '<br>';
//Список заказов
echo '<h2>Список заказов</h2>';
$orderList = $pdo->prepare("SELECT od.id as 'Order number', u.`name`, 
u.phone, u.email, od.street, od.home, od.floor from users as u
LEFT JOIN order_details as od ON u.id = od.user_id;");
$orderList->execute();
$usersListResult = $orderList->fetchAll(PDO::FETCH_ASSOC);
print '<table style="border: 1px solid; text-align: center; padding: 5px; border-collapse: collapse;">
        <tbody>
              <tr>
                <th style="border: 1px solid; text-align: center; padding: 5px;">Номер заказа</th>
                <th style="border: 1px solid; text-align: center; padding: 5px;">Имя</th>
                <th style="border: 1px solid; text-align: center; padding: 5px;">Телефон</th>
                <th style="border: 1px solid; text-align: center; padding: 5px;">Почта</th>
                <th style="border: 1px solid; text-align: center; padding: 5px;">Улица</th>
                <th style="border: 1px solid; text-align: center; padding: 5px;">Дом</th>
              </tr>';
foreach ($usersListResult as $order) {
    print '<tr>
            <td style="border: 1px solid; text-align: center; padding: 5px; border-collapse: collapse">' . $order['Order number'] . '</td>
            <td style="border: 1px solid; text-align: center; padding: 5px; border-collapse: collapse">' . $order['name'] . '</td>
            <td style="border: 1px solid; text-align: center; padding: 5px; border-collapse: collapse">' . $order['phone'] . '</td>
            <td style="border: 1px solid; text-align: center; padding: 5px; border-collapse: collapse">' . $order['email'] . '</td>
            <td style="border: 1px solid; text-align: center; padding: 5px; border-collapse: collapse">' . $order['street'] . '</td>
            <td style="border: 1px solid; text-align: center; padding: 5px; border-collapse: collapse">' . $order['home'] . '</td>
          </tr>';
}
'</table>';
