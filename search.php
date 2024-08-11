<?php
include("./database/database.php");

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("
        SELECT * FROM students 
        WHERE firstname LIKE ? OR nic LIKE ?
    ");
    $searchTerm = "%" . $search . "%";
    
    // Bind parameters
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Escape HTML entities to prevent XSS attacks
            $id = htmlspecialchars($row['id']);
            $title = htmlspecialchars($row['title']);
            $name = htmlspecialchars($row['firstname']);
            $email = htmlspecialchars($row['personal_email']);
            $phone = htmlspecialchars($row['telephone']);
            $code = htmlspecialchars($row['student_code']);
            $lastName = htmlspecialchars($row['lastname']);
            $nameForCertificate = htmlspecialchars($row['name_for_certificate']);
            $preferredName = htmlspecialchars($row['preferred_name']);
            $dob = htmlspecialchars($row['date_of_birth']);
            $nationality = htmlspecialchars($row['nationality']);
            $permanentAddress = htmlspecialchars($row['permanent_address']);
            $currentAddress = htmlspecialchars($row['current_address']);
            $mobile = htmlspecialchars($row['mobile']);
            $emergencyContactName = htmlspecialchars($row['emergency_contact_name']);
            $photo = htmlspecialchars($row['photo']);
            $nic = htmlspecialchars($row['nic']);
            $passport = htmlspecialchars($row['passport']);
            $occupation = htmlspecialchars($row['occupation']);
            $organization = htmlspecialchars($row['organization']);
            $previousOrganization = htmlspecialchars($row['previous_organization']);
            $qualifications = htmlspecialchars($row['qualifications']); // Assuming qualifications are a simple string
            
            echo "<a href='#' class='dropdown-item' data-id='$id' data-title='$title' data-name='$name' data-email='$email' data-phone='$phone'
                data-code='$code' data-last-name='$lastName' data-name-cert='$nameForCertificate' data-pref-name='$preferredName'
                data-dob='$dob' data-nationality='$nationality' data-perm-address='$permanentAddress' data-curr-address='$currentAddress'
                data-mobile='$mobile' data-emergency-contact='$emergencyContactName' data-photo='$photo' data-nic='$nic'
                data-passport='$passport' data-occupation='$occupation' data-organization='$organization'
                data-prev-organization='$previousOrganization' data-qualifications='$qualifications'>
                $name ($email)
            </a>";
        }
    } else {
        echo "<a href='#' class='dropdown-item'>No results found</a>";
    }
    
    // Free the result set
    $result->free();
    
    // Close the statement
    $stmt->close();
}

$conn->close();
?>
