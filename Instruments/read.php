<!-- http://localhost/lokoKotha-backend/Instruments/read.php -->

<!-- 
{
    "success": true,
    "data": [
        {
            "id": 34,
            "user_id": 10,
            "instrument_name": "Ektara",
            "description": "A one-string folk instrument used in Baul songs.",
            "image_url": "https://example.com/images/ektara.jpg",
            "type": "Musical Instrument",
            "era": "18th Century",
            "region": "Kushtia",
            "status": "pending",
            "created_at": "2025-05-10 05:32:04"
        }
    ]
} -->



<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// DB connection
include '../connections/Connection.php';

// Only allow GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM heritage_instruments ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $instruments = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $instruments[] = [
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
        }

        echo json_encode([
            "success" => true,
            "data" => $instruments
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
        "message" => "Invalid request method"
    ]);
}

mysqli_close($conn);
?>
