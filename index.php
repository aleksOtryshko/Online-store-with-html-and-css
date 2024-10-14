<?php
session_start();
require_once 'mysql.php';

// Обработка аутентификации
if(isset($_POST['login']) && isset($_POST['password'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Подготовленный запрос для проверки логина
    $stmt = mysqli_prepare($link, "SELECT * FROM `customer` WHERE `login` = ?");
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $rows_sql = mysqli_fetch_assoc($result);
        if (password_verify($password, $rows_sql['password'])) {
            $_SESSION['id'] = $rows_sql['id_customer'];
            echo "Вы авторизованы.";
        } else {
            echo "Неправильный логин или пароль";
        }
    } else {
        echo "Неправильный логин или пароль";
    }
    mysqli_stmt_close($stmt);
}

// Обработка выхода
if(isset($_POST['log_out'])) {
    session_destroy();
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
    echo "<a href='article_product.php?id_product={$rows_all_product['id_product']}'>" . htmlspecialchars($rows_all_product['model']) . "</a>" ;
    echo "<br />";
    echo "<br />";
    echo "Описание : <br />";
    $description = htmlspecialchars($rows_all_product['description']);
    echo $description;
    echo "<br />";
    echo "</div>";
    echo "<br />";
    echo "<br />";
}
?>
