<?php

// Include database connection
include '../connections/Connection.php';

// Set headers
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? intval($input['id']) : 0;

    if ($id > 0) {
        $sql = "DELETE FROM heritage_instruments WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            $response = [
                'status' => 'success',
                'message' => 'Instrument deleted successfully.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to delete instrument: ' . mysqli_error($conn)
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid instrument ID.'
        ];
    }

    echo json_encode($response);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}

// Close connection
mysqli_close($conn);
?>
