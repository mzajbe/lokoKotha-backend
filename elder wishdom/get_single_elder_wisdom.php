<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Get the elder wisdom ID from the URL parameter
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    echo json_encode(["success" => false, "message" => "Missing elder wisdom ID"]);
    exit;
}

// Prepare SQL query to fetch the elder wisdom record by ID
$sql = "SELECT ew.id, ew.user_id, ew.category, ew.title, ew.content_type, ew.wisdom_text, 
               ew.video_url, ew.region, ew.elder_name, ew.elder_age, ew.photo_url, ew.status, ew.created_at, 
               u.username, u.division 
        FROM elder_wisdom AS ew
        JOIN users AS u ON ew.user_id = u.user_id
        WHERE ew.id = ?"; // Fetch wisdom record by ID

// Execute the query
if ($stmt = $conn->prepare($sql)) {
    // Bind the ID parameter to the query
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the wisdom entry exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Prepare the content based on content_type
        $content = ($row['video_url']) ? $row['video_url'] : $row['wisdom_text'];

        // Return the data as a JSON response
        echo json_encode([
            "success" => true,
            "data" => [
                "id" => $row['id'],
                "user_id" => $row['user_id'],
                "category" => $row['category'],
                "title" => $row['title'],
                "content_type" => $row['video_url'] ? 'video' : 'text', // Check if video_url exists for content_type
                "content" => $content,
                "region" => $row['region'],
                "elder_name" => $row['elder_name'],
                "elder_age" => $row['elder_age'],
                "photo_url" => $row['photo_url'],
                "author" => [
                    "id" => $row['user_id'],
                    "name" => $row['username'],
                    "division" => $row['division']
                ],
                "status" => $row['status'],
                "created_at" => $row['created_at']
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Elder wisdom not found"]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Error preparing SQL query"]);
}

$conn->close();
?>
