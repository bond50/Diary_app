<?php
require __DIR__ . '/inc/functions.inc.php';
require __DIR__ . '/inc/db-connect.inc.php';
if (!empty($_POST)) {
    $title = (string)$_POST['title'] ?? '';
    $date = (string)$_POST['date'] ?? "";
    $message = (string)$_POST['message'] ?? "";


    var_dump($title, $date, $message); ;

    $stmt = $pdo->prepare("INSERT INTO `entries` (`title`, `date`, `message`) VALUES (:title, :date, :message)");
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':message', $message);
    $stmt->execute();
    echo '<a href="index.php">Continue to the diary</a>';
    die();

}

?>

<?php require __DIR__ . '/views/header.view.php' ?>
    <h1 class="main-heading">Entries</h1>

    <form action="form.php" method="post">
        <div class="form-group">
            <label for="title" class="form-group__label">Title:</label>
            <input type="text" name="title" id="title" class="form-group__input"/>

        </div>
        <div class="form-group">
            <label for="date" class="form-group__label">Date:</label>
            <input type=date name="date" id="date" class="form-group__input"/>
        </div>
        <div class="form-group">
            <label for="message" class="form-group__label">Message:</label>
            <textarea name="message" id="message" class="form-group__input" rows="6"></textarea>
        </div>
        <div class="form-submit">
            <button type="submit" class="button">
                <svg viewBox="0 0 34.7163912799 33.4350009649" class="button__icon">

                    <g style="fill: none;stroke: currentColor;stroke-linecap: round;stroke-linejoin: round;stroke-width: 2px;">
                        <polygon
                                points="20.6844359446 32.4350009649 33.7163912799 1 1 10.3610302393 15.1899978903 17.5208901631 20.6844359446 32.4350009649"/>
                        <line x1="33.7163912799" y1="1" x2="15.1899978903" y2="17.5208901631"/>
                    </g>
                </svg>

                Submit
            </button>
        </div>
    </form>
<?php require __DIR__ . '/views/footer.view.php' ?>