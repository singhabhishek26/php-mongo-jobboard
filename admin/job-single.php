<?php
require_once "../database.php";

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
    if (!$job) {
        echo "Job not found.";
        exit;
    }
} catch (Exception $e) {
    echo "Error fetching job: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulk = new MongoDB\Driver\BulkWrite();
    $update = [
        '$set' => [
            'email' => $_POST['email'] ?? '',
            'title' => $_POST['job-title'] ?? '',
            'location' => $_POST['job-location'] ?? '',
            'region' => $_POST['job-region'] ?? '',
            'job_type' => $_POST['job-type'] ?? '',
            'description' => $_POST['job_description'] ?? '',
            'company.name' => $_POST['company-name'] ?? '',
            'company.tagline' => $_POST['company-tagline'] ?? '',
            'company.description' => $_POST['company_description'] ?? '',
            'company.website' => $_POST['company-website'] ?? '',
            'company.facebook' => $_POST['company-website-fb'] ?? '',
            'company.twitter' => $_POST['company-website-tw'] ?? '',
            'company.linkedin' => $_POST['company-website-li'] ?? ''
        ]
    ];
    $bulk->update($filter, $update);
    $mongo->getManager()->executeBulkWrite("{$mongo->getDb()}.{$mongo->getCollection()}", $bulk);
    header("Location: job-single.php?id=" . $jobId . '&updated=1');
}


require_once "partials/header.php";
require_once "partials/sidebar.php";
?>

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Update Job Post</h4>
            <?php if (isset($_GET['updated'])): ?>
            <div id="update-alert" class="alert alert-success">Job post updated successfully!</div>
            <script>
            setTimeout(function() {
                const alertBox = document.getElementById('update-alert');
                if (alertBox) {
                    alertBox.style.transition = 'opacity 0.5s ease';
                    alertBox.style.opacity = '0';
                    setTimeout(() => {
                        alertBox.remove();
                        // Remove `deleted` param and reload page
                        const url = new URL(window.location.href);
                        url.searchParams.delete('updated');
                        window.location.href = url.toString();
                    }, 500); // After fade out
                }
            }, 3000);
            </script>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($job->email) ?>">
                </div>
                <div class="form-group">
                    <label>Job Title</label>
                    <input type="text" name="job-title" class="form-control"
                        value="<?= htmlspecialchars($job->title) ?>">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="job-location" class="form-control"
                        value="<?= htmlspecialchars($job->location) ?>">
                </div>
                <div class="form-group">
                    <label>Region</label>
                    <input type="text" name="job-region" class="form-control"
                        value="<?= htmlspecialchars($job->region) ?>">
                </div>
                <div class="form-group">
                    <label>Job Type</label>
                    <input type="text" name="job-type" class="form-control"
                        value="<?= htmlspecialchars($job->job_type) ?>">
                </div>
                <div class="form-group">
                    <label>Job Description</label>
                    <div class="editor" id="editor-1">
                        <?= htmlspecialchars($job->description) ?>
                    </div>
                    <input type="hidden" name="job_description" id="job_description_input">
                </div>
                <h3>Company Details</h3>
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="company-name" class="form-control"
                        value="<?= htmlspecialchars($job->company->name ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Tagline</label>
                    <input type="text" name="company-tagline" class="form-control"
                        value="<?= htmlspecialchars($job->company->tagline ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Company Description</label>
                    <div class="editor" id="editor-2">
                        <?= htmlspecialchars($job->company->description ?? '') ?>
                    </div>
                    <input type="hidden" name="company_description" id="company_description_input">
                </div>
                <div class="form-group">
                    <label>Website</label>
                    <input type="text" name="company-website" class="form-control"
                        value="<?= htmlspecialchars($job->company->website ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" name="company-website-fb" class="form-control"
                        value="<?= htmlspecialchars($job->company->facebook ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Twitter</label>
                    <input type="text" name="company-website-tw" class="form-control"
                        value="<?= htmlspecialchars($job->company->twitter ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="text" name="company-website-li" class="form-control"
                        value="<?= htmlspecialchars($job->company->linkedin ?? '') ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Job</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "partials/footer.php"; ?>