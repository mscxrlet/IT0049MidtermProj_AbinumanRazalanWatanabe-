<!DOCTYPE html>
<html>
<head>
    <title>Sales History</title>
</head>
<body>
    <h2>Sales History</h2>

    <?php if (session()->has('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <p><a href="/sales/new">Record a New Sale</a></p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Staff Member</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sales)): ?>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= $sale['id'] ?></td>
                        <td><?= esc($sale['product_name']) ?></td>
                        <td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td>
                        <td><?= esc($sale['staff_name']) ?></td>
                        <td><?= $sale['quantity'] ?></td>
                        <td>$<?= number_format($sale['total_price'], 2) ?></td>
                        <td><?= $sale['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No sales recorded yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>