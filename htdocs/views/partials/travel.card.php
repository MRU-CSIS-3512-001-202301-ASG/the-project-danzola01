<tr>
    <!-- Image -->
    <td>
        <img class="center" src="<?= cloudinary_src($post['Path']) ?>"
            alt="Image from <?= $post['CityName'] . ", " . $post['CountryName'] ?>">
    </td>

    <!-- Country -->
    <td><?= $post['CountryName'] ?></td>

    <!-- City -->
    <td><?= $post['CityName'] ?></td>

    <!-- Latitude -->
    <td><?= $post['Latitude'] ?></td>

    <!-- Longitude -->
    <td><?= $post['Longitude'] ?></td>

    <!-- Rating -->
    <td><?= $post['Rating'] ?></td>

    <!-- Change Rating -->
    <td>
        <form class="margin_0" method="POST" action="../../browse.php">
            <!-- Select new rating -->
            <select class="select_new_rating margin_0" name="new_rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <!-- Hidden field to carry ImageID -->
            <input type="hidden" name="image_id" value="<?= $image_id ?>">

            <!-- Submit new rating -->
            <button type="submit" name="submit_new_rating" class="contrast margin_0">Submit</button>
        </form>
    </td>
</tr>