<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Check if the user is logged in (session exists)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not authenticated"]);
    exit;
}

// Get the user_id from the session (if needed for filtering or customizations)
$user_id = $_SESSION['user_id']; // Automatically handle user ID from session

// Get the recipe ID from the URL parameter (e.g., /api/recipes/delete/{id})
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
} else {
    echo json_encode(["status" => "error", "message" => "Recipe ID is missing"]);
    exit;
}

// Prepare the SQL query to delete the recipe by ID and ensure it's the logged-in user's recipe
$sql = "DELETE FROM recipes WHERE id = ? AND user_id = ?";

// Execute the query
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ii", $recipe_id, $user_id); // Bind the recipe_id and user_id parameters to the query
    $stmt->execute();

    // Check if the recipe was deleted
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Recipe deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Recipe not found or not authorized to delete"]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Error preparing SQL query"]);
}

$conn->close();
?>
