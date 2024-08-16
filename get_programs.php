<?php
include './database/connection.php';

if (isset($_POST['university_id'])) {
    $university_id = $_POST['university_id'];
    
    $query = "SELECT * FROM program_table WHERE university_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $university_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $programs = array();
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
    
    echo json_encode($programs);
}
?>
