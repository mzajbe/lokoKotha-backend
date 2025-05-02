<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Check if the user is logged in (session exists)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['user_id']; // Get user ID from session


// Get the raw POST data from the body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required data is present
if (isset($data['name']) && isset($data['image_url']) && isset($data['origin']) && isset($data['division']) && isset($data['ingredients']) && isset($data['steps']) && isset($data['cooking_time']) && isset($data['difficulty']) && isset($data['description'])) {
    
    $name = $data['name'];
    $image_url = $data['image_url'];
    $origin = $data['origin'];
    $division = $data['division'];
    $ingredients = implode(", ", $data['ingredients']); // Convert array to string
    $steps = implode(", ", $data['steps']); // Convert array to string
    $cooking_time = $data['cooking_time'];
    $difficulty = $data['difficulty'];
    $description = $data['description'];

    // Prepare SQL query to insert the new recipe
    $sql = "INSERT INTO recipes (user_id, recipe_name, category, ingredients, instructions, image_url, video_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the SQL query
        $stmt->bind_param("issssss", $user_id, $name, $origin, $ingredients, $steps, $image_url, $video_url);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Recipe created successfully"]);
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
