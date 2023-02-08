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
                <?php require 'partials/travel.card.php' ?>
            </div>
            <?php if ($counter % 3 == 2) : ?>
            </div>
    <?php endif;
            $counter++;
        endforeach;
    ?>

</main>

<?php require 'partials/footer.php' ?>