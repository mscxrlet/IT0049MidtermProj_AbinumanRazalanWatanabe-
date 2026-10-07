<h2><?= esc($title) ?></h2>

<?php if (session()->getFlashdata('errors')): ?>
    <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <p><?= esc($error) ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post"
      action="<?= $customer
          ? base_url('customers/update/' . $customer['id'])
          : base_url('customers/create') ?>">

    <?= csrf_field() ?>

    <label>Full Name</label>
    <input type="text" name="full_name"
           value="<?= esc($customer['full_name'] ?? '') ?>" required>

    <br><br>

    <label>Email</label>
    <input type="email" name="email"
           value="<?= esc($customer['email'] ?? '') ?>" required>

    <br><br>

    <label>Phone</label>
    <input type="text" name="phone"
           value="<?= esc($customer['phone'] ?? '') ?>">

    <br><br>

    <button type="submit">Save Customer</button>
</form>