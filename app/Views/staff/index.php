<h2>Staff</h2>

<p>
    <a href="<?= site_url('products') ?>">Products</a> |
    <a href="<?= site_url('customers') ?>">Customers</a> |
    <a href="<?= site_url('staff/new') ?>">Add Staff</a> |
    <a href="<?= site_url('logout') ?>">Log out</a>
</p>

<?php if (session()->getFlashdata('error')): ?>
    <p><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>Avatar</th>
        <th>Username</th>
        <th>Full Name</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($staff as $member): ?>
        <tr>
            <td>
                <?php if ($member['avatar']): ?>
                    <img
                        src="<?= esc(base_url('uploads/avatars/' . $member['avatar']), 'attr') ?>"
                        width="80"
                        height="80"
                        alt="Avatar"
                    >
                <?php else: ?>
                    No avatar
                <?php endif; ?>
            </td>

            <td><?= esc($member['username']) ?></td>
            <td><?= esc($member['full_name']) ?></td>
            <td><?= esc($member['created_at']) ?></td>

            <td>
                <a href="<?= site_url('staff/edit/' . $member['id']) ?>">
                    Edit
                </a>

                <form
                    action="<?= site_url('staff/delete/' . $member['id']) ?>"
                    method="post"
                    style="display:inline"
                >
                    <?= csrf_field() ?>

                    <button
                        type="submit"
                        onclick="return confirm('Delete this staff member?')"
                    >
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>