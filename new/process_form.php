<?php
// process_form.php
include '../database/database.php';

$id = $_POST['studentID'];
$name = $_POST['name'];
$email = $_POST['email'];

if (empty($id)) {
    // Add new student
    $sql = "INSERT INTO stu (name, email) VALUES ('$name', '$email')";
} else {
    // Update existing student
    $sql = "UPDATE stu SET name='$name', email='$email' WHERE id='$id'";
}

if (mysqli_query($conn, $sql)) {
    echo "Record saved successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
