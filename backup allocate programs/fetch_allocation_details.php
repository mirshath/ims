<?php


include("./database/connection.php");

// Get the student code from the AJAX request
$student_code = $_POST['student_code'];

// Fetch student details from the `allocate_programme` table
$query = "
    SELECT
        s.first_name,
        s.last_name,
        u.university_name,
        p.program_name,
        b.batch_name,
        a.student_registration_id,
        a.elective_subs,
        a.compulsory_sub
    FROM allocate_programme a
    JOIN students s ON a.student_code = s.student_code
    JOIN universities u ON a.university_id = u.id
    JOIN program_table p ON a.programme_code = p.program_code
    JOIN batch_table b ON a.batch_id = b.id
    WHERE a.student_code = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $student_code);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Prepare the response as a JSON object
$response = [
    'student_name' => $data['first_name'] . ' ' . $data['last_name'],
    'university' => $data['university_name'],
    'programme' => $data['program_name'],
    'batch' => $data['batch_name'],
    'registration_code' => $data['student_registration_id'],
    'elective_subjects' => $data['elective_subs'], // Comma-separated elective subjects
    'compulsory_subjects' => $data['compulsory_sub']
];

echo json_encode($response);
