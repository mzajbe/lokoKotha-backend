
<!-- http://localhost/lokoKotha-backend/Instruments/readSingle.php?id=35 -->

<!-- {
    "success": true,
    "data": {
        "id": 35,
        "user_id": 20,
        "instrument_name": "Dhutora",
        "description": "bla bla bla ",
        "image_url": "imagehub.com",
        "type": "oldage",
        "era": "18's",
        "region": "asia",
        "status": "pending",
        "created_at": "2025-05-10 09:40:13"
    }
} -->




<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// DB connection
include '../connections/Connection.php';

// Only allow GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the ID from query parameter
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id > 0) {
        $sql = "SELECT * FROM heritage_instruments WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $data = [
                "id" => (int) $row['id'],
                "user_id" => (int) $row['user_id'],
                "instrument_name" => $row['instrument_name'],
                "description" => $row['description'],
                "image_url" => $row['image_url'],
                "type" => $row['type'],
                "era" => $row['era'],
                "region" => $row['region'],
                "status" => $row['status'],
                "created_at" => $row['created_at']
            ];

            echo json_encode([
                "success" => true,
                "data" => $data
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Instrument not found"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid ID"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
}

mysqli_close($conn);
?>
