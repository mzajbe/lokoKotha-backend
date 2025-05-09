<!-- http://localhost/lokoKotha-backend/quiz/create.php -->

<?php
// Enable CORS and set JSON headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// database connection settings
include '../connections/Connection.php';

// Get raw JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (
    isset($data['category']) &&
    isset($data['question']) &&
    isset($data['option_a']) &&
    isset($data['option_b']) &&
    isset($data['option_c']) &&
    isset($data['option_d']) &&
    isset($data['correct_option'])
) {
    // Sanitize inputs
    $category = mysqli_real_escape_string($conn, $data['category']);
    $question = mysqli_real_escape_string($conn, $data['question']);
    $option_a = mysqli_real_escape_string($conn, $data['option_a']);
    $option_b = mysqli_real_escape_string($conn, $data['option_b']);
    $option_c = mysqli_real_escape_string($conn, $data['option_c']);
    $option_d = mysqli_real_escape_string($conn, $data['option_d']);
    $correct_option = mysqli_real_escape_string($conn, $data['correct_option']);
    $image_url = isset($data['image_url']) ? mysqli_real_escape_string($conn, $data['image_url']) : null;
    $audio_url = isset($data['audio_url']) ? mysqli_real_escape_string($conn, $data['audio_url']) : null;

    $created_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO quizzes (category, question, option_a, option_b, option_c, option_d, correct_option, image_url, audio_url, created_at)
            VALUES ('$category', '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option', '$image_url', '$audio_url', '$created_at')";

    if (mysqli_query($conn, $sql)) {
        $inserted_id = mysqli_insert_id($conn);

        $response = [
            "success" => true,
            "message" => "Quiz question created successfully",
            "data" => [
                "id" => $inserted_id,
                "category" => $category,
                "question" => $question,
                "option_a" => $option_a,
                "option_b" => $option_b,
                "option_c" => $option_c,
                "option_d" => $option_d,
                "correct_option" => $correct_option,
                "image_url" => $image_url,
                "audio_url" => $audio_url
            ]
        ];
    } else {
        $response = [
            "success" => false,
            "message" => "Database insert error: " . mysqli_error($conn)
        ];
    }
} else {
    $response = [
        "success" => false,
        "message" => "Missing required fields"
    ];
}

echo json_encode($response);
mysqli_close($conn);
?>
