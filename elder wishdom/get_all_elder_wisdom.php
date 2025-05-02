<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Check if the user is logged in (session exists)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated"]);
    exit;
}

// Prepare SQL query to fetch all elder wisdom records with user details
$sql = "SELECT ew.id, ew.user_id, ew.category, ew.title, ew.content_type, ew.wisdom_text, 
               ew.video_url, ew.region, ew.elder_name, ew.elder_age, ew.photo_url, ew.status, ew.created_at, 
               u.username, u.division 
        FROM elder_wisdom AS ew
        JOIN users AS u ON ew.user_id = u.user_id
        ORDER BY ew.created_at DESC"; // Fetch wisdom entries ordered by creation date

// Execute the query
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any wisdom entries exist
    if ($result->num_rows > 0) {
        $wisdom_data = [];

        // Fetch each record and format the data
        while ($row = $result->fetch_assoc()) {
            // Handling missing or null values
            $content = ($row['video_url']) ? $row['video_url'] : $row['wisdom_text'];

            // Replace empty or null fields with default values
            $region = !empty($row['region']) ? $row['region'] : "Unknown Region";
            $elder_name = !empty($row['elder_name']) ? $row['elder_name'] : "Unknown Elder";
            $elder_age = !empty($row['elder_age']) ? $row['elder_age'] : "Unknown Age";
            $photo_url = !empty($row['photo_url']) ? $row['photo_url'] : "https://example.com/default.jpg"; // Default photo URL

            $wisdom_data[] = [
                "id" => $row['id'],
                "user_id" => $row['user_id'],
                "category" => $row['category'],
                "title" => $row['title'],
                "content_type" => $row['video_url'] ? 'video' : 'text', // Check if video_url exists for content_type
                "content" => $content,
                "region" => $region,
                "elder_name" => $elder_name,
                "elder_age" => $elder_age,
                "photo_url" => $photo_url,
                "author" => [
                    "id" => $row['user_id'],
                    "name" => $row['username'],
                    "division" => $row['division']
                ],
                "status" => $row['status'],
                "created_at" => $row['created_at']
            ];
        }

        // Return the data as a JSON response
        echo json_encode(["success" => true, "data" => $wisdom_data]);
    } else {
        echo json_encode(["success" => false, "message" => "No elder wisdom found"]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Error preparing SQL query: " . $conn->error]);
}

$conn->close();
?>
