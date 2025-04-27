<?php
// database connection settings
include '../connections/Connection.php';

// Allow cross-origin requests (for testing with Postman or other frontend apps)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data safely from POST request
    $data = json_decode(file_get_contents("php://input"), true);
    
    $user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
    $instrument_name = isset($data['instrument_name']) ? mysqli_real_escape_string($conn, $data['instrument_name']) : '';
    $description = isset($data['description']) ? mysqli_real_escape_string($conn, $data['description']) : '';
    $image_url = isset($data['image_url']) ? mysqli_real_escape_string($conn, $data['image_url']) : '';

    // Validate required fields
    if ($user_id > 0 && !empty($instrument_name) && !empty($description) && !empty($image_url)) {
        // Check if the user_id exists in the users table
        $user_check = mysqli_query($conn, "SELECT user_id FROM users WHERE user_id = $user_id");
        if (mysqli_num_rows($user_check) > 0) {
            $created_at = date('Y-m-d H:i:s');

            // Insert data into the heritage_instruments table
            $sql = "INSERT INTO heritage_instruments (user_id, instrument_name, description, image_url, created_at)
                    VALUES ($user_id, '$instrument_name', '$description', '$image_url', '$created_at')";

            if (mysqli_query($conn, $sql)) {
                $response = [
                    'status' => 'success',
                    'message' => 'Instrument created successfully.',
                    'instrument_id' => mysqli_insert_id($conn), // Return the inserted instrument ID
                ];

                // Send success response with HTTP 201 status
                http_response_code(201);
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to create instrument: ' . mysqli_error($conn)
                ];

                // Send error response with HTTP 500 status
                http_response_code(500);
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'User ID does not exist.'
            ];

            // Send error response with HTTP 400 status
            http_response_code(400);
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Missing required fields.'
        ];

        // Send error response with HTTP 400 status
        http_response_code(400);
    }
} else {
    // Invalid request method, only POST allowed
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];

    // Send error response with HTTP 405 status
    http_response_code(405);
}

// Set header to application/json and send response
header('Content-Type: application/json');
echo json_encode($response);

// Close connection
mysqli_close($conn);
?>
