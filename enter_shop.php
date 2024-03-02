<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="password"],
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #333;
        color: #fff;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #555;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="enter_shop.php" method="post">
            <label for="login">Username:</label>
            <input type="text" id="login" name="login" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>

<?php
session_start();
require_once 'mysql.php';

if(isset($_POST['login']) && isset($_POST['password'])) {
    $login = mysqli_real_escape_string($link, trim($_POST['login']));
    $password = mysqli_real_escape_string($link, trim($_POST['password']));

    $sql = mysqli_query($link, "SELECT * FROM `customer` WHERE `login` = '{$login}'");
    $rows_sql = mysqli_fetch_assoc($sql);

    if($rows_sql && password_verify($password, $rows_sql['password'])) {
        $_SESSION['id'] = $rows_sql['id_customer'];
        header('Location: http://your-abstract-domain.com');
        exit();
    } else {
        print "Неправильный логин или пароль";
    }
}
?>
