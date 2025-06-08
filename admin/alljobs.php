<?php require_once "partials/header.php" ?>
<?php require_once "partials/sidebar.php" ?>
<?php require_once "../database.php" ?>
<?php
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$skip = ($page - 1) * $limit;
$countCommand = new MongoDB\Driver\Command([
    'count' => 'jobs'
]);

?>

<div class="main-panel">
    <div class="content">
        <?php if (isset($_GET['deleted'])): ?>
        <div id="delete-alert" class="alert alert-success">Job post deleted successfully!</div>
        <script>
        setTimeout(function() {
            const alertBox = document.getElementById('delete-alert');
            if (alertBox) {
                alertBox.style.transition = 'opacity 0.5s ease';
                alertBox.style.opacity = '0';
                setTimeout(() => {
                    alertBox.remove();
                    // Remove `deleted` param and reload page
                    const url = new URL(window.location.href);
                    url.searchParams.delete('deleted');
                    window.location.href = url.toString();
                }, 500); // After fade out
            }
        }, 3000);
        </script>
        <?php endif; ?>

        <div class="container-fluid">
            <h4 class="page-title">All Jobs</h4>
            <section class="site-section">

                <?php

                try {
                    $conn = new MongoConnection();
                    $manager = $conn->getManager();

                    $query = new MongoDB\Driver\Query([], ['sort' => ['created_at' => -1]]);
                    $cursor = $manager->executeQuery("jobboard.jobs", $query);
                    $countResult = $manager->executeCommand('jobboard', $countCommand)->toArray();
                    $totalJobs = $countResult[0]->n ?? 0;

                    $totalPages = ceil($totalJobs / $limit);
                    $query = new MongoDB\Driver\Query([], [
                        'sort' => ['created_at' => -1],
                        'skip' => $skip,
                        'limit' => $limit
                    ]);

                    $cursor = $manager->executeQuery("jobboard.jobs", $query);
                } catch (Exception $e) {
                    echo "<p>Error loading jobs: " . $e->getMessage() . "</p>";
                    return;
                }
                ?>

                <ul class="job-listings mb-5">
                    <?php foreach ($cursor as $job): ?>
                    <li class="job-listing d-block mb-3 d-sm-flex pb-3 pb-sm-0 align-items-center"
                        style="text-decoration: none;color:black">
                        <a href="job-single.php?id=<?= $job->_id ?>">
                            <div class="job-listing-logo">
                                <img src="<?= $job->company->logo ?>" alt="<?= htmlspecialchars($job->company->name) ?>"
                                    class="img-fluid">
                            </div>
                        </a>

                        <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
                            <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                                <h4><?= htmlspecialchars($job->title) ?></h4>
                                <strong><?= htmlspecialchars($job->company->name) ?></strong>
                            </div>
                            <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
                                <span class="icon-room"></span> <?= htmlspecialchars($job->location) ?>
                            </div>
                            <div class="job-listing-meta">
                                <span
                                    class="badge badge-<?= strtolower($job->job_type) === 'part time' ? 'danger' : 'success' ?>">
                                    <?= htmlspecialchars($job->job_type) ?>
                                </span>
                            </div>
                            <div>
                                <a href="job-single.php?id=<?= $job->_id ?>" class="btn btn-success">Edit</a>
                                <a href="delete-job.php?id=<?= $job->_id ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this job post?');">Delete</a>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>


                <div class="row pagination-wrap">
                    <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
                        <span>Showing <?= $skip + 1 ?>-<?= min($skip + $limit, $totalJobs) ?> of <?= $totalJobs ?>
                            Jobs</span>
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