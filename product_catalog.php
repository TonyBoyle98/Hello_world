<?php
require_once __DIR__ . '/../model/product.php';
$products = getProducts();
?>
<h2>Product Catalog</h2>
<table style="border:1px solid black;">
    <tr>
        <th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Action</th>
    </tr>
    <?php if ($products && mysqli_num_rows($products) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo htmlspecialchars($row['product_desc']); ?></td>
                <td>$<?php echo number_format($row['product_cost'], 2); ?></td>
                <td>
                    <form action="../controller/productcontroller.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="submit" name="add_to_cart" value="Add to Cart">
                    </form>
                    <form action="../controller/productcontroller.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="submit" name="update_product" value="Update">
                    </form>
                    <form action="../controller/productcontroller.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="submit" name="remove_product" value="Remove">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">No products available.</td></tr>
    <?php endif; ?>
</table>

<!-- Checkout Button -->
<div style="margin-top: 20px;">
    <form action="../controller/cartcontroller.php" method="POST">
        <input type="submit" name="checkout" value="Checkout">
    </form>
</div>