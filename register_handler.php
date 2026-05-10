<?php
// Solve cross-domain issues
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

// Handle OPTIONS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration (MODIFY THESE VALUES TO YOUR MYSQL SETTINGS)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'used_car_db';

// Connect to MySQL database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check database connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Receive POST data from frontend
$input = json_decode(file_get_contents('php://input'), true);
$response = [
    'success' => false,
    'message' => ''
];

// Check if form data is received
if (empty($input)) {
    $response['message'] = 'No form data received';
    echo json_encode($response);
    exit();
}

// Extract and filter form data
$role = $input['role'] ?? '';
$fullName = trim($input['fullName'] ?? '');
$address = trim($input['address'] ?? '');
$phone = trim($input['phone'] ?? '');
$email = trim($input['email'] ?? '');
$username = trim($input['username'] ?? '');
$password = trim($input['password'] ?? '');

// Backend data validation
$errors = [];

// Validate user role
if (!in_array($role, ['buyer', 'seller'])) {
    $errors[] = 'Invalid user role selected';
}

// Validate full name (letters and spaces only)
if (!preg_match('/^[A-Za-z\s]+$/', $fullName)) {
    $errors[] = 'Full name only allows letters and spaces';
}

// Validate address (letters, numbers and spaces only)
if (!preg_match('/^[A-Za-z0-9\s]+$/', $address)) {
    $errors[] = 'Address only allows letters, numbers and spaces';
}

// Validate Chinese phone number (11 digits)
if (!preg_match('/^1[3-9]\d{9}$/', $phone)) {
    $errors[] = 'Please enter a valid 11-digit phone number';
}

// Validate email format
if (!preg_match('/^[^\s@]+@[^\s@]+\.(com|cn)$/', $email)) {
    $errors[] = 'Invalid email format (must contain @ and end with .com/.cn)';
}

// Validate username (min 6 letters/numbers)
if (!preg_match('/^[A-Za-z0-9]{6,}$/', $username)) {
    $errors[] = 'Username must be at least 6 characters (letters/numbers)';
}

// Validate password (min 6 letters/numbers)
if (!preg_match('/^[A-Za-z0-9]{6,}$/', $password)) {
    $errors[] = 'Password must be at least 6 characters (letters/numbers)';
}

// Return validation errors if any
if (!empty($errors)) {
    $response['message'] = implode('; ', $errors);
    echo json_encode($response);
    exit();
}

// Check if username/phone/email already exists
$checkSql = "SELECT * FROM users WHERE username = ? OR phone = ? OR email = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("sss", $username, $phone, $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $row = $checkResult->fetch_assoc();
    if ($row['username'] === $username) {
        $response['message'] = 'Username already exists';
    } elseif ($row['phone'] === $phone) {
        $response['message'] = 'Phone number already registered';
    } else {
        $response['message'] = 'Email already registered';
    }
    echo json_encode($response);
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// Encrypt password (irreversible encryption)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into database (prepared statement to prevent SQL injection)
$insertSql = "INSERT INTO users (role, fullName, address, phone, email, username, password) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("sssssss", $role, $fullName, $address, $phone, $email, $username, $hashedPassword);

if ($insertStmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Registration successful!';
} else {
    $response['message'] = 'Registration failed: ' . $insertStmt->error;
}

// Close database connection and return response
$insertStmt->close();
$conn->close();
echo json_encode($response);
?>