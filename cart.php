
<?php
session_start();
include '../db/db_connect.php'; // Include the database connection
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
<h1>Your Shopping Cart</h1>

<?php
// Fetch cart items with product details
$sql = "SELECT c.cart_id, p.product_name, p.product_cost, c.quantity
        FROM cart c
        JOIN products p ON c.product_id = p.product_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['product_name']}</td>
                <td>{$row['quantity']}</td>
                <td>$" . ($row['product_cost'] * $row['quantity']) . "</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='remove_id' value='{$row['cart_id']}'>
                        <button type='submit' name='remove_from_cart'>Remove</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>Your cart is empty.</p>";
}

// Handle Remove from Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $remove_id = $_POST['remove_id'];
    $sql = "DELETE FROM cart WHERE cart_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $remove_id);
    mysqli_stmt_execute($stmt);

    // Refresh cart page
    header("Location: cart.php");
    exit();
}
?>

<p>index.phpContinue Shopping</a></p>
</body>
</html>