<h2><?= esc($title) ?></h2>

<?php if (session()->getFlashdata('errors')): ?>
    <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <p><?= esc($error) ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form
    action="<?= $product
        ? base_url('products/update/' . $product['id'])
        : base_url('products/create') ?>"
    method="post"
    enctype="multipart/form-data"
>
    <?= csrf_field() ?>

    <label>Product Name</label>
    <input
        type="text"
        name="name"
        value="<?= esc($product['name'] ?? '') ?>"
        required
    >

    <br><br>

    <label>Price</label>
    <input
        type="number"
        name="price"
        step="0.01"
        value="<?= esc($product['price'] ?? '') ?>"
        required
    >

    <br><br>

    <label>Stock Quantity</label>
    <input
        type="number"
        name="stock_quantity"
        value="<?= esc($product['stock_quantity'] ?? 0) ?>"
        required
    >

    <br><br>

    <label>Product Image</label>
    <input
        type="file"
        name="image"
        accept=".jpg,.jpeg,.png"
    >

    <br><br>

    <button type="submit">Save Product</button>
</form>

<a href="<?= base_url('products') ?>">Back to Products</a>