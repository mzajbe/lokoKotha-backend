
<!-- 
{
  "user_id": 10,
  "quiz_id": 1,
  "selected_option": "B"
}

http://localhost/lokoKotha-backend/quiz attempt/submit_quiz_attempt.php -->




 <?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Database connection
include '../connections/Connection.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $data = json_decode(file_get_contents("php://input"), true);

    $user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
    $quiz_id = isset($data['quiz_id']) ? intval($data['quiz_id']) : 0;
    $selected_option = isset($data['selected_option']) ? strtoupper(trim($data['selected_option'])) : '';

    // Validate input
    if ($user_id && $quiz_id && in_array($selected_option, ['A', 'B', 'C', 'D'])) {
        // Get correct answer
        $query = "SELECT correct_option FROM quizzes WHERE id = $quiz_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $is_correct = ($row['correct_option'] === $selected_option) ? 1 : 0;
            $created_at = date('Y-m-d H:i:s');

            // Insert into user_quiz_scores
            $insert = "INSERT INTO user_quiz_scores (user_id, quiz_id, selected_option, is_correct, completed_at)
                       VALUES ($user_id, $quiz_id, '$selected_option', $is_correct, '$created_at')";

            if (mysqli_query($conn, $insert)) {
                echo json_encode([
                    "success" => true,
                    "message" => "Answer submitted",
                    "data" => [
                        "quiz_id" => $quiz_id,
                        "selected_option" => $selected_option,
                        "is_correct" => boolval($is_correct),
                        "created_at" => $created_at
                    ]
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Database error: " . mysqli_error($conn)
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Quiz not found."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Missing or invalid data."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}

mysqli_close($conn);
?>
