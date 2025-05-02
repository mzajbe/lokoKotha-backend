<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Ensure the user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated"]);
    exit;
}

// Get the elder wisdom ID from the URL parameter
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    echo json_encode(["success" => false, "message" => "Missing elder wisdom ID"]);
    exit;
}

// Get the raw POST data from the body
$data = json_decode(file_get_contents("php://input"), true);

// Check if at least one field to update is provided
if (empty($data['title']) && empty($data['elder_age']) && empty($data['status'])) {
    echo json_encode(["success" => false, "message" => "No fields to update"]);
    exit;
}

// Prepare SQL query to update elder wisdom data
$sql = "UPDATE elder_wisdom SET 
            title = IFNULL(?, title), 
            elder_age = IFNULL(?, elder_age), 
            status = IFNULL(?, status) 
        WHERE id = ?";

// Prepare the query
if ($stmt = $conn->prepare($sql)) {
    // Bind parameters to the query
    $stmt->bind_param("siis", 
        $data['title'], 
        $data['elder_age'], 
        $data['status'], 
        $id);

    // Execute the query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Elder wisdom updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "No changes were made"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error executing query: " . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Error preparing SQL query"]);
}

$conn->close();
?>
