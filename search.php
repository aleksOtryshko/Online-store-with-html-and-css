<?php  
    require_once 'mysql.php';

    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $search = trim($search);
        $search = strip_tags($search);

        if(!empty($search)) {
            $result_search = mysqli_query($link, "SELECT * FROM `product` WHERE `model` LIKE '%$search%'");

            if(mysqli_num_rows($result_search) > 0) {
                while($rows_search = mysqli_fetch_assoc($result_search)) {
                    echo "<div>";
                    echo htmlspecialchars($rows_search['model']);
                    echo "<br /><br />";
                    echo "</div>";

                    echo "<div>";
                    echo htmlspecialchars($rows_search['description']);
                    echo "<br /><br />";
                    echo "</div>";
                    
                    echo "<div>";
                    echo "Цена: ".htmlspecialchars($rows_search['price'])." usd";
                    echo "<br /><br />";
                    echo "</div>";

                    echo "<div>";
                    echo "ID товара: ";
                    echo htmlspecialchars($rows_search['id_product']);
                    echo "<br /><br />";
                    echo "</div>";
                }
            } else {
                echo "Ничего не найдено.";
            }
        } else {
            echo "Введите поисковой запрос.";
        }
    } else {
        echo "Ошибка: Данные поиска не переданы.";
    }
?>
