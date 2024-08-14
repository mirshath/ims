<?php
include './database/connection.php';

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = "SELECT * FROM program_table WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $response = [
            'id' => $row['id'],
            'university' => $row['university'],
            'program_name' => $row['program_name'],
            'prog_code' => $row['prog_code'],
            'coordinator_name' => $row['coordinator_name'],
            'medium' => $row['medium'],
            'duration' => $row['duration'],
            'course_fee_lkr' => $row['course_fee_lkr'],
            'course_fee_gbp' => $row['course_fee_gbp'],
            'course_fee_usd' => $row['course_fee_usd'],
            'course_fee_euro' => $row['course_fee_euro'],
            'entry_requirements' => explode(',', $row['entry_requirement'])
        ];
        echo json_encode($response);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
