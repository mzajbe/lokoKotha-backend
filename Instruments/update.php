<?php

// Include database connection
include '../connections/Connection.php';

// Enable CORS if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Return JSON response always
header('Content-Type: application/json');

// Only accept POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
    exit;
}

// Read input as JSON
$input = json_decode(file_get_contents('php://input'), true);

// Validate input fields
if (
    empty($input['id']) || empty($input['user_id']) ||
    empty($input['instrument_name']) || empty($input['description']) ||
    empty($input['image_url'])
) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields.'
    ]);
    exit;
}

// Collect and sanitize
$id = intval($input['id']);
$user_id = intval($input['user_id']);
$instrument_name = mysqli_real_escape_string($conn, $input['instrument_name']);
$description = mysqli_real_escape_string($conn, $input['description']);
$image_url = mysqli_real_escape_string($conn, $input['image_url']);

// Check if instrument exists
$instrument_check = mysqli_query($conn, "SELECT * FROM heritage_instruments WHERE id = $id");
if (mysqli_num_rows($instrument_check) === 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Instrument ID does not exist.'
    ]);
    exit;
}

// Check if user exists
$user_check = mysqli_query($conn, "SELECT user_id FROM users WHERE user_id = $user_id");
if (mysqli_num_rows($user_check) === 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User ID does not exist.'
    ]);
    exit;
}

// Update the instrument
$sql = "UPDATE heritage_instruments
        SET user_id = $user_id,
            instrument_name = '$instrument_name',
            description = '$description',
            image_url = '$image_url'
        WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Instrument updated successfully.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update instrument: ' . mysqli_error($conn)
    ]);
}

// Close database connection
mysqli_close($conn);
?>
