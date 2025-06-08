<?php
require_once "../database.php";
session_start();

// Validate
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['job_id'], $_POST['candidate_id'])) {
    die("Invalid access.");
}

$mongo = new MongoConnection();
$manager = $mongo->getManager();

// Sanitize input
$jobId = $_POST['job_id'];
$candidateId = $_POST['candidate_id'];
$candidateName = trim($_POST['candidate_name']);
$email = trim($_POST['email']);
$coverLetter = trim($_POST['cover_letter']);
$expectedSalary = isset($_POST['expected_salary']) ? (int)$_POST['expected_salary'] : null;
$joiningDate = isset($_POST['joining_date']) ? $_POST['joining_date'] : null;
$appliedPosition = trim($_POST['applied_position']);

// File uploads
$uploadsDir = "../uploads/";
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$imageName = time() . "_" . basename($_FILES["profile_image"]["name"]);
$resumeName = time() . "_" . basename($_FILES["resume"]["name"]);

$imagePath = $uploadsDir . $imageName;
$resumePath = $uploadsDir . $resumeName;

if (!move_uploaded_file($_FILES["profile_image"]["tmp_name"], $imagePath)) {
    die("Failed to upload profile image.");
}

if (!move_uploaded_file($_FILES["resume"]["tmp_name"], $resumePath)) {
    die("Failed to upload resume.");
}

$application = [
    'job_id' => new MongoDB\BSON\ObjectId($jobId),
    'candidate_id' => new MongoDB\BSON\ObjectId($candidateId),
    'candidate_name' => $candidateName,
    'email' => $email,
    'profile_image' => "uploads/" . $imageName,
    'resume' => "uploads/" . $resumeName,
    'cover_letter' => $coverLetter,
    'expected_salary' => $expectedSalary,
    'joining_date' => $joiningDate ? new MongoDB\BSON\UTCDateTime(strtotime($joiningDate) * 1000) : null,
    'applied_position' => $appliedPosition,
    'applied_at' => new MongoDB\BSON\UTCDateTime()
];

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->insert($application);

try {
    $manager->executeBulkWrite("{$mongo->getDb()}.applications", $bulk);
    header("Location: job-single.php?id=$jobId");
} catch (Exception $e) {
    die("Error saving application: " . $e->getMessage());
}