<?php
// search_students.php
include("database/connection.php");

// Retrieve the search query from the AJAX request and sanitize it
$query = mysqli_real_escape_string($conn, $_POST['query']);

$sql = "SELECT * FROM students WHERE first_name LIKE '%$query%' OR last_name LIKE '%$query%' OR student_code LIKE '%$query%'";
$result = mysqli_query($conn, $sql);

$results = '';

// Check if any results were returned
if (mysqli_num_rows($result) > 0) {
    // Loop through the query results and create a dropdown item for each student
    while ($row = mysqli_fetch_assoc($result)) {
        // Concatenate the first and last names for display
        $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
        
        // Create a dropdown item with the student code as a data attribute
        $results .= "<a href='#' class='dropdown-item' data-id='{$row['student_code']}'>{$full_name} ({$row['nic']})</a>";
    }
} else {
    $results = "<a href='#' class='dropdown-item'>No results found</a>";
}

echo $results;

mysqli_close($conn);
?>
