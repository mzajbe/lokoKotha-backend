<!-- http://localhost/lokoKotha-backend/quiz/getQuizesAllQuestion.php -->

<?php
// Enable CORS and set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// database connection settings
include '../connections/Connection.php';


// Check if a category filter is present
$categoryFilter = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : null;

$sql = "SELECT id, category, question, option_a, option_b, option_c, option_d, image_url, audio_url FROM quizzes";

if ($categoryFilter) {
    $sql .= " WHERE category = '$categoryFilter'";
}

$result = mysqli_query($conn, $sql);

if ($result) {
    $quizzes = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $quizzes[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $quizzes
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to retrieve quizzes: " . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>
