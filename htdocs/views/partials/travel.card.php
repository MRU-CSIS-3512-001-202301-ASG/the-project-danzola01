<tr>
    <!-- Image -->
    <th scope="row">
        <img class="center" src="<?= cloudinary_src($post['Path']) ?>" alt="Image from <?= $post['CityName'] . ", " . $post['CountryName'] ?>">
    </th>

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
        <form class="margin_0" action="../../browse.php">
            <!-- Select new rating -->
            <select class="select_new_rating margin_0" id="<?= "new_rating_" . $image_id ?>" name="<?= "new_rating_" . $image_id ?>">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <!-- Hidden field to carry ImageID -->
            <input type="hidden" name="image_id" value="<?= $image_id ?>">

            <!-- Submit new rating -->
            <input class="submit_new_rating contrast" type="submit">
        </form>
    </td>
</tr>