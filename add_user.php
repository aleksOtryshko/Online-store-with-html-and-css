<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration</title>
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
    input[type="text"], input[type="password"], input[type="submit"] {
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
        <h2>Registration</h2>
        <form action="add_user.php" method="post">
            <label for="log">Username:</label>
            <input type="text" id="log" name="log" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

<?php
require_once 'mysql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $log = trim($_POST['log']);
    $password = trim($_POST['password']);

    if (empty($log) || empty($password)) {
        echo "Логин и пароль обязательны для заполнения.";
    } else {
        $stmt = mysqli_prepare($link, "INSERT INTO `personal`(`log`, `password`) VALUES (?, ?)");
        if ($stmt) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, 'ss', $log, $hashed_password);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                header("Location: index.php");
                exit();
            } else {
                echo "Ошибка при регистрации: " . mysqli_error($link);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Ошибка при подготовке запроса: " . mysqli_error($link);
        }
    }
}

mysqli_close($link);
?>
