<?php
// Start session
session_start();

// Include database connection
require_once '../includes/db_connect.php';

// Initialize response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate input
    if (empty($username) || empty($password)) {
        $response['success'] = false;
        $response['message'] = "All fields are required";
    } else {
        // Check if user exists
        $query = "SELECT id, username, password, points FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a new session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['points'] = $user['points'];
                $_SESSION['logged_in'] = true;
                
                $response['success'] = true;
                $response['message'] = "Login successful";
                $response['user'] = array(
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'points' => $user['points']
                );
            } else {
                $response['success'] = false;
                $response['message'] = "Invalid password";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "User not found";
        }
        
        $stmt->close();
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>