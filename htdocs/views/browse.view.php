<?php require 'partials/head.php' ?>

<main class="container">

    <h1>Browse</h1>

    <article class="search">
        <div class="grid search">
            <!-- Sorting by country -->
            <div>
                <select id="sort_country" name="sort_country">
                    <option value="" selected>Sort by Country...</option>
                    <option>A ⟶ Z</option>
                    <option>Z ⟶ A</option>
                </select>
            </div>

            <!-- Sorting by city -->
            <div>
                <select id="sort_city" name="sort_city">
                    <option value="" selected>Sort by City...</option>
                    <option>A ⟶ Z</option>
                    <option>Z ⟶ A</option>
                </select>
            </div>

            <!-- Sorting by rating -->
            <div>
                <select id="sort_rating" name="sort_rating">
                    <option value="" selected>Sort by Rating...</option>
                    <option>High ⟶ Low</option>
                    <option>Low ⟶ High</option>
                </select>
            </div>
        </div>
    </article>

    <!-- Displaying the thumbnails with info -->
    <div class="grid">
        <!-- Loop to keep the columns to a max of three posts-->
        <?php
        $iteration = 0;
        foreach ($posts as $post) :
            if ($iteration % 3 === 0) {
                echo '<div>';
            }
        ?>
        <article>
            <!-- Image -->
            <header>
                <img src="<?= cloudinary_src($post['image']) ?>">
            </header>

            <!-- Country and City -->
            <hgroup>
                <h2><?= $post['country'] ?></h2>
                <h3><?= $post['city'] ?></h3>
            </hgroup>

            <!-- Latitude, Longitude, Rating -->
            <ul>
                <li>Latitude: <?= $post['lat'] ?></li>
                <li>Longitude: <?= $post['long'] ?></li>
                <li>Rating: <?= $post['rating'] ?></li>
            </ul>

            <!-- Change rating -->
            <footer>
                <label for="new_rating">Change rating</label>
                <select id="new_rating" name="new_rating">
                    <option value="" selected>...</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </footer>
        </article>
        <?php
            $iteration++;
            if ($iteration % 3 === 0) {
                echo '</div>';
            }
        endforeach;
        ?>
    </div>
</main>

<?php require 'partials/footer.php' ?>