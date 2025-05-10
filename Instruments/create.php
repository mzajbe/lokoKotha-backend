
<!-- {
  "user_id": 10,
  "instrument_name": "Ektara",
  "image_url": "https://example.com/images/ektara.jpg",
  "description": "A one-string folk instrument used in Baul songs.",
  "type": "Musical Instrument",
  "era": "18th Century",
  "region": "Kushtia"
} -->

<!-- http://localhost/lokoKotha-backend/Instruments/create.php -->



<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../connections/Connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $user_id = intval($data['user_id'] ?? 0);
    $instrument_name = mysqli_real_escape_string($conn, $data['instrument_name'] ?? '');
    $description = mysqli_real_escape_string($conn, $data['description'] ?? '');
    $image_url = mysqli_real_escape_string($conn, $data['image_url'] ?? '');
    $type = mysqli_real_escape_string($conn, $data['type'] ?? '');
    $era = mysqli_real_escape_string($conn, $data['era'] ?? '');
    $region = mysqli_real_escape_string($conn, $data['region'] ?? '');
    $status = 'pending'; // Default status
    $created_at = date('Y-m-d H:i:s');

    if ($user_id && $instrument_name && $description && $image_url && $type && $era && $region) {
        $sql = "INSERT INTO heritage_instruments 
            (user_id, instrument_name, description, image_url, type, era, region, status, created_at)
            VALUES 
            ($user_id, '$instrument_name', '$description', '$image_url', '$type', '$era', '$region', '$status', '$created_at')";

        if (mysqli_query($conn, $sql)) {
            $inserted_id = mysqli_insert_id($conn);

            echo json_encode([
                "success" => true,
                "message" => "Heritage instrument submitted successfully",
                "data" => [
                    "id" => $inserted_id,
                    "instrument_name" => $instrument_name,
                    "image_url" => $image_url,
                    "description" => $description,
                    "type" => $type,
                    "era" => $era,
                    "region" => $region,
                    "status" => $status,
                    "created_at" => $created_at
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Database error: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Missing or invalid input fields."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

mysqli_close($conn);
?>
