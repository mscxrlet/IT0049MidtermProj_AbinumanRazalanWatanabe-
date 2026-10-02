<h2>Products</h2>

<a href="<?= base_url('products/new') ?>">Add Product</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($products as $product): ?>
        <tr>
            <td>
                <?php if ($product['image']): ?>
                    <img
                        src="<?= base_url('uploads/products/' . $product['image']) ?>"
                        width="80"
                        height="80"
                    >
                <?php else: ?>
                    No image
                <?php endif; ?>
            </td>

            <td><?= esc($product['name']) ?></td>
            <td>₱<?= number_format($product['price'], 2) ?></td>
            <td><?= esc($product['stock_quantity']) ?></td>

            <td>
                <a href="<?= base_url('products/edit/' . $product['id']) ?>">
                    Edit
                </a>

                <form
                    action="<?= base_url('products/delete/' . $product['id']) ?>"
                    method="post"
                    style="display:inline;"
                >
                    <?= csrf_field() ?>
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>