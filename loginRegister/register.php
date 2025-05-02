<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Get the raw POST data from the body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required data is present
if (isset($data['email']) && isset($data['password']) && isset($data['username']) && isset($data['division'])) {
    $email = $data['email'];
    $password = $data['password'];  // Store password as plain text
    $username = $data['username'];
    $division = $data['division'];

    // Prepare SQL query to insert the new user
    $sql = "INSERT INTO users (email, password, username, division) 
            VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the SQL query
        $stmt->bind_param("ssss", $email, $password, $username, $division);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "User registered successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error inserting user into database"]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing SQL query"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input, missing required fields"]);
}

$conn->close();
?>
