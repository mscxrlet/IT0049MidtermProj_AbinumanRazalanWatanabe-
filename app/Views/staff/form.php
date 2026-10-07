<h2><?= esc($title) ?></h2>

<?php if (session()->getFlashdata('error')): ?>
    <p><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>

<?php foreach ((array) session()->getFlashdata('errors') as $error): ?>
    <p><?= esc($error) ?></p>
<?php endforeach; ?>

<form
    method="post"
    enctype="multipart/form-data"
    action="<?= $staffMember
        ? site_url('staff/update/' . $staffMember['id'])
        : site_url('staff/create') ?>"
>
    <?= csrf_field() ?>

    <label>Username</label><br>
    <input
        type="text"
        name="username"
        maxlength="50"
        required
        value="<?= esc(old('username', $staffMember['username'] ?? '')) ?>"
    >

    <br><br>

    <label>Full Name</label><br>
    <input
        type="text"
        name="full_name"
        maxlength="100"
        required
        value="<?= esc(old('full_name', $staffMember['full_name'] ?? '')) ?>"
    >

    <br><br>

    <label>
        Password
        <?= $staffMember ? '(leave blank to keep current password)' : '' ?>
    </label><br>

    <input
        type="password"
        name="password"
        <?= $staffMember ? '' : 'required' ?>
    >

    <br><br>

    <label>Avatar</label><br>
    <input
        type="file"
        name="avatar"
        accept=".jpg,.jpeg,.png,.webp"
    >

    <br><br>

    <button type="submit">Save Staff</button>
</form>

<a href="<?= site_url('staff') ?>">Back to Staff</a>