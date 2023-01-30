<?php require 'partials/head.php' ?>

<main class="container">

    <h1>Browse</h1>

    <article class="search">
        <!-- h2 is here for W3C Validation -->
        <h2 class="hidden">Sorting</h2>
        <div class=" grid search">
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
    <?php
    $counter = 0;
    foreach ($posts as $postID => $post) :
        if ($counter % 3 == 0) : ?>
    <div class="grid">
        <?php endif; ?>
        <div>
            <article>
                <!-- Image -->
                <header>
                    <img src="<?= $post['image'] ?>" alt="Image from <?= $post['city'] . ", " . $post['country'] ?>">
                </header>

                <!-- Country and City -->
                <hgroup>
                    <h2><?= $post['city'] ?></h2>
                    <p><?= $post['country'] ?></p>
                </hgroup>

                <!-- Latitude, Longitude, Rating -->
                <ul>
                    <li>Latitude: <?= $post['latitude'] ?></li>
                    <li>Longitude: <?= $post['longitude'] ?></li>
                    <li>Rating: <?= $post['rating'] ?></li>
                </ul>

                <footer>
                    <form action="/browse.php" method="post">
                        <!-- Chnage Rating -->
                        <label for="<?= "new_rating_" . $postID ?>">Change rating</label>
                        <select id="<?= "new_rating_" . $postID ?>" name="<?= "new_rating_" . $postID ?>">
                            <option value="" selected>...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>

                        <!-- Hidden field to carry post ID -->
                        <input type="hidden" name="post_id" value="<?= $postID ?>">

                        <!-- Submit button -->
                        <button type="submit" name="submit" class="contrast">Submit</button>
                    </form>
                </footer>
            </article>
        </div>
        <?php if ($counter % 3 == 2) : ?>
    </div>
    <?php endif;
            $counter++;
        endforeach;
    ?>

</main>

<?php require 'partials/footer.php' ?>