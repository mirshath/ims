<?php
// search_students.php
include '../database/database.php';

$query = $_POST['query'];
$sql = "SELECT id, name FROM stu WHERE name LIKE '%$query%'";
$result = mysqli_query($conn, $sql);

$results = '';
while ($row = mysqli_fetch_assoc($result)) {
    $results .= "<a href='#' class='dropdown-item' data-id='{$row['id']}'>{$row['name']}</a>";
}

echo $results;
?>
