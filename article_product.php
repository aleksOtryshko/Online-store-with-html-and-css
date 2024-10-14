<?php
session_start();
require_once 'mysql.php';

if(isset($_GET['id_product'])) {
    // Используем подготовленный запрос для защиты от SQL-инъекций
    $stmt = mysqli_prepare($link, "SELECT * FROM `product` WHERE `id_product` = ?");
    mysqli_stmt_bind_param($stmt, 'i', $_GET['id_product']);
    mysqli_stmt_execute($stmt);
    $result_article = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result_article) > 0) {
        $rows_article = mysqli_fetch_assoc($result_article);

        echo "<div>";
        echo "Модель:  " . htmlspecialchars($rows_article['model'], ENT_QUOTES, 'UTF-8') . "<br /><br />";
        echo "</div>";

        echo "<div>";
        echo "Описание:  <br />" . htmlspecialchars($rows_article['description'], ENT_QUOTES, 'UTF-8') . "<br />";
        echo "</div>";
      
        echo "<div>";
        $cont_decode = $rows_article['img'];
        echo "<img src=\"data:image/png;base64,$cont_decode\"/><br />";
        echo "</div>";

        echo "<div>";
        echo "<form method='POST'>";
        echo "В корзину <input type='checkbox' name='status'><br />";
        echo "<input type='submit' name='buy' value=' Купить '>";
        echo "</form>";

        // Проверяем, установлена ли опция "В корзину"
        if(isset($_POST['status']) && $_POST['status'] == 'on') {
            $model = $rows_article['model'];
            $price = $rows_article['price'];
            $id_customer = $_SESSION['id'];

            // Используем подготовленный запрос для защиты от SQL-инъекций
            $stmt_insert = mysqli_prepare($link, "INSERT INTO `order_customer`(`model`, `price`, `id_product`, `id_customer`) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_insert, 'sdii', $model, $price, $_GET['id_product'], $id_customer);
            $result_insert = mysqli_stmt_execute($stmt_insert);

            if($result_insert) {
                echo "Покупка добавлена в корзину!";
            } else {
                echo "Ошибка добавления записи в БД: " . mysqli_error($link);
            }

            mysqli_stmt_close($stmt_insert);
        } else {
            echo "Ошибка: Товар не добавлен в корзину.";
        }
        echo "</div>";
    } else {
        echo "Товар с ID {$_GET['id_product']} не найден.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Ошибка: ID товара не указан.";
}

echo "<a href='index.php'>На главную</a>";
?>
