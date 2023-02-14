<footer class="container pagination">
    <?php
    if ($current_page > 1) {
        $prev_page = $current_page - 1;
        $prev = <<<HEREDOC
        <a href="/browse.php?page=$prev_page">Previous</a>
        HEREDOC;
    }

    if ($current_page < $total_pages) {
        $next_page = $current_page + 1;
        $next = <<<HEREDOC
        <a href="/browse.php?page=$next_page">Next</a>
        HEREDOC;
    }

    // Format the previous and next links
    isset($prev) ? $prev = $prev . " | " : $prev = "";
    isset($next) ? $next = " | " . $next : $next = "";

    ?>
    <hr>
    <p> <?= $prev ?> Page <?= $current_page ?> of <?= $total_pages ?> <?= $next ?> </p>
</footer>

</body>

</html>