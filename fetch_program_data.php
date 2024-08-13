<?php
include("database/connection.php");

if (isset($_POST['prog_code'])) {
    $prog_code = $_POST['prog_code'];

    $stmt = $conn->prepare("SELECT * FROM program_table WHERE prog_code = ?");
    $stmt->bind_param("s", $prog_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $program = $result->fetch_assoc();

    if ($program) {
        // Convert entry requirements to an array
        $entry_requirements = explode(',', $program['entry_requirement']);

        echo json_encode([
            'program_name' => $program['program_name'],
            'prog_code' => $program['prog_code'],
            'medium' => $program['medium'],
            'duration' => $program['duration'],
            'course_fee_lkr' => $program['course_fee_lkr'],
            'course_fee_gbp' => $program['course_fee_gbp'],
            'course_fee_usd' => $program['course_fee_usd'],
            'course_fee_euro' => $program['course_fee_euro'],
            'entry_requirements' => $entry_requirements
        ]);
    } else {
        echo json_encode(['error' => 'Program not found']);
    }

    $stmt->close();
    $conn->close();
}
?>
