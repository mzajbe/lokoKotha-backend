
<!-- http://localhost/lokoKotha-backend/quiz attempt/get_quiz_history.php?user_id=10 -->

<!-- response:
{
    "success": true,
    "data": [
        {
            "quiz_id": 1,
            "question": "What is the dialect word for 'rice' in the Sylhet region?",
            "selected_option": "B",
            "correct_option": "B",
            "is_correct": true,
            "attempted_at": "2025-05-09 12:43:39"
        }
    ]
} -->




<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Include DB connection
include '../connections/Connection.php';

// Check for GET method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($user_id > 0) {
        $sql = "
            SELECT 
                s.quiz_id,
                q.question,
                s.selected_option,
                q.correct_option,
                s.is_correct,
                s.completed_at AS attempted_at
            FROM user_quiz_scores s
            JOIN quizzes q ON q.id = s.quiz_id
            WHERE s.user_id = $user_id
            ORDER BY s.completed_at DESC
        ";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $history = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $history[] = [
                    "quiz_id" => (int) $row['quiz_id'],
                    "question" => $row['question'],
                    "selected_option" => $row['selected_option'],
                    "correct_option" => $row['correct_option'],
                    "is_correct" => (bool) $row['is_correct'],
                    "attempted_at" => $row['attempted_at']
                ];
            }

            echo json_encode([
                "success" => true,
                "data" => $history
            ]);
        } else {
            echo json_encode([
                "success" => true,
                "data" => []
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid or missing user_id"
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
