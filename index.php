<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Store</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    h1 {
        margin: 0;
    }

    .product {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .product img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .product h2 {
        margin-top: 0;
    }
</style>
</head>
<body>
    <header>
        <h1>Welcome to our Online Store</h1>
    </header>
    <div class="container">
        <!-- Products will be displayed here -->
        <?php
session_start();
require_once 'mysql.php';

// Обработка аутентификации
if(isset($_POST['login']) && isset($_POST['password'])) {
    $login = mysqli_real_escape_string($link, trim($_POST['login']));
    $password = mysqli_real_escape_string($link, trim($_POST['password']));

    $sql = mysqli_query($link, "SELECT * FROM `customer` WHERE `login` = '{$login}' AND `password` = '{$password}' ");
    if(mysqli_num_rows($sql) == 1) {
        $rows_sql = mysqli_fetch_assoc($sql);
        $_SESSION['id'] = $rows_sql['id_customer'];
        echo "Вы авторизованы.";
    } else {
        echo "Неправильный логин или пароль";
    }
}

// Обработка выхода
if(isset($_POST['log_out'])) {
    unset($_SESSION['id']);
    echo "Вы вышли из системы.";
}

// Форма поиска
echo <<<FORMA
<form name="search_product" method="POST" action="search.php">
Поиск по модели товара: <br />
<input type="search" name="search" />
<br />
<input type="submit" value="Поиск" /> <br /><br />
</form>
FORMA;

// Форма входа и выхода
echo <<<FORMA
<form method="POST">
<br />
Имя: <input type="text" name="login" /><br />
Пароль: <input type="password" name="password" /><br />
<input type="submit" name="log_in" value="Войти" /><br /><br /><br />
<input type="checkbox" name="quit" /><label for="quit">Выход</label>
<input type="submit" name="log_out" value="Выйти" />
</form>
FORMA;

// Вывод всех товаров
$result_all_product = mysqli_query($link, "SELECT * FROM `product`");
while($rows_all_product = mysqli_fetch_assoc($result_all_product)) {
    echo "<div>";
    echo "<br />";
    echo "Модель: <br />";
    echo "<a href='article_product.php?id_product={$rows_all_product['id_product']}'>".htmlspecialchars($rows_all_product['model'])."</a>" ;
    echo "<br />";
    echo "<br />";
    echo "Описание : <br />";
    $descripton = htmlspecialchars($rows_all_product['description']);
    echo $descripton;
    echo "<br />";
    echo "</div>";
    echo "<br />";
    echo "<br />";
}
?>
    </div>
</body>
</html>
