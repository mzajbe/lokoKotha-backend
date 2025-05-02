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

// Get the recipe ID from the URL parameter (e.g., /api/recipes/{id})
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
} else {
    echo json_encode(["status" => "error", "message" => "Recipe ID is missing"]);
    exit;
}

// Prepare the SQL query to fetch the recipe by ID
$sql = "SELECT * FROM recipes WHERE id = ?";

// Execute the query
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $recipe_id); // Bind the recipe_id parameter to the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the recipe exists
    if ($result->num_rows > 0) {
        $recipe = $result->fetch_assoc();

        // Handle missing data fields using isset() and provide default values if necessary
        $recipe_data = [
            "id" => $recipe['id'],
            "name" => isset($recipe['recipe_name']) ? $recipe['recipe_name'] : 'N/A',
            "image_url" => isset($recipe['image_url']) ? $recipe['image_url'] : 'N/A',
            "origin" => isset($recipe['origin']) ? $recipe['origin'] : 'N/A',
            "division" => isset($recipe['division']) ? $recipe['division'] : 'N/A',
            "ingredients" => isset($recipe['ingredients']) ? explode(", ", $recipe['ingredients']) : [],
            "steps" => isset($recipe['instructions']) ? explode(", ", $recipe['instructions']) : [],
            "cooking_time" => isset($recipe['cooking_time']) ? $recipe['cooking_time'] : 'Unknown',
            "difficulty" => isset($recipe['difficulty']) ? $recipe['difficulty'] : 'Unknown',
            "description" => isset($recipe['description']) ? $recipe['description'] : 'No description available',
            "user_id" => isset($recipe['user_id']) ? $recipe['user_id'] : null,
            "status" => isset($recipe['status']) ? $recipe['status'] : 'Pending',
            "created_at" => isset($recipe['created_at']) ? $recipe['created_at'] : 'Unknown date'
        ];

        // Return the recipe data as a JSON response
        echo json_encode(["status" => "success", "data" => $recipe_data]);
    } else {
        echo json_encode(["status" => "error", "message" => "Recipe not found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Error preparing SQL query"]);
}

$conn->close();
?>
