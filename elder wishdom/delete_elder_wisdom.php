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

// Prepare SQL query to delete the elder wisdom record by ID
$sql = "DELETE FROM elder_wisdom WHERE id = ?";

// Prepare the query
if ($stmt = $conn->prepare($sql)) {
    // Bind the ID parameter to the query
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Elder wisdom deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Elder wisdom not found"]);
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
