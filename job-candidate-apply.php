<?php include("partials/header.php"); ?>
<?php include("partials/loader.php"); ?>
<?php
require_once "database.php";

$jobId = $_GET['id'] ?? null;

// Redirect if not a valid session or employer trying to access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_employer']) || $_SESSION['is_employer']) {
    header("Location: index.php");
}

$candidateId = $_SESSION['user_id'];

$mongo = new MongoConnection();
$manager = $mongo->getManager();

$jobTitle = "";
$shortCode = "";

try {
    $filter = ['_id' => new MongoDB\BSON\ObjectId($jobId)];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery("{$mongo->getDb()}.jobs", $query);
    $job = current($cursor->toArray());

    if ($job) {
        $jobTitle = $job->title;
        $shortCode = "APP-" . strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $jobTitle), 0, 5)) . "-" . substr((string)$job->_id, -5);
    } else {
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
                    <h1 class="text-white font-weight-bold">Job Application</h1>
                    <div class="custom-breadcrumbs">
                        <a href="#">Home</a> <span class="mx-2 slash">/</span>
                        <a href="#">Job Application</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Apply for a Job</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="site-section">
        <div class="container">

            <div class="row align-items-center mb-5">
                <div class="col-12 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2>Job Application for <?= htmlspecialchars($jobTitle) ?> (<?= $shortCode ?>)</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <form class="p-4 p-md-5 border rounded" method="post" action="submit_application.php"
                        enctype="multipart/form-data">
                        <input type="hidden" name="job_id" value="<?= htmlspecialchars($jobId) ?>">
                        <input type="hidden" name="candidate_id" value="<?= htmlspecialchars($candidateId) ?>">

                        <div class="form-group">
                            <label for="candidate_name">Your Name</label>
                            <input type="text" class="form-control" name="candidate_name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="profile_image">Upload Profile Image</label>
                            <input type="file" class="form-control" name="profile_image" accept="image/*" required>
                        </div>

                        <div class="form-group">
                            <label for="resume">Upload Resume (PDF)</label>
                            <input type="file" class="form-control" name="resume" accept="application/pdf" required>
                        </div>

                        <div class="form-group">
                            <label for="cover_letter">Cover Letter</label>
                            <textarea class="form-control" name="cover_letter" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="expected_salary">Expected Salary</label>
                            <input type="number" class="form-control" name="expected_salary" required>
                        </div>

                        <div class="form-group">
                            <label for="joining_date">Available Joining Date</label>
                            <input type="date" class="form-control" name="joining_date" required>
                        </div>

                        <div class="form-group">
                            <label for="applied_position">Applied Position</label>
                            <input type="text" class="form-control" name="applied_position" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-md">Submit Application</button>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <?php include("partials/footer.php"); ?>