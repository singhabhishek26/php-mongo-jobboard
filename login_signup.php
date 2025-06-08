<?php
include 'database.php';

session_start();

$mongo = new MongoConnection();
$manager = $mongo->getManager();
$dbName = $mongo->getDb();

function getCollectionName(bool $isEmployer): string
{
    return $isEmployer ? 'employers' : 'candidates';
}

function findUser($manager, $dbName, $collection, $email)
{
    $filter = ['email' => $email];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery("$dbName.$collection", $query);
    foreach ($cursor as $user) {
        return $user;
    }
    return null;
}

function insertUser($manager, $dbName, $collection, $userData)
{
    $bulk = new MongoDB\Driver\BulkWrite();
    $bulk->insert($userData);
    $result = $manager->executeBulkWrite("$dbName.$collection", $bulk);
    return $result->getInsertedCount() === 1;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Invalid request method'];
    header('Location: login.php');
    exit;
}

$action = $_POST['action'] ?? 'login';
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$name = trim($_POST['name'] ?? '');
$re_password = $_POST['re_password'] ?? '';
$is_employer = isset($_POST['is_employer']) && ($_POST['is_employer'] == '1' || $_POST['is_employer'] === 'on');

if ($action === 'login') {
    if (!$email || !$password) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Email and password are required'];
        header('Location: login.php');
        exit;
    }

    $collection = getCollectionName($is_employer);
    $user = findUser($manager, $dbName, $collection, $email);

    if (!$user) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'User not found'];
        header('Location: login.php');
        exit;
    }

    if (!password_verify($password, $user->password)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Invalid password'];
        header('Location: login.php');
        exit;
    }

    // Set session on successful login
    $_SESSION['user_id'] = (string)$user->_id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    $_SESSION['is_employer'] = $is_employer;

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Login successful'];
    header('Location: index.php');
    exit;
}

if ($action === 'signup') {
    if (!$name || !$email || !$password || !$re_password) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'All fields are required'];
        header('Location: signup.php');
        exit;
    }

    if ($password !== $re_password) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Passwords do not match'];
        header('Location: signup.php');
        exit;
    }

    $collection = getCollectionName($is_employer);

    if (findUser($manager, $dbName, $collection, $email)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Email already registered'];
        header('Location: signup.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $userData = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'is_employer' => $is_employer,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ];

    $inserted = insertUser($manager, $dbName, $collection, $userData);

    if ($inserted) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registration successful! Please login.'];
        header('Location: login.php');
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Registration failed'];
        header('Location: signup.php');
    }
    exit;
}

$_SESSION['flash'] = ['type' => 'danger', 'message' => 'Invalid action'];
header('Location: login.php');
exit;