<?php require_once "partials/header.php" ?>
<?php require_once "partials/sidebar.php" ?>
<?php require_once "../database.php" ?>

<?php
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$skip = ($page - 1) * $limit;

$countCommand = new MongoDB\Driver\Command(['count' => 'applications']);
?>

<div class="main-panel">
    <div class="content">
        <?php if (isset($_GET['deleted'])): ?>
        <div id="delete-alert" class="alert alert-success">Job application deleted successfully!</div>
        <script>
        setTimeout(() => {
            const alertBox = document.getElementById('delete-alert');
            if (alertBox) {
                alertBox.style.transition = 'opacity 0.5s ease';
                alertBox.style.opacity = '0';
                setTimeout(() => {
                    alertBox.remove();
                    const url = new URL(window.location.href);
                    url.searchParams.delete('deleted');
                    window.location.href = url.toString();
                }, 500);
            }
        }, 3000);
        </script>
        <?php endif; ?>

        <div class="container-fluid">
            <h4 class="page-title">Job Applications</h4>
            <section class="site-section">

                <?php
                try {
                    $conn = new MongoConnection();
                    $manager = $conn->getManager();

                    $countResult = $manager->executeCommand('jobboard', $countCommand)->toArray();
                    $totalApps = $countResult[0]->n ?? 0;
                    $totalPages = ceil($totalApps / $limit);

                    $query = new MongoDB\Driver\Query([], [
                        'sort' => ['applied_at' => -1],
                        'skip' => $skip,
                        'limit' => $limit
                    ]);
                    $cursor = $manager->executeQuery("jobboard.applications", $query);
                } catch (Exception $e) {
                    echo "<p>Error loading applications: " . $e->getMessage() . "</p>";
                    return;
                }
                ?>

                <ul class="job-listings mb-5">
                    <?php foreach ($cursor as $app): ?>
                    <li class="job-listing d-block mb-3 d-sm-flex pb-3 pb-sm-0 align-items-center">
                        <div class="job-listing-logo">
                            <img src="<?= htmlspecialchars($app->profile_image) ?>" alt="Profile" class="img-fluid"
                                style="max-height: 70px;">
                        </div>
                        <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
                            <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                                <h5><?= htmlspecialchars($app->candidate_name) ?> —
                                    <?= htmlspecialchars($app->applied_position ?? 'N/A') ?></h5>
                                <strong><?= htmlspecialchars($app->email) ?></strong><br>
                                <small>Expected Salary: ₹<?= number_format($app->expected_salary ?? 0) ?></small>
                            </div>
                            <div class="job-listing-meta">
                                <span class="badge badge-info">
                                    <?= $app->joining_date ? (new DateTime($app->joining_date->toDateTime()->format('Y-m-d')))->format('d M Y') : 'N/A' ?>
                                </span>
                            </div>
                            <div>
                                <a href="edit-application.php?id=<?= $app->_id ?>"
                                    class="btn btn-success btn-sm">Edit</a>
                                <a href="delete-application.php?id=<?= $app->_id ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this application?');">Delete</a>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="row pagination-wrap">
                    <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
                        <span>Showing <?= $skip + 1 ?>-<?= min($skip + $limit, $totalApps) ?> of <?= $totalApps ?>
                            Applications</span>
                    </div>
                    <div class="col-md-6 text-center text-md-right">
                        <div class="custom-pagination ml-auto">
                            <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="prev">Prev</a>
                            <?php endif; ?>
                            <div class="d-inline-block">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                                <?php endfor; ?>
                            </div>
                            <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="next">Next</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php require_once "partials/footer.php"; ?>