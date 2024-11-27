<?php
require __DIR__ . '/inc/functions.inc.php';
require __DIR__ . '/inc/db-connect.inc.php';
date_default_timezone_set('Africa/Nairobi');
$perPage = 2;
$page = (int)($_GET['page'] ?? 1);
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $perPage;
$stmtCount = $pdo->prepare("SELECT COUNT(*) AS `count` FROM `entries`");
$stmtCount->execute();
$count = $stmtCount->fetch(PDO::FETCH_ASSOC)['count'];
$numPages = ceil($count / $perPage);
$stmt = $pdo->prepare("SELECT * FROM `entries` ORDER BY `date` DESC, `id` DESC LIMIT :perPage OFFSET :offset");

$stmt->bindValue('perPage', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require __DIR__ . '/views/header.view.php' ?>

<h1 class="main-heading">Entries</h1>

<?php foreach ($results as $result): ?>

    <div class="card">
        <div class="card__image-container">
            <img class="card__image" src="./images/pexels-canva-studio-3153199.jpg" alt="">
        </div>
        <div class="card__desc-container">
            <?php
            $dateExploded = explode('-', $result['date']);

            $timestamp = mktime(12, 0, 0, $dateExploded[1], $dateExploded[2], $dateExploded[0]);

            ?>
            <div class="card__desc-time">
                <?= e(date('D - d/M/Y', $timestamp)); ?>
            </div>
            <h2 class="card__heading"><?= e($result['title']) ?></h2>
            <div class="card__paragraph">
                <?= nl2br(e($result['message'])) ?>

            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php if ($numPages > 1): ?>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="pagination__li">
                <a
                        class="pagination__link"
                        href="index.php?<?= http_build_query(['page' => $page - 1]) ?>">⏴
                </a>
            </li>
        <?php endif; ?>
        <?php for ($x = 1; $x <= $numPages; $x++): ?>
            <li class="pagination__li">
                <a
                        class="pagination__link <?php if ($page === $x) echo 'pagination__li--active'; ?>"
                        href="index.php?<?= http_build_query(['page' => $x]) ?>"><?= e($x) ?>
                </a>
            </li>
        <?php endfor; ?>
        <?php if ($page < $numPages): ?>
            <li class="pagination__li">
                <a
                        class="pagination__link"
                        href="index.php?<?php echo http_build_query(['page' => $page + 1]); ?>">⏵</a>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>



<?php require __DIR__ . '/views/footer.view.php' ?>
