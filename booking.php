<?php
// PHP code from your previous version goes here...
require_once "config.php";
$name = $phone = $email = $booking_date = $booking_time = $num_guests = "";
$order_items = [];
$total_amount = 0;
$booking_id = null;
$order_message = "";
// ... (rest of your PHP logic)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process booking
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $booking_date = trim($_POST["booking_date"]);
    $booking_time = trim($_POST["booking_time"]);
    $num_guests = trim($_POST["num_guests"]);

    $sql_booking = "INSERT INTO bookings (name, phone, email, booking_date, booking_time, num_guests) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt_booking = mysqli_prepare($link, $sql_booking)) {
        mysqli_stmt_bind_param($stmt_booking, "sssssi", $name, $phone, $email, $booking_date, $booking_time, $num_guests);
        if (mysqli_stmt_execute($stmt_booking)) {
            $booking_id = mysqli_insert_id($link); // Get the ID of the new booking
        } else {
            $order_message = "Error in booking.";
        }
        mysqli_stmt_close($stmt_booking);
    }

    // Process order if a booking was made
    if ($booking_id) {
        if (!empty($_POST['order_items'])) {
            $sql_menu_prices = "SELECT id, price FROM menu";
            $menu_prices_result = mysqli_query($link, $sql_menu_prices);
            $menu_prices = [];
            while($row = mysqli_fetch_assoc($menu_prices_result)){
                $menu_prices[$row['id']] = $row['price'];
            }
            
            foreach ($_POST['order_items'] as $menu_item_id => $quantity) {
                if ($quantity > 0) {
                    $total_amount += $menu_prices[$menu_item_id] * $quantity;
                }
            }

            $sql_order = "INSERT INTO orders (booking_id, customer_name, total_amount) VALUES (?, ?, ?)";
            if ($stmt_order = mysqli_prepare($link, $sql_order)) {
                mysqli_stmt_bind_param($stmt_order, "isd", $booking_id, $name, $total_amount);
                if (mysqli_stmt_execute($stmt_order)) {
                    $order_id = mysqli_insert_id($link);
                    $sql_order_item = "INSERT INTO order_items (order_id, menu_item_id, quantity) VALUES (?, ?, ?)";
                    if ($stmt_order_item = mysqli_prepare($link, $sql_order_item)) {
                        foreach ($_POST['order_items'] as $menu_item_id => $quantity) {
                            if ($quantity > 0) {
                                mysqli_stmt_bind_param($stmt_order_item, "iii", $order_id, $menu_item_id, $quantity);
                                mysqli_stmt_execute($stmt_order_item);
                            }
                        }
                        mysqli_stmt_close($stmt_order_item);
                    }
                     $order_message = "Booking and order placed successfully! Your Booking ID is: " . $booking_id;
                } else {
                     $order_message = "Error placing order.";
                }
                 mysqli_stmt_close($stmt_order);
            }
        } else {
             $order_message = "Booking successful! Your Booking ID is: " . $booking_id;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Table & Order Food</title>
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
        <h1>Book a Table & Place Your Order</h1>
    </header>
    
    <div class="container">
        <?php if(!empty($order_message)) echo "<p style='text-align:center; font-weight:bold;'>" . $order_message . "</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Your Details</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <h2>Booking Details</h2>
            <label for="booking_date">Date:</label>
            <input type="date" id="booking_date" name="booking_date" required>
            <label for="booking_time">Time:</label>
            <input type="time" id="booking_time" name="booking_time" required>
            <label for="num_guests">Number of Guests:</label>
            <input type="number" id="num_guests" name="num_guests" min="1" required>

            <h2>Place Your Order (Optional)</h2>
            <?php
            // We need a fresh link because the one in the PHP block above might have been closed
            require_once "config.php"; 
            $sql_menu = "SELECT id, name, price FROM menu ORDER BY category";
            $menu_result = mysqli_query($link, $sql_menu);
            while($menu_item = mysqli_fetch_assoc($menu_result)){
                echo "<div>";
                echo "<label for='item_".$menu_item['id']."'>" . htmlspecialchars($menu_item['name']) . " (₹" . htmlspecialchars($menu_item['price']) . ")</label>";
                echo "<input type='number' name='order_items[".$menu_item['id']."]' id='item_".$menu_item['id']."' min='0' value='0' style='width: 60px; margin-left: 10px;'>";
                echo "</div>";
            }
            mysqli_close($link);
            ?>

            <button type="submit">Submit Booking & Order</button>
             <div class="order-notes">
                <p>* Preparation time is approximately 20-30 minutes.</p>
                <p>* Orders once placed cannot be cancelled.</p>
            </div>
        </form>
    </div>
    
    <footer>
        <p>&copy; 2025 India's Pride Restaurant</p>
    </footer>
</body>
</html>