<?php
// Start session to retrieve the cart from the session
session_start();

// Include necessary files
require_once __DIR__ . '/../model/product.php';

// Get cart items (assuming the cart is stored in the session)
$cartItems = getCartItems();
$totalPrice = 0.00;

// If the cart is empty, redirect back to cart page
if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    header("Location: ../public/cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Checkout - My Online Store</title>
</head>
<body>
    <h1>Checkout</h1>
    <p><a href="../public/cart.php">Go back to Cart</a></p>
    <hr>

    <h2>Your Cart</h2>
    <table style="border:1px solid black;">
        <tr>
            <th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Subtotal</th>
        </tr>
        <?php if ($cartItems && mysqli_num_rows($cartItems) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($cartItems)): ?>
                <?php
                    $qty = (int)$row['quantity'];
                    $price = (float)$row['product_cost'];
                    $subtotal = $qty * $price;
                    $totalPrice += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_desc']); ?></td>
                    <td><?php echo $qty; ?></td>
                    <td>$<?php echo number_format($price, 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Your cart is empty.</td></tr>
        <?php endif; ?>
    </table>

    <h3>Total: $<?php echo number_format($totalPrice, 2); ?></h3>

    <!-- Checkout Form -->
    <form action="../controller/checkoutcontroller.php" method="POST">
        <input type="submit" name="confirm_checkout" value="Proceed to Payment">
    </form>

</body>
</html>