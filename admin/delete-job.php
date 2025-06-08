<?php
require_once "../database.php";

if (!isset($_GET['id'])) {
    die("No job ID provided.");
}

$jobId = $_GET['id'];

try {
    $conn = new MongoConnection();
    $manager = $conn->getManager();

    $bulk = new MongoDB\Driver\BulkWrite();
    $bulk->delete(['_id' => new MongoDB\BSON\ObjectId($jobId)]);

    $result = $manager->executeBulkWrite("jobboard.jobs", $bulk);

    // Redirect after delete
    header("Location: alljobs.php?deleted=1");
    exit;
} catch (Exception $e) {
    echo "Error deleting job: " . $e->getMessage();
}