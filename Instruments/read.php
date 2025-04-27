<?php

// Include database connection
include '../connections/Connection.php';

// Enable CORS if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Always return JSON
header('Content-Type: application/json');

// Only allow GET method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Only GET is allowed.'
    ]);
    exit;
}

// Fetch data from heritage_instruments table
$sql = "SELECT id, user_id, instrument_name, description, image_url, created_at FROM heritage_instruments";
$result = mysqli_query($conn, $sql);

// Prepare the response
if ($result && mysqli_num_rows($result) > 0) {
    $instruments = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $instruments[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $instruments
    ]);
} else {
    echo json_encode([
        'status' => 'success',
        'data' => [],
        'message' => 'No instruments found.'
    ]);
}

// Close connection
mysqli_close($conn);
?>
