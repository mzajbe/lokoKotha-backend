<!-- {
  "instrument_name": "Updated Ektara",
  "description": "Updated description",
  "status": "approved"
} -->


<!-- http://localhost/lokoKotha-backend/Instruments/update.php?id=35 -->




<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../connections/Connection.php';

// Check if method is POST and ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $data = json_decode(file_get_contents("php://input"), true);

    if ($id <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid ID"
        ]);
        exit;
    }

    // Build update fields
    $fields = [];
    if (isset($data['instrument_name'])) $fields[] = "instrument_name = '" . mysqli_real_escape_string($conn, $data['instrument_name']) . "'";
    if (isset($data['description']))     $fields[] = "description = '" . mysqli_real_escape_string($conn, $data['description']) . "'";
    if (isset($data['image_url']))       $fields[] = "image_url = '" . mysqli_real_escape_string($conn, $data['image_url']) . "'";
    if (isset($data['type']))            $fields[] = "type = '" . mysqli_real_escape_string($conn, $data['type']) . "'";
    if (isset($data['era']))             $fields[] = "era = '" . mysqli_real_escape_string($conn, $data['era']) . "'";
    if (isset($data['region']))          $fields[] = "region = '" . mysqli_real_escape_string($conn, $data['region']) . "'";
    if (isset($data['status']))          $fields[] = "status = '" . mysqli_real_escape_string($conn, $data['status']) . "'";

    if (empty($fields)) {
        echo json_encode([
            "success" => false,
            "message" => "No fields to update"
        ]);
        exit;
    }

    $sql = "UPDATE heritage_instruments SET " . implode(", ", $fields) . " WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Instrument updated successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Update failed: " . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method or missing ID"
    ]);
}

mysqli_close($conn);
