<?php include("partials/header.php"); ?>
<?php include("partials/loader.php"); ?>
<?php
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$skip = ($page - 1) * $limit;
$countCommand = new MongoDB\Driver\Command([
    'count' => 'jobs'
]);


?>


<div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->


    <!-- NAVBAR -->
    <?php include("partials/navbar.php"); ?>

    <!-- HOME -->
    <section class="home-section section-hero overlay bg-image" style="background-image: url('images/hero_1.jpg');"
        id="home-section">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12">
                    <div class="mb-5 text-center">
                        <h1 class="text-white font-weight-bold">The Easiest Way To Get Your Dream Job</h1>
                    </div>
                    <form method="post" class="search-jobs-form">
                        <div class="row mb-5">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                <input type="text" class="form-control form-control-lg"
                                    placeholder="Job title, Company...">
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                <select class="selectpicker" data-style="btn-white btn-lg" data-width="100%"
                                    data-live-search="true" title="Select Region">
                                    <option>Anywhere</option>
                                    <option>San Francisco</option>
                                    <option>Palo Alto</option>
                                    <option>New York</option>
                                    <option>Manhattan</option>
                                    <option>Ontario</option>
                                    <option>Toronto</option>
                                    <option>Kansas</option>
                                    <option>Mountain View</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                <select class="selectpicker" data-style="btn-white btn-lg" data-width="100%"
                                    data-live-search="true" title="Select Job Type">
                                    <option>Part Time</option>
                                    <option>Full Time</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn-block text-white btn-search"><span
                                        class="icon-search icon mr-2"></span>Search Job</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 popular-keywords">
                                <h3>Trending Keywords:</h3>
                                <ul class="keywords list-unstyled m-0 p-0">
                                    <li><a href="#" class="">UI Designer</a></li>
                                    <li><a href="#" class="">Python</a></li>
                                    <li><a href="#" class="">Developer</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <a href="#next" class="scroll-button smoothscroll">
            <span class=" icon-keyboard_arrow_down"></span>
        </a>

    </section>

    <section class="py-5 bg-image overlay-primary fixed overlay" id="next"
        style="background-image: url('images/hero_1.jpg');">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="section-title mb-2 text-white">JobBoard Site Stats</h2>
                    <p class="lead text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita
                        unde officiis recusandae sequi excepturi corrupti.</p>
                </div>
            </div>
            <div class="row pb-0 block__19738 section-counter">

                <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <strong class="number" data-number="15">0</strong>
                    </div>
                    <span class="caption">Candidates</span>
                </div>

                <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <strong class="number" data-number="10">0</strong>
                    </div>
                    <span class="caption">Jobs Posted</span>
                </div>

                <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <strong class="number" data-number="2">0</strong>
                    </div>
                    <span class="caption">Jobs Filled</span>
                </div>

                <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <strong class="number" data-number="20">0</strong>
                    </div>
                    <span class="caption">Companies</span>
                </div>


            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="container">

            <div class="row mb-5 justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="section-title mb-2">10 Job Listed</h2>
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


        </div>
    </section>

    <section class="py-5 bg-image overlay-primary fixed overlay" style="background-image: url('images/hero_1.jpg');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="text-white">Looking For A Job?</h2>
                </div>
                <div class="col-md-3 ml-auto">
                    <a href="signup.php" class="btn btn-warning btn-block btn-lg">Sign Up</a>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section py-4">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-12 text-center mt-4 mb-5">
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <h2 class="section-title mb-2">Company We've Helped</h2>
                            <p class="lead">Porro error reiciendis commodi beatae omnis similique voluptate rerum
                                ipsam fugit mollitia ipsum facilis expedita tempora suscipit iste</p>
                        </div>
                    </div>

                </div>
                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_mailchimp.svg" alt="Image" class="img-fluid logo-1">
                </div>
                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_paypal.svg" alt="Image" class="img-fluid logo-2">
                </div>
                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_stripe.svg" alt="Image" class="img-fluid logo-3">
                </div>
                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_visa.svg" alt="Image" class="img-fluid logo-4">
                </div>

                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_apple.svg" alt="Image" class="img-fluid logo-5">
                </div>
                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_tinder.svg" alt="Image" class="img-fluid logo-6">
                </div>
                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_sony.svg" alt="Image" class="img-fluid logo-7">
                </div>
                <div class="col-6 col-lg-3 col-md-6 text-center">
                    <img src="images/logo_airbnb.svg" alt="Image" class="img-fluid logo-8">
                </div>
            </div>
        </div>
    </section>

    <?php include("partials/footer.php"); ?>