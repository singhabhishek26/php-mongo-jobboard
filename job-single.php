<?php include("partials/header.php"); ?>
<?php include("partials/loader.php"); ?>
<?php

$mongo = new MongoConnection();

$jobId = $_GET['id'] ?? null;
if (!$jobId) {
    echo "Invalid Job ID.";
    exit;
}

$filter = ['_id' => new MongoDB\BSON\ObjectId($jobId)];
$query = new MongoDB\Driver\Query($filter);

try {
    $cursor = $mongo->getManager()->executeQuery("{$mongo->getDb()}.{$mongo->getCollection()}", $query);
    $job = current($cursor->toArray());
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = 6;
    $skip = ($page - 1) * $limit;
    $countCommand = new MongoDB\Driver\Command([
        'count' => 'jobs'
    ]);

    if (!$job) {
        echo "Job not found.";
        exit;
    }
} catch (Exception $e) {
    echo "Error fetching job: " . $e->getMessage();
    exit;
}

?>

<div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>


    <!-- NAVBAR -->
    <?php include("partials/navbar.php"); ?>

    <!-- HOME -->
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('images/hero_1.jpg');"
        id="home-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-white font-weight-bold"><?php echo $job->title ?></h1>
                    <div class="custom-breadcrumbs">
                        <a href="#">Home</a> <span class="mx-2 slash">/</span>
                        <a href="#">Job</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong><?php echo $job->title ?></strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="site-section">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center">
                        <div class="border p-2 d-inline-block mr-3 rounded">
                            <img src="<?php echo $job->company->logo ?>" alt="Image">
                        </div>
                        <div>
                            <h2><?php echo $job->title ?></h2>
                            <div>
                                <span class="ml-0 mr-2 mb-2"><span
                                        class="icon-briefcase mr-2"></span><?php echo $job->company->name ?></span>
                                <span class="m-2"><span
                                        class="icon-room mr-2"></span><?php echo  $job->location ?></span>
                                <span class="m-2"><span class="icon-clock-o mr-2"></span><span
                                        class="text-primary"><?php echo  $job->job_type  ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" class="btn btn-block btn-light btn-md"><span
                                    class="icon-heart-o mr-2 text-danger"></span>Save Job</a>
                        </div>
                        <div class="col-6">
                            <a href="job-candidate-apply.php?id=<?php echo $jobId; ?>"
                                class="btn btn-block btn-primary btn-md">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <figure class="mb-5"><img src="images/job_single_img_1.jpg" alt="Image"
                                class="img-fluid rounded"></figure>
                        <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span
                                class="icon-align-left mr-3"></span>Job Description</h3>
                        <p><?php echo $job->description ?></p>
                    </div>
                    <div class="mb-5">
                        <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span
                                class="icon-rocket mr-3"></span>Responsibilities</h3>
                        <ul class="list-unstyled m-0 p-0">
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Necessitatibus quibusdam
                                    facilis</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Velit unde aliquam et
                                    voluptas reiciendis n Velit unde aliquam et voluptas reiciendis non sapiente
                                    labore</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Commodi quae ipsum quas est
                                    itaque</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Lorem ipsum dolor sit amet,
                                    consectetur adipisicing elit</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Deleniti asperiores
                                    blanditiis nihil quia officiis dolor</span></li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span
                                class="icon-book mr-3"></span>Education + Experience</h3>
                        <ul class="list-unstyled m-0 p-0">
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Necessitatibus quibusdam
                                    facilis</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Velit unde aliquam et
                                    voluptas reiciendis non sapiente labore</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Commodi quae ipsum quas est
                                    itaque</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Lorem ipsum dolor sit amet,
                                    consectetur adipisicing elit</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Deleniti asperiores
                                    blanditiis nihil quia officiis dolor</span></li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span
                                class="icon-turned_in mr-3"></span>Other Benifits</h3>
                        <ul class="list-unstyled m-0 p-0">
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Necessitatibus quibusdam
                                    facilis</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Velit unde aliquam et
                                    voluptas reiciendis non sapiente labore</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Commodi quae ipsum quas est
                                    itaque</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Lorem ipsum dolor sit amet,
                                    consectetur adipisicing elit</span></li>
                            <li class="d-flex align-items-start mb-2"><span
                                    class="icon-check_circle mr-2 text-muted"></span><span>Deleniti asperiores
                                    blanditiis nihil quia officiis dolor</span></li>
                        </ul>
                    </div>

                    <div class="row mb-5">
                        <div class="col-6">
                            <a href="#" class="btn btn-block btn-light btn-md"><span
                                    class="icon-heart-o mr-2 text-danger"></span>Save Job</a>
                        </div>
                        <div class="col-6">
                            <a href="job-candidate-apply.php?id=<?php echo $jobId; ?>"
                                class="btn btn-block btn-primary btn-md">Apply Now</a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="bg-light p-3 border rounded mb-4">
                        <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Job Summary</h3>
                        <ul class="list-unstyled pl-3 mb-0">
                            <li class="mb-2"><strong class="text-black">Published
                                    on: </strong><?php echo $job->created_at->toDateTime()->format('F j, Y'); ?>
                            </li>
                            <li class="mb-2"><strong class="text-black">Vacancy:</strong> 20</li>
                            <li class="mb-2"><strong class="text-black">Employment Status:</strong>
                                <?php echo $job->job_type; ?></li>
                            <li class="mb-2"><strong class="text-black">Experience:</strong> 2 to 3 year(s)</li>
                            <li class="mb-2"><strong class="text-black">Job
                                    Location:</strong><?php echo $job->location ?></li>
                            <li class="mb-2"><strong class="text-black">Salary:</strong> $60k - $100k</li>
                            <li class="mb-2"><strong class="text-black">Gender:</strong> Any</li>
                            <li class="mb-2"><strong class="text-black">Application Deadline:</strong> April 28, 2019
                            </li>
                        </ul>
                    </div>

                    <div class="bg-light p-3 border rounded">
                        <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Share</h3>
                        <div class="px-3">
                            <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-facebook"></span></a>
                            <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
                            <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
                            <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-pinterest"></span></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="site-section" id="next">
        <div class="container">

            <div class="row mb-5 justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="section-title mb-2">22,392 Related Jobs</h2>
                </div>
            </div>

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
                    <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
                        <a href="job-single.php?id=<?= $job->_id ?>"></a>
                        <div class="job-listing-logo">
                            <img src="<?= $job->company->logo ?>" alt="<?= htmlspecialchars($job->company->name) ?>"
                                class="img-fluid">
                        </div>

                        <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
                            <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                                <h2><?= htmlspecialchars($job->title) ?></h2>
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
                            <a href="?id=<?= $job->_id ?>&page=<?= $page - 1 ?>" class="prev">Prev</a>
                        <?php endif; ?>

                        <div class="d-inline-block">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?id=<?= $job->_id ?>&page=<?= $i ?>"
                                    class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                        </div>

                        <?php if ($page < $totalPages): ?>
                            <a href="?id=<?= $job->_id ?>&page=<?= $page + 1 ?>" class="next">Next</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php include("partials/footer.php"); ?>