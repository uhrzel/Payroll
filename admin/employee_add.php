<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
	$username = $_POST['username'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$birthdate = $_POST['birthdate'];
	$contact = $_POST['contact'];
	$gender = $_POST['gender'];
	$position = $_POST['position'];
	$schedule = $_POST['schedule'];
	$filename = $_FILES['photo']['name'];
	$password = $_POST['password'];
	if (!empty($filename)) {
		move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $filename);
	}
	//creating employeeid
	$letters = '';
	$numbers = '';
	foreach (range('A', 'Z') as $char) {
		$letters .= $char;
	}
	for ($i = 0; $i < 10; $i++) {
		$numbers .= $i;
	}
	$employee_id = substr(str_shuffle($letters), 0, 3) . substr(str_shuffle($numbers), 0, 9);
	//
	$sql = "INSERT INTO employees (employee_id, username, firstname, lastname, email, address, birthdate, contact_info, gender, position_id, schedule_id, photo,password,  created_on) VALUES ('$employee_id', '$username', '$firstname', '$lastname','$email', '$address', '$birthdate', '$contact', '$gender', '$position', '$schedule', '$filename','$password',  NOW())";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Employee added successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Fill up add form first';
}

header('location: employee.php');
