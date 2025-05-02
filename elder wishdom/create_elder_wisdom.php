<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Get the raw POST data from the body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required data is present in the request
if (isset($data['user_id']) && isset($data['category']) && isset($data['title']) && isset($data['content_type']) && isset($data['content'])) {
    // Get the data from the request body
    $user_id = $data['user_id'];
    $category = $data['category'];  // Add category field
    $title = $data['title'];
    $content_type = $data['content_type'];
    $content = $data['content'];
    
    // Initialize video_url and photo_url (for video and photo content)
    $video_url = isset($data['video_url']) ? $data['video_url'] : NULL;
    $photo_url = isset($data['photo_url']) ? $data['photo_url'] : NULL;

    // Validate content_type and content
    if ($content_type == 'video' && !$video_url) {
        echo json_encode(["status" => "error", "message" => "Video URL is required for video content type"]);
        exit;
    }

    if ($content_type == 'text' && !$content) {
        echo json_encode(["status" => "error", "message" => "Content is required for text content type"]);
        exit;
    }

    // Prepare the SQL query to insert the elder wisdom
    if ($content_type == 'video') {
        // SQL query for video content
        $sql = "INSERT INTO elder_wisdom (user_id, category, title, wisdom_text, video_url, likes, comments) 
                VALUES (?, ?, ?, ?, ?, 0, 0)";
    } else {
        // SQL query for text content
        $sql = "INSERT INTO elder_wisdom (user_id, category, title, wisdom_text, video_url, likes, comments) 
                VALUES (?, ?, ?, ?, NULL, 0, 0)";
    }

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the query
        if ($content_type == 'video') {
            // Insert video wisdom with the video URL
            $stmt->bind_param("issss", $user_id, $category, $title, $content, $video_url);
        } else {
            // Insert text wisdom with the text content
            $stmt->bind_param("ssss", $user_id, $category, $title, $content);
        }

        // Execute the statement
        if ($stmt->execute()) {
            // If the wisdom is successfully inserted, return a success message
            echo json_encode(["status" => "success", "message" => "Elder wisdom created successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error executing query: " . $stmt->error]);
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
