<?php
include './database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['program_code'])) {
    $program_code = mysqli_real_escape_string($conn, $_POST['program_code']);
    $sql = "SELECT * FROM program_table WHERE prog_code = '$program_code'";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Return the result as JSON
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
