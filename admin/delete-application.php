<?php
require_once "../database.php";
session_start();

if (!isset($_GET['id'])) {
    die("Missing application ID");
}

$appId = $_GET['id'];

try {
    $conn = new MongoConnection();
    $manager = $conn->getManager();

    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['_id' => new MongoDB\BSON\ObjectId($appId)]);

    $manager->executeBulkWrite("jobboard.applications", $bulk);

    header("Location: applied-jobs.php?deleted=1");
    exit;
} catch (Exception $e) {
    die("Failed to delete application: " . $e->getMessage());
}