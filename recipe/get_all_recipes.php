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

// Prepare the SQL query to fetch all recipes for the logged-in user
$sql = "SELECT * FROM recipes ORDER BY created_at DESC"; // Fetch recipes ordered by creation time

// Execute the query
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any recipes
    if ($result->num_rows > 0) {
        $recipes = [];
        
        // Fetch each recipe and add it to the $recipes array
        while ($recipe = $result->fetch_assoc()) {
            // Check if keys exist in the result set before accessing
            $recipes[] = [
                "id" => $recipe['id'],
                "name" => isset($recipe['recipe_name']) ? $recipe['recipe_name'] : '',
                "image_url" => isset($recipe['image_url']) ? $recipe['image_url'] : '',
                "origin" => isset($recipe['origin']) ? $recipe['origin'] : 'N/A', // Default if not available
                "division" => isset($recipe['division']) ? $recipe['division'] : 'N/A', // Default if not available
                "ingredients" => isset($recipe['ingredients']) ? explode(", ", $recipe['ingredients']) : [],
                "steps" => isset($recipe['instructions']) ? explode(", ", $recipe['instructions']) : [],
                "cooking_time" => isset($recipe['cooking_time']) ? $recipe['cooking_time'] : 'Unknown', // Default if not available
                "difficulty" => isset($recipe['difficulty']) ? $recipe['difficulty'] : 'Unknown', // Default if not available
                "description" => isset($recipe['description']) ? $recipe['description'] : 'No description available',
                "user_id" => isset($recipe['user_id']) ? $recipe['user_id'] : null,
                "status" => isset($recipe['status']) ? $recipe['status'] : 'Pending', // Default if not available
                "created_at" => isset($recipe['created_at']) ? $recipe['created_at'] : 'Unknown date'
            ];
        }

        // Return the recipes as a JSON response
        echo json_encode(["status" => "success", "data" => $recipes]);
    } else {
        echo json_encode(["status" => "error", "message" => "No recipes found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Error preparing SQL query"]);
}

$conn->close();
?>
