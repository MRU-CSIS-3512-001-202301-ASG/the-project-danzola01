<?php require 'partials/head.php' ?>

<main class="container">

    <h1>Browse</h1>

    <article class="slim_card">
        <div class="grid">
            <!-- Sorting by country -->
            <details role="list" class="margin_5">
                <summary aria-haspopup="listbox" role="button" class="secondary">
                    Sort by Country...
                </summary>
                <ul role="listbox">
                    <li><a href="browse.php?sort=country_AZ">A ⟶ Z</a></li>
                    <li><a href="browse.php?sort=country_ZA">Z ⟶ A</a></li>
                </ul>
            </details>

            <!-- Sorting by city -->
            <details role="list" class="margin_5">
                <summary aria-haspopup="listbox" role="button" class="secondary">
                    Sort by City...
                </summary>
                <ul role="listbox">
                    <li><a href="browse.php?sort=city_AZ">A ⟶ Z</a></li>
                    <li><a href="browse.php?sort=city_ZA">Z ⟶ A</a></li>
                </ul>
            </details>


            <!-- Sort by Rating -->
            <details role="list" class="margin_5">
                <summary aria-haspopup="listbox" role="button" class="secondary">
                    Sort by Rating...
                </summary>
                <ul role="listbox">
                    <li><a href="browse.php?sort=rating_HL">5 ⟶ 1</a></li>
                    <li><a href="browse.php?sort=rating_LH">1 ⟶ 5</a></li>
                </ul>
            </details>

        </div>
    </article>

    <article class='slim_card'>

        <form action="browse.php" method="get" class="margin_5">
            <div class="grid">
                <!-- Search by Country-->
                <input type="search" id="search_country" name="search_country" placeholder="Search by Country"
                    value=<?= $search_country ?? '""' ?>>

                <!-- Search by City-->
                <input type="search" id="search_city" name="search_city" placeholder="Search by City"
                    value=<?= $search_city ?? '""' ?>>

                <!-- Search by Rating-->
                <input type="search" id="search_rating" name="search_rating" placeholder="Search by Rating"
                    value=<?= $search_rating ?? '""' ?>>

            </div>

            <!-- Submit -->
            <button type="submit" name="search" class="contrast margin_5">Search</button>
        </form>

    </article>


    <?php if (isset($_POST['submit_new_rating'])) : ?>
    <article class="rating_success">
        <p class="rating_success"><kbd>Rating changed successfully!</kbd></p>
    </article>
    <?php endif ?>

    <!-- Displaying the thumbnails with info -->
    <table role="grid">
        <thead>
            <tr>
                <th class="th_center" scope="col">Image</th>
                <th class="th_center" scope="col">Country</th>
                <th class="th_center" scope="col">City</th>
                <th class="th_center" scope="col">Latitude</th>
                <th class="th_center" scope="col">Longitude</th>
                <th class="th_center" scope="col">Rating</th>
                <th class="th_center" scope="col">Change Rating</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($posts as $postID => $post) : ?>

            <?php
                $image_id = $post['ImageID'];
                require 'partials/travel.card.php' ?>

            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($posts)) : ?>
    <h3 class="no_results">No results found!</h3>
    <?php endif; ?>

</main>

<?php require 'partials/browse.footer.php' ?>