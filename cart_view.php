<?php
// Start session to store cart in the session
session_start();

// Assuming the product data is fetched from the database
require_once __DIR__ . '/../model/product.php';
$cartItems  = getCartItems();
$totalPrice = 0.00;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>My Online Store</h1>
    <p>Home</p>
    <hr>
    
    <h2>Your Cart</h2>
    <form action="../controller/productcontroller.php" method="POST"> <!-- Start form for actions -->
    <table style="border:1px solid black;">
        <tr>
            <th>Cart ID</th><th>Name</th><th>Description</th>
            <th>Quantity</th><th>Price</th><th>Subtotal</th><th>Action</th>
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
                    <td><?php echo $row['cart_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_desc']); ?></td>
                    <td>
                        <input type="hidden" name="cart_id[]" value="<?php echo $row['cart_id']; ?>"> <!-- Array for cart IDs -->
                        <input type="number" name="quantity[]" value="<?php echo $qty; ?>" min="0" style="width:70px;">
                    </td>
                    <td>$<?php echo number_format($price, 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <form action="../controller/productcontroller.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                            <input type="submit" name="remove_cart" value="Remove" style="background-color: red; color: white;">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">Your cart is empty.</td></tr>
        <?php endif; ?>
    </table>

    <h3>Total: $<?php echo number_format($totalPrice, 2); ?></h3>

    <!-- Checkout button -->
    <?php if ($totalPrice > 0): ?>
        <input type="submit" name="update_cart" value="Update Cart">
        <input type="submit" name="checkout" value="Checkout">
    <?php endif; ?>
    </form> <!-- End the form -->
</body>
</html>