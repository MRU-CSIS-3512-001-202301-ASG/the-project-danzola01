<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Login Page</title>
</head>

<body>
    <h1>Welcome Back!</h1>
    <form action="/login" method="post">
        <div class="center">
            <img src="images/user.svg" alt="user icon">
            <input type="text" id="username" name="username" placeholder="Username"><br>
        </div>

        <div class="center">
            <img src="images/lock.svg" alt="lock icon">
            <input type="password" id="password" name="password" placeholder="Password"><br>
        </div>

        <div class="center">
            <input type="submit" value="Login">
        </div>
    </form>
</body>

</html>