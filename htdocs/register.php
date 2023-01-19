<!DOCTYPE html>
<html data-theme="light" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>Login Page</title>
</head>

<body>
    <nav class="container-fluid">
        <ul>
            <li><a href="./" class="contrast"><strong>Good Travels</strong></a></li>
        </ul>
    </nav>
    <main class="container">
        <article>
            <!-- <div> -->
            <hgroup>
                <h1>Register</h1>
                <p>Join the GoodTravels community!</p>
            </hgroup>
            <form action="./includes/register.inc.php" method="post">
                <div class="grid">
                    <!-- First Name -->
                    <input type="text" name="first" placeholder="First Name" aria-label="First Name"
                        autocomplete="given-name" required>
                    <!-- Last Name -->
                    <input type="text" name="last" placeholder="Last Name" aria-label="Last Name"
                        autocomplete="family-name" required>
                </div>
                <div class="grid">
                    <!-- Email -->
                    <input type="email" name="email" placeholder="Email" aria-label="Email" autocomplete="email"
                        required>
                    <!-- Phone Number -->
                    <input type="text" name="phone" placeholder="Phone Number" aria-label="Phone Number"
                        autocomplete="tel" required>
                </div>
                <!-- Address -->
                <input type="text" name="address" placeholder="Address" aria-label="Address"
                    autocomplete="street-address" required>
                <div class="grid">
                    <!-- City -->
                    <input type="text" name="city" placeholder="City" aria-label="City" autocomplete="address-level2"
                        required>
                    <!-- Region -->
                    <input type="text" name="region" placeholder="Region" aria-label="Region"
                        autocomplete="address-level1" required>
                    <!-- Postal Code -->
                    <input type="text" name="postal" placeholder="Postal Code" aria-label="Postal Code"
                        autocomplete="postal-code" required>
                    <!-- Country -->
                    <input type="text" name="country" placeholder="Country" aria-label="Country"
                        autocomplete="country-name" required>
                </div>
                <div class="grid">
                    <!-- Password -->
                    <input type="password" name="password" placeholder="Password" aria-label="Password"
                        autocomplete="new-password" required>
                    <!-- Repeat Password -->
                    <input type="password" name="password-repeat" placeholder="Repeat Password" aria-label="Password"
                        autocomplete="new-password" required>
                </div>

                <!-- Submit -->
                <button type="submit" name="submit" class="contrast">Register</button>
            </form>
            <!-- </div> -->
            <div></div>
        </article>
    </main>

</html>