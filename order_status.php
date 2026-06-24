<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Order Status</title>
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
        <h1>Check Your Order Status</h1>
    </header>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <label for="booking_id">Enter your Booking ID:</label>
            <input type="text" id="booking_id" name="booking_id" required>
            <button type="submit">Check Status</button>
        </form>

        <?php
        if (isset($_GET['booking_id']) && !empty(trim($_GET['booking_id']))) {
            require_once "config.php";
            $booking_id = trim($_GET['booking_id']);

            // Query to get order details linked to a booking
            $sql = "SELECT o.id, o.total_amount, o.order_status, o.created_at, b.name 
                    FROM orders o 
                    JOIN bookings b ON o.booking_id = b.id 
                    WHERE o.booking_id = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $param_booking_id);
                $param_booking_id = $booking_id;
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result) > 0) {
                        echo "<div style='margin-top: 2rem; border-top: 1px solid #ddd; padding-top: 2rem;'>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<h3>Order Details for Booking ID: " . htmlspecialchars($booking_id) . "</h3>";
                            echo "<p><strong>Customer Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
                            echo "<p><strong>Total Amount:</strong> ₹" . htmlspecialchars($row['total_amount']) . "</p>";
                            echo "<p><strong>Status:</strong> " . htmlspecialchars($row['order_status']) . "</p>";
                            echo "<p><strong>Order Time:</strong> " . htmlspecialchars($row['created_at']) . "</p>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p style='text-align:center; margin-top: 2rem;'>No order found for this Booking ID.</p>";
                    }
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($link);
        }
        ?>
    </div>

    <footer style="position: fixed; bottom: 0; width: 100%;">
        <p>&copy; 2025 India's Pride Restaurant</p>
    </footer>
</body>
</html>