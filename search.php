<?php
session_start();
require_once 'mysql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = trim($_POST['search']);

    // Используем подготовленный запрос для защиты от SQL-инъекций
    $stmt = mysqli_prepare($link, "SELECT * FROM `product` WHERE `model` LIKE ?");
    $search_param = "%$search%";
    mysqli_stmt_bind_param($stmt, 's', $search_param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div>";
            echo "<a href='article_product.php?id_product={$row['id_product']}'>" . htmlspecialchars($row['model'], ENT_QUOTES, 'UTF-8') . "</a><br />";
            echo "</div>";
        }
    } else {
        echo "Товар не найден.";
    }

    mysqli_stmt_close($stmt);
}
?>
