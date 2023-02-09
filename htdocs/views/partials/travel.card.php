<article>
    <!-- Image -->
    <header>
        <img class="center" src="<?= $post['image'] ?>" alt="Image from <?= $post['city'] . ", " . $post['country'] ?>">
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
        <li class="test">Rating: <?= $post['rating'] ?></li>
    </ul>

    <!-- Change Rating -->
    <footer>
        <form class="change_rating_submit" action="/browse.php" method="post">
            <div class="block">
                <label for="<?= "new_rating_" . $image_id ?>">Change rating</label>
                <select id="<?= "new_rating_" . $image_id ?>" name="<?= "new_rating_" . $image_id ?>">
                    <option value="" selected>...</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <!-- Hidden field to carry ImageID -->
            <input type="hidden" name="image_id" value="<?= $image_id ?>">

            <!-- Submit button -->
            <button type="submit" name="submit" class="contrast">Submit</button>
        </form>
    </footer>
</article>