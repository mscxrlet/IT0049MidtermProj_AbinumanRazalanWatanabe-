<h2>Customers</h2>

<a href="<?= base_url('customers/new') ?>">Add Customer</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?= esc($customer['full_name']) ?></td>
            <td><?= esc($customer['email']) ?></td>
            <td><?= esc($customer['phone']) ?></td>
            <td>
                <a href="<?= base_url('customers/edit/' . $customer['id']) ?>">
                    Edit
                </a>

                <form action="<?= base_url('customers/delete/' . $customer['id']) ?>"
                      method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>