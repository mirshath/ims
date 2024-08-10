<?php
include("./database/database.php");

if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query = "SELECT * FROM reg WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<a href='#' class='dropdown-item' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-email='" . $row['email'] . "' data-phone='" . $row['phone'] . "'>" . $row['name'] . " (" . $row['email'] . ")</a>";
        }
    } else {
        echo "<a href='#' class='dropdown-item'>No results found</a>";
    }
    $result->free();
}

$conn->close();
?>
