<?php
// Include the database connection file
include("../database/connection.php");

// Retrieve form data
$student_code = $_POST['student_code'];
$title = $_POST['title'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$certificate_name = $_POST['certificate_name'];
$preferred_name = $_POST['preferred_name'];
$date_of_birth = $_POST['dob'];
$nationality = $_POST['nationality'];
$permanent_address = $_POST['permanent_address'];
$current_address = $_POST['current_address'];
$mobile = $_POST['mobile'];
$telephone = $_POST['telephone'];
$emergency_contact_name = $_POST['emergency_contact_name'];
$emergency_contact_number = $_POST['emergency_contact_number'];
$english_ability = isset($_POST['english_ability']) ? 1 : 0;
$minimum_entry_qualification = isset($_POST['minimum_entry_qualification']) ? 1 : 0;
$nic = $_POST['nic'];
$passport = $_POST['passport'];
$personal_email = $_POST['personal_email'];
$bms_email = $_POST['bms_email'];
$occupation = $_POST['occupation'];
$organization = $_POST['organization'];
$previous_organization = $_POST['previous_organization'];
$qualifications = isset($_POST['qualifications']) ? implode(',', $_POST['qualifications']) : '';
$active = isset($_POST['active']) ? 1 : 0;

// Check if the student code already exists (update) or if it's a new student (insert)
$sql = "SELECT student_code FROM students WHERE student_code='$student_code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Update existing student record
    $sql = "UPDATE students SET 
                title='$title',
                first_name='$first_name',
                last_name='$last_name',
                certificate_name='$certificate_name',
                preferred_name='$preferred_name',
                date_of_birth='$date_of_birth',
                nationality='$nationality',
                permanent_address='$permanent_address',
                current_address='$current_address',
                mobile='$mobile',
                telephone='$telephone',
                emergency_contact_name='$emergency_contact_name',
                emergency_contact_number='$emergency_contact_number',
                english_ability='$english_ability',
                minimum_entry_qualification='$minimum_entry_qualification',
                nic='$nic',
                passport='$passport',
                personal_email='$personal_email',
                bms_email='$bms_email',
                occupation='$occupation',
                organization='$organization',
                previous_organization='$previous_organization',
                qualifications='$qualifications',
                active='$active'
            WHERE student_code='$student_code'";
} else {
    // Insert new student record
    $sql = "INSERT INTO students (
                student_code, 
                title, 
                first_name, 
                last_name, 
                certificate_name, 
                preferred_name, 
                date_of_birth, 
                nationality, 
                permanent_address, 
                current_address, 
                mobile, 
                telephone, 
                emergency_contact_name, 
                emergency_contact_number, 
                english_ability, 
                minimum_entry_qualification, 
                nic, 
                passport, 
                personal_email, 
                bms_email, 
                occupation, 
                organization, 
                previous_organization, 
                qualifications, 
                active
            ) VALUES (
                '$student_code', 
                '$title', 
                '$first_name', 
                '$last_name', 
                '$certificate_name', 
                '$preferred_name', 
                '$date_of_birth', 
                '$nationality', 
                '$permanent_address', 
                '$current_address', 
                '$mobile', 
                '$telephone', 
                '$emergency_contact_name', 
                '$emergency_contact_number', 
                '$english_ability', 
                '$minimum_entry_qualification', 
                '$nic', 
                '$passport', 
                '$personal_email', 
                '$bms_email', 
                '$occupation', 
                '$organization', 
                '$previous_organization', 
                '$qualifications', 
                '$active'
            )";
}

// Execute the query
if (mysqli_query($conn, $sql)) {
    // Redirect to the index page or another success page
    header("Location: index.php");
    exit();
} else {
    // Display an error message
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
