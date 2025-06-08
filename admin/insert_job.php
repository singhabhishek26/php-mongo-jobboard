<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $conn = new MongoConnection();
        $manager = $conn->getManager();
        $bulk = new MongoDB\Driver\BulkWrite;

        // Helper to sanitize
        function sanitize($key)
        {
            return htmlspecialchars(trim($_POST[$key] ?? ""));
        }

        // Prepare job data
        $job = [
            "email" => sanitize("email"),
            "title" => sanitize("job-title"),
            "location" => sanitize("job-location"),
            "region" => sanitize("job-region"),
            "job_type" => sanitize("job-type"),
            "description" => $_POST["job_description"] ?? "",
            "company" => [
                "name" => sanitize("company-name"),
                "tagline" => sanitize("company-tagline"),
                "description" => $_POST["company_description"] ?? "",
                "website" => sanitize("company-website"),
                "facebook" => sanitize("company-website-fb"),
                "twitter" => sanitize("company-website-tw"),
                "linkedin" => sanitize("company-website-ln"),
            ],
            "created_at" => new MongoDB\BSON\UTCDateTime()
        ];

        // Folder to store uploads
        $uploadDir = __DIR__ . '/uploads/';
        $webPath = 'uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === 0) {
            $filename = uniqid('logo_') . '_' . basename($_FILES['company_logo']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['company_logo']['tmp_name'], $targetPath)) {
                $job['company']['logo'] = $webPath . $filename;
            }
        }

        $bulk->insert($job);
        $namespace = $conn->getDb() . "." . $conn->getCollection();
        $result = $manager->executeBulkWrite($namespace, $bulk);

        echo "✅ Job inserted successfully.";
        header("Location: create-job.php?&created=1");
    } catch (Exception $e) {
        echo "❌ Error inserting job: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}