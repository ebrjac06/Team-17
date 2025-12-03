<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}

$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone_raw  = trim($_POST['phone'] ?? '');
$message    = trim($_POST['message'] ?? '');

if ($first_name === '' || $last_name === '' || $email === '' || $message === '') {
    echo json_encode(["status" => "error", "message" => "Please fill in all required fields."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format."]);
    exit;
}

$allowed_providers = [
    'gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 
    'live.com', 'icloud.com', 'aston.ac.uk'
];

$allowed_tlds = ['.com', '.co.uk', '.net', '.org', 'ac.uk'];

$domain = strtolower(substr(strrchr($email, "@"), 1));
$valid_email = false;

if (in_array($domain, $allowed_providers)) {
    $valid_email = true;
} else {
    foreach ($allowed_tlds as $tld) {
        if (substr_compare($domain, $tld, -strlen($tld)) === 0) {
            $valid_email = true;
            break;
        }
    }
}


if (!$valid_email) {
    echo json_encode(["status" => "error", "message" => "Please enter a valid email address"]);
    exit;
}

$phone = preg_replace('/\D+/', '', $phone_raw);
if ($phone !== '' && (strlen($phone) < 10 || strlen($phone) > 15)) {
    echo json_encode(["status" => "error", "message" => "Please enter a valid phone number"]);
    exit;
}

$phone_digits = preg_replace('/\D+/', '', $phone_raw);
if ($phone_raw !== '' && strlen($phone_digits) < 10) {
    echo json_encode(["status" => "error", "message" => "Please enter a valid phone number"]);
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "dripandco";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO contact_form (first_name, last_name, email, phone, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $message);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Message sent successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Could not send message."]);
}

$stmt->close();
$conn->close();
?>
