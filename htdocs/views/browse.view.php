<?php require 'partials/head.php' ?>

<main class="container">

    <h1>Browse</h1>

    <article class="container search">
        <!-- h2 is here for W3C Validation -->
        <h2 class="hidden">Sorting</h2>

        <div class="grid search">
            <!-- Sorting by country -->
            <details role="list">
                <summary aria-haspopup="listbox" role="button" class="secondary">
                    Sort by Country...
                </summary>
                <ul role="listbox">
                    <li><a href="browse.php?sort=country_AZ">A ⟶ Z</a></li>
                    <li><a href="browse.php?sort=country_ZA">Z ⟶ A</a></li>
                </ul>
            </details>

            <!-- Sorting by city -->
            <details role="list">
                <summary aria-haspopup="listbox" role="button" class="secondary">
                    Sort by City...
                </summary>
                <ul role="listbox">
                    <li><a href="browse.php?sort=city_AZ">A ⟶ Z</a></li>
                    <li><a href="browse.php?sort=city_ZA">Z ⟶ A</a></li>
                </ul>
            </details>


            <!-- Sort by Rating -->
            <details role="list">
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

    <!-- Displaying the thumbnails with info -->
    <table role="grid">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Country</th>
                <th scope="col">City</th>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Rating</th>
                <th scope="col">Change Rating</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $postID => $post) : ?>

                <div>
                    <?php require 'partials/travel.card.php' ?>
                </div>

            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<?php require 'partials/browse.footer.php' ?>