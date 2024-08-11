<?php
include("./database/database.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and validate form data
    $id = isset($_POST['student-id']) ? intval($_POST['student-id']) : null;
    $student_code = trim($_POST['student_code']);
    $title = trim($_POST['title']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $name_for_certificate = trim($_POST['name_for_certificate']);
    $preferred_name = trim($_POST['preferred_name']);

    $date_of_birth = trim($_POST['date_of_birth']);
    $nationality = trim($_POST['nationality']);
    $permanent_address = trim($_POST['permanent_address']);
    $current_address = trim($_POST['current_address']);
    $mobile = trim($_POST['mobile']);



    $telephone = trim($_POST['telephone']);
    $emergency_contact_name = trim($_POST['emergency_contact_name']);
    $photo = trim($_POST['photo']);
    $nic = trim($_POST['nic']);
    $passport = trim($_POST['passport']);
    $personal_email = trim($_POST['personal_email']);
    $bms_email = trim($_POST['bms_email']);
    $occupation = trim($_POST['occupation']);
    $organization = trim($_POST['organization']);
    $previous_organization = trim($_POST['previous_organization']);


    // Handle qualifications
    $qualifications = isset($_POST['qualifications']) ? implode(',', $_POST['qualifications']) : '';

    // Handle active checkbox
    $active = isset($_POST['active']) ? 1 : 0;




    if (empty($student_code) || empty($title) || empty($first_name)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if ($id) {
            // Update existing student
            $stmt = $conn->prepare("UPDATE students SET student_code =?, title=?, firstname=?, lastname=?,name_for_certificate,preferred_name, date_of_birth, nationality, permanent_address, current_address, mobile,
            telephone, emergency_contact_name, photo, nic, passport, personal_email, bms_email, occupation, organization, previous_organization,qualifications, active WHERE id=?");
            $stmt->bind_param(
                "sssssssssssssssssssssssi",
                $student_code,
                $title,
                $first_name,
                $last_name,
                $name_for_certificate,
                $preferred_name,
                $date_of_birth,
                $nationality,
                $permanent_address,
                $current_address,
                $mobile,
                $telephone,
                $emergency_contact_name,
                $photo,
                $nic,
                $passport,
                $personal_email,
                $bms_email,
                $occupation,
                $organization,
                $previous_organization,
                $qualifications,
                $active,
                $id
            );
        } else {
            // Insert new student
            $stmt = $conn->prepare("INSERT INTO students (student_code, title, firstname, lastname,name_for_certificate,preferred_name, date_of_birth, nationality, permanent_address, current_address, mobile, telephone, emergency_contact_name, photo, nic, passport, personal_email, bms_email, occupation, organization, previous_organization,qualifications, active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param(
                "sssssssssssssssssssssss",
                $student_code,
                $title,
                $first_name,
                $last_name,
                $name_for_certificate,
                $preferred_name,
                $date_of_birth,
                $nationality,
                $permanent_address,
                $current_address,
                $mobile,
                $telephone,
                $emergency_contact_name,
                $photo,
                $nic,
                $passport,
                $personal_email,
                $bms_email,
                $occupation,
                $organization,
                $previous_organization,
                $qualifications,
                $active
            );
        }

        // Execute and check statement
        if ($stmt->execute()) {
            if ($id) {
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
                // echo "<div class='alert alert-success'>Student updated successfully.</div>";
            } else {
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
                // echo "<div class='alert alert-success'>New student registered successfully.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        // Close statement
        $stmt->close();
    }
}

// Fetch and display registered students
$result = $conn->query("SELECT * FROM reg");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
            display: none;
            /* Hide by default */
            position: absolute;
            /* Position relative to the input */
            width: 100%;
            z-index: 1000;
        }

        .dropdown-item {
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Student Registration Form</h2>

        <!-- Search Form -->
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="form-group position-relative">
                    <label style="color: red;" for="search">Search Students for edit:</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Type to search..." autocomplete="off">
                    <div id="search-results" class="dropdown-menu"></div>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <form action="" method="POST">
            <input type="hidden" id="student-id" name="student-id">


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="student_code">Student Code:</label>
                        <input type="text" class="form-control" id="student_code" name="student_code" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <select class="form-control" id="title" name="title" required>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Miss">Miss</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name_for_certificate">Name for Certificate:</label>
                        <input type="text" class="form-control" id="name_for_certificate" name="name_for_certificate">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="preferred_name">Preferred Name:</label>
                        <input type="text" class="form-control" id="preferred_name" name="preferred_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date_of_birth">Date Of Birth:</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nationality">Nationality:</label>
                        <input type="text" class="form-control" id="nationality" name="nationality">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="permanent_address">Permanent Address:</label>
                        <textarea class="form-control" id="permanent_address" name="permanent_address"></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="current_address">Current Address:</label>
                        <textarea class="form-control" id="current_address" name="current_address"></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mobile">Mobile:</label>
                        <input type="text" class="form-control" id="mobile" name="mobile">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telephone">Telephone:</label>
                        <input type="text" class="form-control" id="telephone" name="telephone">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="emergency_contact_name">Emergency Contact Name:</label>
                        <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="photo">Photo:</label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nic">NIC:</label>
                        <input type="text" class="form-control" id="nic" name="nic">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="passport">Passport:</label>
                        <input type="text" class="form-control" id="passport" name="passport">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="personal_email">Personal Email:</label>
                        <input type="email" class="form-control" id="personal_email" name="personal_email">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bms_email">BMS Email:</label>
                        <input type="email" class="form-control" id="bms_email" name="bms_email">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="occupation">Occupation:</label>
                        <input type="text" class="form-control" id="occupation" name="occupation">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="organization">Organization:</label>
                        <input type="text" class="form-control" id="organization" name="organization">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="previous_organization">Previous Organization:</label>
                        <input type="text" class="form-control" id="previous_organization" name="previous_organization">
                    </div>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group">
                        <legend>Qualifications:</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bachelors" name="qualifications[]" value="Bachelors">
                            <label class="form-check-label" for="bachelors">Bachelors</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="masters" name="qualifications[]" value="Masters">
                            <label class="form-check-label" for="masters">Masters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="diploma" name="qualifications[]" value="Diploma">
                            <label class="form-check-label" for="diploma">Diploma</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cbm" name="qualifications[]" value="CBM">
                            <label class="form-check-label" for="cbm">CBM</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="al" name="qualifications[]" value="A/L">
                            <label class="form-check-label" for="al">A/L</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="work_experience" name="qualifications[]" value="Work Experience">
                            <label class="form-check-label" for="work_experience">Work Experience</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gdip" name="qualifications[]" value="GDip">
                            <label class="form-check-label" for="gdip">GDip</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ifd" name="qualifications[]" value="IFD">
                            <label class="form-check-label" for="ifd">IFD</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ol" name="qualifications[]" value="O/L">
                            <label class="form-check-label" for="ol">O/L</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="professional_qualification" name="qualifications[]" value="Professional Qualification">
                            <label class="form-check-label" for="professional_qualification">Professional Qualification</label>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="active" name="active">
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                </div>
                <div class="col-md-12"> <button type="submit" id="submit-button" class="btn btn-primary d-flex float-right">Register</button></div>

            </div>
        </form>


        <h2 class="mt-5 mb-4">Registered Students</h2>
        <table class="table table-striped border" style="font-size: 12px; width: 115%;">
            <thead>
                <tr class="text-muted">
                    <th>Student code</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Name to be appeared</th>
                    <th>DOB</th>
                    <th>Address</th>
                    <th>Telephone</th>
                    <th>Mobile</th>
                    <th>NIC</th>
                    <th>Passport</th>
                    <th>Email</th>
                    <th>Occupation</th>

                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php
                // Fetch and display registered students
                $result = $conn->query("SELECT * FROM students");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["student_code"] . "</td>";
                        echo "<td>" . $row["firstname"] . "</td>";
                        echo "<td>" . $row["lastname"] . "</td>";
                        echo "<td>" . $row["name_for_certificate"] . "</td>";
                        echo "<td>" . $row["date_of_birth"] . "</td>";
                        echo "<td>" . $row["permanent_address"] . "</td>";
                        echo "<td>" . $row["telephone"] . "</td>";
                        echo "<td>" . $row["mobile"] . "</td>";
                        echo "<td>" . $row["nic"] . "</td>";
                        echo "<td>" . $row["passport"] . "</td>";
                        echo "<td>" . $row["personal_email"] . "</td>";
                        echo "<td>" . $row["occupation"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No students registered</td></tr>";
                }
                $result->free();
                ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            let searchResults = $('#search-results');
            let studentIdInput = $('#student-id');
            let submitButton = $('#submit-button');
            let searchInput = $('#search');

            $('#search').on('input', function() {
                let query = $(this).val();
                if (query) {
                    fetchStudents(query);
                } else {
                    searchResults.hide();
                }
            });

            $('#search').on('focus', function() {
                let query = $(this).val();
                if (query) {
                    fetchStudents(query);
                }
            });

            function fetchStudents(query) {
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    data: {
                        search: query
                    },
                    success: function(response) {
                        searchResults.html(response).show();
                    }
                });
            }

            $(document).on('click', '.dropdown-item', function() {
                let selectedItemId = $(this).data('id');
                let selectedName = $(this).data('name');
                let selectedEmail = $(this).data('email');
                let selectedPhone = $(this).data('phone');

                studentIdInput.val(selectedItemId);
                $('#name').val(selectedName);
                $('#email').val(selectedEmail);
                $('#phone').val(selectedPhone);


                // Update the search input field with the selected student's name
                searchInput.val(selectedName);

                // Change button text to "Update" if editing an existing student
                submitButton.text('Update');

                searchResults.empty().hide();
            });

            $(document).click(function(event) {
                if (!$(event.target).closest('#search, #search-results').length) {
                    searchResults.empty().hide();
                }
            });
        });
    </script>

</body>

</html>


<style>
    .form-control {
        display: block;
        width: 100%;
        height: calc(1.5em + 0.5rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff7f7;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>