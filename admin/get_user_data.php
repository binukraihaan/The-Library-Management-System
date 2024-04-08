<?php
include('./includes/conn.php');

if(isset($_POST['user_id'])) {
    // Sanitize the user ID input
    $user_id = $_POST['user_id'];

    // $sql = "SELECT *, users.id AS studid FROM users LEFT JOIN course ON course.id=users.course_id WHERE users.user_id = '$id'";
    $sql = "SELECT u.*, c.code
    FROM users u
    INNER JOIN course c ON u.course_id = c.id
    WHERE u.user_id = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    
    // Bind the parameter
    $stmt->bind_param("s", $user_id);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Fetch user data
    $user_data = $result->fetch_assoc();
    
    // Check if user data was found
    if ($user_data) {
        // Return user data as JSON
        echo json_encode($user_data);
    } else {
        // No user found with the provided ID
        echo json_encode(array('error' => 'User not found'));
    }
} else {
    // No user ID provided
    echo json_encode(array('error' => 'No user ID provided'));
}

// Close the database connection
$stmt->close();
$conn->close();
?>
