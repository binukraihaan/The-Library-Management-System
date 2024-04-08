<?php
// Include your database connection code
include './includes/conn.php';

// Get the year from the AJAX request
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Initialize arrays to store data
$months = array();
$return = array();
$borrow = array();

// Fetch data from the database
for ($m = 1; $m <= 12; $m++) {
    // Fetch return data for each month
    $sql = "SELECT COUNT(*) as return_count FROM returns WHERE MONTH(date_return) = '$m' AND YEAR(date_return) = '$year'";
    $rquery = $conn->query($sql);
    $return_count = $rquery->fetch_assoc()['return_count'];
    array_push($return, $return_count);

    // Fetch borrow data for each month
    $sql = "SELECT COUNT(*) as borrow_count FROM borrow WHERE MONTH(date_borrow) = '$m' AND YEAR(date_borrow) = '$year'";
    $bquery = $conn->query($sql);
    $borrow_count = $bquery->fetch_assoc()['borrow_count'];
    array_push($borrow, $borrow_count);

    // Get the month name
    $month_name = date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month_name);
}

// Prepare data to send back as JSON
$response = array(
    'months' => $months,
    'return' => $return,
    'borrow' => $borrow
);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close database connection
$conn->close();
?>
