<!-- http://localhost/lokoKotha-backend/quiz/getSingleQuizQuestion.php?id=2 -->




<?php
// Enable CORS and JSON response
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// database connection settings
include '../connections/Connection.php';

// Validate ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT id, category, question, option_a, option_b, option_c, option_d, correct_option, image_url, audio_url 
            FROM quizzes WHERE id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $quiz = mysqli_fetch_assoc($result);

        echo json_encode([
            "success" => true,
            "data" => $quiz
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Quiz question not found"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid or missing quiz ID"
    ]);
}

mysqli_close($conn);
?>
