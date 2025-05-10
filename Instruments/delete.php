<!-- http://localhost/lokoKotha-backend/Instruments/delete.php?id=35 -->


<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../connections/Connection.php';

// Only allow DELETE method
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid instrument ID"
        ]);
        exit;
    }

    $sql = "DELETE FROM heritage_instruments WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Heritage instrument deleted successfully"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Delete failed: " . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method or missing ID"
    ]);
}

mysqli_close($conn);
