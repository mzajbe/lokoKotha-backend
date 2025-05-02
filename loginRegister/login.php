<?php
session_start();
require_once '../connections/config.php'; // Include the database connection file

header('Content-Type: application/json');

// Get the raw POST data from the body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required data is present in the request
if (isset($data['email']) && isset($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    // Prepare SQL query to fetch user by email
    $sql = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);  // Bind the email parameter to the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();  // Fetch the user data

            // Verify the password
            if ($password === $user['password']) {  // Checking plain text password (not recommended for production)
                // Set session variables to store user details
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Return redirect URL based on role (admin or user)
                if ($user['role'] == 'admin') {
                    echo json_encode(["status" => "success", "redirect" => "admin_dashboard.php"]);
                } else {
                    echo json_encode(["status" => "success", "redirect" => "user_dashboard.php"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User not found"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing query"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input, missing email or password"]);
}

$conn->close();
?>
