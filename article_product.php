<?php
session_start();
require_once 'mysql.php';

if(isset($_GET['id_product'])) {
    $id_product = $_GET['id_product'];

    $result_article = mysqli_query($link, "SELECT * FROM `product` WHERE `id_product` = '$id_product'");
    if(mysqli_num_rows($result_article) > 0) {
        $rows_article = mysqli_fetch_assoc($result_article);

        echo "<div>";
        echo "Модель:  " . htmlspecialchars($rows_article['model']) . "<br /><br />";
        echo "</div>";

        echo "<div>";
        echo  "Описание:  <br />" . htmlspecialchars($rows_article['description']) . "<br />";
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

        if(isset($_POST['status'])) {
            $status = $_POST['status'];
            if($status == 'on') {
                $model = mysqli_real_escape_string($link, $rows_article['model']);
                $price = mysqli_real_escape_string($link, $rows_article['price']);
                $id_customer = $_SESSION['id'];
                $add_product = mysqli_query($link, "INSERT INTO `order_customer`(`model`, `price`, `id_product`, `id_customer`) VALUES ('$model', '$price', '$id_product', '$id_customer')");
                
                if($add_product) {
                    echo "Покупка добавлена в корзину!";
                } else {
                    echo "Ошибка добавления записи в БД: " . mysqli_error($link);
                }
            } else {
                echo "Ошибка: Неверное значение статуса.";
            }
        }
        echo "</div>";
    } else {
        echo "Товар с ID $id_product не найден.";
    }
} else {
    echo "Ошибка: ID товара не указан.";
}

echo "<a href='index.php'>На главную</a>";
?>
