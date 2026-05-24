<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['checkout.php'] = [];
}
?>

<h2>Your Cart</h2>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Action</th>
    </tr>

<?php foreach ($_SESSION['checkout.php'] as $id => $item): ?>
    <tr>
        <td><?= $item['name'] ?></td>
        <td><?= $item['price'] ?></td>
        <td><?= $item['qty'] ?></td>
        <td><?= $item['price'] * $item['qty'] ?></td>
        <td>
            <a href="remove.php?id=<?= $id ?>">Remove</a>
        </td>
    </tr>
<?php endforeach; ?>

</table>