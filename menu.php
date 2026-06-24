<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="top-nav">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="booking.php">Book a Table</a>
        <a href="order_status.php">Order Status</a>
    </nav>
    
    <header class="page-header">
        <h1>Our Menu</h1>
    </header>

    <div class="container">
        <?php
        require_once "config.php";
        $categories = ['North Indian', 'South Indian', 'Breakfast', 'Snacks', 'Drinks/Beverages', 'Chappati'];

        foreach ($categories as $category) {
            echo "<div class='menu-category'>";
            echo "<h2>" . htmlspecialchars($category) . "</h2>";
            $sql = "SELECT name, description, price FROM menu WHERE category = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_category);
                $param_category = $category;
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<div class='menu-item'>";
                        echo "<div><strong>" . htmlspecialchars($row['name']) . "</strong><br>" . htmlspecialchars($row['description']) . "</div>";
                        echo "<span>₹" . htmlspecialchars($row['price']) . "</span>";
                        echo "</div>";
                    }
                }
                mysqli_stmt_close($stmt);
            }
            echo "</div>";
        }
        mysqli_close($link);
        ?>
    </div>
    
    <footer>
        <p>&copy; 2025 India's Pride Restaurant</p>
    </footer>
</body>
</html>