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

// Get the recipe ID from the URL parameter (e.g., /api/recipes/update/{id})
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
} else {
    echo json_encode(["status" => "error", "message" => "Recipe ID is missing"]);
    exit;
}

// Get the raw POST data from the body (for the fields to be updated)
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required data is present
if (isset($data['name']) && isset($data['image_url']) && isset($data['origin']) && isset($data['division']) && isset($data['ingredients']) && isset($data['steps']) && isset($data['cooking_time']) && isset($data['difficulty']) && isset($data['description']) && isset($data['status'])) {
    
    // Prepare the values to be updated
    $name = $data['name'];
    $image_url = $data['image_url'];
    $origin = $data['origin'];
    $division = $data['division'];
    $ingredients = implode(", ", $data['ingredients']); // Convert array to string
    $steps = implode(", ", $data['steps']); // Convert array to string
    $cooking_time = $data['cooking_time'];
    $difficulty = $data['difficulty'];
    $description = $data['description'];
    $status = $data['status'];

    // Prepare SQL query to update the recipe
    $sql = "UPDATE recipes SET recipe_name = ?, image_url = ?, origin = ?, division = ?, ingredients = ?, instructions = ?, cooking_time = ?, difficulty = ?, description = ?, status = ? WHERE id = ? AND user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the SQL query
        if (!$stmt->bind_param("ssssssssssii", $name, $image_url, $origin, $division, $ingredients, $steps, $cooking_time, $difficulty, $description, $status, $recipe_id, $user_id)) {
            echo json_encode(["status" => "error", "message" => "Error binding parameters"]);
            exit;
        }

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Recipe updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing SQL query: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input, missing required fields"]);
}

$conn->close();
?>
