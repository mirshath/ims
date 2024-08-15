<?php
include './database/connection.php';

if (isset($_POST['program_code'])) {
    $program_code = $_POST['program_code'];
    $result = mysqli_query($conn, "SELECT * FROM program_table WHERE program_code = '$program_code'");
    $data = mysqli_fetch_assoc($result);

    // Convert entry requirements to an array
    $entry_requirements = explode(',', $data['entry_requirement']);

    // Add entry requirements to the response
    $response = array(
        'program_code' => $data['program_code'],
        'university_id' => $data['university_id'],
        'program_name' => $data['program_name'],
        'prog_code' => $data['prog_code'],
        'coordinator_name' => $data['coordinator_name'],
        'medium' => $data['medium'],
        'duration' => $data['duration'],
        'course_fee_lkr' => $data['course_fee_lkr'],
        'course_fee_gbp' => $data['course_fee_gbp'],
        'course_fee_usd' => $data['course_fee_usd'],
        'course_fee_euro' => $data['course_fee_euro'],
        'entry_requirements' => $entry_requirements
    );

    echo json_encode($response);
}
?>
