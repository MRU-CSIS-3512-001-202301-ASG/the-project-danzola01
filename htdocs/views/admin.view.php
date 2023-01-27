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
                <?= $invalid_username ?? $invalid_username, "" ?>>
            <?php if (isset($errors['username'])) : ?>
            <p class="error"><?= $errors['username'] ?></p>
            <?php endif ?>

            <!-- Password -->
            <input type="password" name="password" placeholder="Password" aria-label="Password"
                autocomplete="current-password" <?= $invalid_password ?? $invalid_password, "" ?>>
            <?php if (isset($errors['password'])) : ?>
            <p class="error"><?= $errors['password'] ?></p>
            <?php endif ?>

            <!-- Submit -->
            <button type="submit" name="submit" class="contrast">Login</button>
        </form>
    </article>
</main>

<?php require 'partials/footer.php' ?>