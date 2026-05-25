<?php
session_start();

// 1. Ginamit ang array() imbis na [] para sa lumang PHP 5.3
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>

<h2>Your Cart</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Action</th>
    </tr>

<?php 
// 2. Babasahin ang laman ng $_SESSION['cart']
foreach ($_SESSION['cart'] as $id => $item): 
?>
    <tr>
        <td><?php echo $item['name']; ?></td>
        <td>₱<?php echo number_format($item['price'], 2); ?></td>
        <td><?php echo $item['qty']; ?></td>
        <td>₱<?php echo number_format($item['price'] * $item['qty'], 2); ?></td>
        <td>
            <a href="remove.php?id=<?php echo $id; ?>">Remove</a>
        </td>
    </tr>
<?php endforeach; ?>

</table>