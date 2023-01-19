<!DOCTYPE html>
<html data-theme="light" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login Page</title>
</head>

<body>
    <nav class="container-fluid">
        <ul>
            <li><a href="./" class="contrast"><strong>Good Travels</strong></a></li>
        </ul>
    </nav>
    <main class="container">
        <article class="grid">
            <div>
                <hgroup>
                    <h1>Welcome Back!</h1>
                    <p>Use your credentials to sign in.</p>
                </hgroup>
                <form action="validate_admin.php" method="post">
                    <input type="text" name="Username" placeholder="Username" aria-label="Login" autocomplete="nickname"
                        required>
                    <input type="password" name="password" placeholder="Password" aria-label="Password"
                        autocomplete="current-password" required>
                    <fieldset>
                        <label for="remember">
                            <input type="checkbox" role="switch" id="remember" name="remember">
                            Remember me
                        </label>
                    </fieldset>
                    <button type="submit" name="submit" class="contrast">Login</button>
                </form>
                <button class="secondary" onclick="window.location.href='register.php'">Register</button>
            </div>
            <div></div>
        </article>
    </main>

</html>