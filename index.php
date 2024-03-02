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
        require_once 'mysql.php';
        $result_all_product = mysqli_query($link, "SELECT * FROM `product`");
        while($rows_all_product = mysqli_fetch_assoc($result_all_product)) {
            echo "<div class='product'>";
            echo "<img src='data:image/png;base64,".base64_encode($rows_all_product['img'])."' alt='Product Image'>";
            echo "<h2>" . htmlspecialchars($rows_all_product['model']) . "</h2>";
            echo "<p>" . htmlspecialchars($rows_all_product['description']) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($rows_all_product['price']) . "</p>";
            echo "<button>Add to Cart</button>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
