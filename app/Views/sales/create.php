<!DOCTYPE html>
<html>
<head>
    <title>Record Sale</title>
</head>
<body>
    <h2>Record New Sale</h2>

    <?php if (session()->has('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="/sales/store" method="post">
        <?= csrf_field() ?>

        <label>Product:</label>
        <select name="product_id" required>
            <option value="">Select Product</option>
            <?php foreach ($products as $prod): ?>
                <option value="<?= $prod['id'] ?>"><?= esc($prod['name']) ?> (Stock: <?= $prod['stock_quantity'] ?> - $<?= $prod['price'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Customer (Optional):</label>
        <select name="customer_id">
            <option value="">Walk-in Customer</option>
            <?php foreach ($customers as $cust): ?>
                <option value="<?= $cust['id'] ?>"><?= esc($cust['full_name']) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" required value="<?= old('quantity', 1) ?>">
        <br><br>

        <button type="submit">Submit Sale</button>
    </form>
    <br>
    <a href="/sales">View Sales History</a>
</body>
</html>