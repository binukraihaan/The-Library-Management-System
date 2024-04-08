<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$isbn = $_POST['isbn'];
		$title = $_POST['title'];
		$category = $_POST['category'];
		$author = $_POST['author'];
		$publisher = $_POST['publisher'];
		$pub_date = $_POST['pub_date'];
		$roomNo = $_POST['room'];
		$shelfNo = $_POST['shelf'];
		$rowNo = $_POST['row'];

		$sql = "INSERT INTO books (isbn, category_id, title, author, publisher, publish_date, room, shelf, row) VALUES ('$isbn', '$category', '$title', '$author', '$publisher', '$pub_date', '$roomNo', '$shelfNo', '$rowNo')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Book added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: book.php');

?>