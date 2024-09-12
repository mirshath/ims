<?php
include("../database/connection.php");

$programme_code = $_GET['programme_code'];

// Prepare the SQL query to fetch modules based on the selected programme
$sql = "SELECT * FROM modules WHERE programme_id  = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $programme_code);  // Assuming the program_code is a string
$stmt->execute();
$result = $stmt->get_result();

$modules = [];
while ($row = $result->fetch_assoc()) {
    $modules[] = $row;
}

echo json_encode($modules);

$stmt->close();
$conn->close();
?>
