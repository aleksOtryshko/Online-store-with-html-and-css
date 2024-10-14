<?php
require_once 'mysql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $model = $_POST['model'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Проверяем, есть ли данные и изображение
    if (!empty($category) && !empty($model) && !empty($description) && !empty($price) && isset($_FILES['img'])) {
        // Проверяем MIME-тип изображения
        $mime_type = mime_content_type($_FILES['img']['tmp_name']);
        $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($mime_type, $allowed_mimes)) {
            $img_tmp_name = $_FILES['img']['tmp_name'];
            $img_content = base64_encode(file_get_contents($img_tmp_name));

            // Подготовленный запрос для безопасной вставки данных
            $stmt = mysqli_prepare($link, "INSERT INTO `product`(`category`, `model`, `description`, `img`, `price`) VALUES (?, ?, ?, ?, ?)");

            if ($stmt) {
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
            echo "Неправильный тип файла.";
        }
    } else {
        echo "Не все поля заполнены.";
    }
}
?>
