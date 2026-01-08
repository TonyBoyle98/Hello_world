<?php
session_start(); // Start the session

include '../db/db_connect.php'; // Include the database connection

// Fetch products from the database
$result = mysqli_query($conn, "SELECT * FROM products");

if (!$result) {
    die('Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
</head>
<body>

<h1>Product List</h1>


<?php
session_start(); // Start the session
include '../db/db_connect.php'; // Include the database connection

// Fetch products from the database
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
</head>
<body>
<h1>Product List</h1>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>";
        echo "<strong>Product Name:</strong> " . $row['product_name'] . "<br>";
        echo "<strong>Description:</strong> " . $row['product_desc'] . "<br>";
        echo "<strong>Price:</strong> $" . $row['product_cost'] . "<br>";

        // Add to Cart form
        echo "<form method='post'>
                <input type='hidden' name='product_id' value='" . $row['product_id'] . "'>
                <button type='submit' name='add_to_cart'>Add to Cart</button>
              </form>";
        echo "</p>";
    }
} else {
    echo "No products found.";
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = 1;

    // Insert into cart table
    $sql = "INSERT INTO cart (product_id, quantity) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $product_id, $quantity);
    mysqli_stmt_execute($stmt);

    // Redirect to cart page
    header("Location: cart.php");
    exit();
}
?>
</body>
</html>