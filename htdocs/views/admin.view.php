<?php require 'partials/head.php' ?>

<main class="container">

    <article>
        <hgroup>
            <h1>Admin Portal</h1>
            <p>Log in to access the admin portal</p>
        </hgroup>
        <form action="admin.php" method="post">
            <!-- Username -->
            <input type="text" name="username" placeholder="Username" aria-label="Login" autocomplete="nickname"
                aria-invalid="<?= $invalid_username ?? '' ?>" value="<?= $_POST['username'] ?? '' ?>">
            <?php if (isset($errors['username'])) : ?>
            <p class="error"><?= $errors['username'] ?></p>
            <?php endif ?>

            <!-- Password -->
            <input type="password" name="password" placeholder="Password" aria-label="Password"
                autocomplete="current-password" aria-invalid="<?= $invalid_password ?? '' ?>">
            <?php if (isset($errors['password'])) : ?>
            <p class="error"><?= $errors['password'] ?></p>
            <?php endif ?>

            <!-- Error message from validation -->
            <?php if (isset($errors['validation'])) : ?>
            <p class="error"><?= $errors['validation'] ?></p>
            <?php endif ?>

            <!-- Submit -->
            <button type="submit" name="submit" class="contrast button_login">Login</button>
        </form>
    </article>
</main>

<?php require 'partials/footer.php' ?>