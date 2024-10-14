<?php
session_start();
require_once 'mysql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Используем подготовленный запрос для защиты от SQL-инъекций
    $stmt = mysqli_prepare($link, "SELECT * FROM `customer` WHERE `login` = ?");
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $customer = mysqli_fetch_assoc($result);

        // Проверка пароля с использованием password_verify
        if(password_verify($password, $customer['password'])) {
            $_SESSION['id'] = $customer['id_customer'];
            echo "Вы авторизованы.";
        } else {
            echo "Неправильный логин или пароль.";
        }
    } else {
        echo "Неправильный логин или пароль.";
    }

    mysqli_stmt_close($stmt);
}
?>
