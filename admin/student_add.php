<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$course = $_POST['course'];
	//creating studentid
	$letters = 'ST'; // Only 'T' and 'R' letters
	$numbers = '';
	for ($i = 0; $i < 10; $i++) {
		$numbers .= $i;
	}
	$student_id = $letters . substr(str_shuffle($numbers), 0, 9);
	//
	$sql = "INSERT INTO students (student_id, firstname, lastname, course_id, photo, created_on) VALUES ('$student_id', '$firstname', '$lastname', '$course', '$filename', NOW())";
	$role = "student";
	if ($conn->query($sql)) {

		$sql_user = "INSERT INTO users (user_id, firstname, lastname, course_id, role, created_on) VALUES ('$student_id', '$firstname', '$lastname', '$course', '$role', NOW())";
		$conn->query($sql_user);
		$_SESSION['success'] = 'Student added successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Fill up add form first';
}

header('location: student.php');
