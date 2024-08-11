<?php
// get_student.php
include '../database/database.php';

$id = $_POST['id'];
$sql = "SELECT * FROM stu WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$student = mysqli_fetch_assoc($result);
echo json_encode($student);
?>
