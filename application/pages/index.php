<?php
// Fetch last shortened URLs
$lastShortened = array();
$sql = 'SELECT identifier FROM url ORDER BY id DESC LIMIT 5';
try {
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($lastShortened, $row['identifier']);
    }
    $stmt = null;
}
catch (PDOException $e) {
    print $e->getMessage();
}

// Other logic
$shortenedUrl = '';
if (isset($_POST['url']) && $_POST['url'] != '') {
    // Generate short URL
    $generateNewIdentifier = true;
    do {
        $identifier = generateRandomString(6);
        $sql = 'SELECT url FROM url WHERE identifier = ?';
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute(array($identifier));
            $generateNewIdentifier = ($stmt->rowCount() > 0);
        }
        catch (PDOException $e) {
            print $e->getMessage();
        }
    } while ($generateNewIdentifier);
    syslog(LOG_INFO, '[' . $identifier . '] Generated identifier URL for ' . $_POST['url'] . '.');

    // Store link in database
    $stmt = $db->prepare("INSERT INTO url (identifier, url) VALUES (?, ?)");
    $stmt->execute(array( $identifier, $_POST['url'] ));

    // Store link in last used ring
    if (count($lastShortened) >= 5) {
        array_pop($lastShortened);
    }
    array_unshift($lastShortened, $identifier);
    syslog(LOG_INFO, 'Updated list of last shortened URLs');

    // Short URL
    $shortenedUrl = $configuration['approoturl'] . '/u/' . $identifier;
}

?>

<div class="text-center">
    <h1>Short URLs made simple.</h1>

    <form method="POST">
        <p>
            <label for="url">Enter the URL to shorten:</label>
            <input type="text" name="url" id="url" value="<?php echo isset($_POST['url']) ? $_POST['url'] : ''; ?>" /><br />

            <?php if ($shortenedUrl != '') { ?>
                <label for="url">Has been shortened into:</label>
                <input type="text" value="<?php echo $shortenedUrl; ?>" /><br />
                <a href="/" class="btn">Shorten another one</a>
            <?php } else { ?>
                <input type="submit" class="btn btn-primary" value="Shorten" />
            <?php } ?>
        </p>
    </form>

    <h2>Recently shortened</h2>
    <ul class="unstyled">
        <?php foreach ($lastShortened as $identifier) { ?>
        <li><a href="<?php echo $configuration['approoturl'] . '/u/' . $identifier; ?>"><?php echo $identifier; ?></a></li>
        <?php } ?>
    </ul>
</div>

<script>
    $(function() {
        $('#url').focus();
    });
</script>