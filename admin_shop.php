<?php
require_once 'mysql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $model = $_POST['model'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Проверяем, есть ли данные
    if (!empty($category) && !empty($model) && !empty($description) && !empty($price) && isset($_FILES['img'])) {
        $img_tmp_name = $_FILES['img']['tmp_name'];
        $img_content = file_get_contents($img_tmp_name);
        $img_content = mysqli_real_escape_string($link, base64_encode($img_content));

        // Подготовленный запрос для безопасной вставки данных в базу
        $stmt = mysqli_prepare($link, "INSERT INTO `product`(`category`, `model`, `description`, `img`, `price`) VALUES (?, ?, ?, ?, ?)");

        if ($stmt) {
            // Привязываем параметры к подготовленному запросу и выполняем его
            mysqli_stmt_bind_param($stmt, 'sssss', $category, $model, $description, $img_content, $price);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                echo "Товар успешно добавлен в БД!";
            } else {
                echo "Ошибка добавления записи в БД: " . mysqli_error($link);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Ошибка при подготовке запроса: " . mysqli_error($link);
        }
    } else {
        echo "Не все поля заполнены.";
    }
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<form method="POST" enctype="multipart/form-data">

Категория товара:
<select name="category">
    <option value="phone">Телефоны</option>
    <option value="household_appliances">Бытовая техника</option>
    <option value="accessory">Аксессуары</option>
</select><br /><br />

Модель:<br /> <input type="text" name="model"><br />

Описание:<br /> <textarea name="description"></textarea><br />

Изображение товара:<br />
<input type="file" name="img"><br /><br />

Цена:<br /> <input type="text" name="price"><br />

<input type="submit" name="add_product" value=" Добавить товар ">

</form>

</body>
</html>
