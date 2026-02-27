<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $eventName = trim($_POST['eventName'] ?? '');
    
    // Server-side validation
    $errors = [];
    
    // Validate full name
    if (empty($fullName) || strlen($fullName) < 3) {
        $errors[] = "Full name must be at least 3 characters long.";
    }
    
    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    // Validate phone
    if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Please enter a valid 10-digit phone number.";
    }
    
    // Validate event
    if (empty($eventName)) {
        $errors[] = "Please select an event.";
    }
    
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => implode(' ', $errors)
        ]);
        exit;
    }
    
    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'This email is already registered!'
        ]);
        $checkStmt->close();
        exit;
    }
    $checkStmt->close();
    
    // Insert data
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, event_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $email, $phone, $eventName);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => '✅ Registration successful! Redirecting...',
            'redirect' => 'registration_success.html'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Registration failed. Please try again.'
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
$conn->close();
?>