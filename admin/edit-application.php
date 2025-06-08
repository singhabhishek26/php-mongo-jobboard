<?php
require_once "../database.php";

if (!isset($_GET['id'])) {
    die("Missing application ID");
}

$applicationId = $_GET['id'];

$conn = new MongoConnection();
$manager = $conn->getManager();
$db = $conn->getDb();

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

// Fetch existing application
$filter = ['_id' => new ObjectId($applicationId)];
$query = new MongoDB\Driver\Query($filter);
$applicationData = $manager->executeQuery("$db.applications", $query)->toArray();

if (empty($applicationData)) {
    die("Application not found");
}

$application = $applicationData[0];

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidateName = trim($_POST['candidate_name']);
    $email = trim($_POST['email']);
    $coverLetter = trim($_POST['cover_letter']);
    $expectedSalary = isset($_POST['expected_salary']) ? (int)$_POST['expected_salary'] : null;
    $joiningDate = isset($_POST['joining_date']) ? new UTCDateTime(strtotime($_POST['joining_date']) * 1000) : null;
    $appliedPosition = trim($_POST['applied_position']);

    $updateFields = [
        'candidate_name' => $candidateName,
        'email' => $email,
        'cover_letter' => $coverLetter,
        'expected_salary' => $expectedSalary,
        'joining_date' => $joiningDate,
        'applied_position' => $appliedPosition,
    ];

    $uploadsDir = "../uploads/";

    // Handle profile image update
    if (!empty($_FILES["profile_image"]["name"])) {
        $imageName = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $imagePath = $uploadsDir . $imageName;
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $imagePath)) {
            $updateFields['profile_image'] = "uploads/" . $imageName;
        }
    }

    // Handle resume update
    if (!empty($_FILES["resume"]["name"])) {
        $resumeName = time() . "_" . basename($_FILES["resume"]["name"]);
        $resumePath = $uploadsDir . $resumeName;
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $resumePath)) {
            $updateFields['resume'] = "uploads/" . $resumeName;
        }
    }

    $update = ['$set' => $updateFields];

    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(['_id' => new ObjectId($applicationId)], $update);

    try {
        $manager->executeBulkWrite("$db.applications", $bulk);
        header("Location: edit-application.php?id=$applicationId&updated=1");
        exit;
    } catch (Exception $e) {
        die("Error updating application: " . $e->getMessage());
    }
}
?>

<?php

require_once "partials/header.php";
require_once "partials/sidebar.php";

?>

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Update Job Application</h4>

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
                    <label>Name:</label>
                    <input type="text" class="form-control" name="candidate_name"
                        value="<?= htmlspecialchars($application->candidate_name) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email"
                        value="<?= htmlspecialchars($application->email) ?>" required>
                </div>
                <div class="form-group">
                    <label>Applied Position:</label>
                    <input type="text" class="form-control" name="applied_position"
                        value="<?= htmlspecialchars($application->applied_position ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Expected Salary:</label>
                    <input type="number" class="form-control" name="expected_salary"
                        value="<?= htmlspecialchars($application->expected_salary ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Joining Date:</label>
                    <input type="date" class="form-control" name="joining_date"
                        value="<?= isset($application->joining_date) ? $application->joining_date->toDateTime()->format('Y-m-d') : '' ?>">
                </div>
                <div class="form-group">
                    <label>Cover Letter:</label>
                    <textarea class="form-control"
                        name="cover_letter"><?= htmlspecialchars($application->cover_letter ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label>Profile Image:</label><br>
                    <?php if (!empty($application->profile_image)): ?>
                    <img src="../<?= $application->profile_image ?>" alt="Profile Image" width="100" class="mb-2"><br>
                    <?php endif; ?>
                    <input type="file" name="profile_image" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Resume:</label><br>
                    <?php if (!empty($application->resume)): ?>
                    <a href="../<?= $application->resume ?>" target="_blank" class="btn btn-sm btn-secondary mb-2">View
                        Resume</a><br>
                    <?php endif; ?>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx">
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Update Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "partials/footer.php"; ?>