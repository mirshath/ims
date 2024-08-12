<?php
include("../database/database.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group position-relative">
                    <label class="form-label text-danger" for="search">Search Students for Edit:</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Type to search..." autocomplete="off">
                    <div id="search-results" class="dropdown-menu w-100" style="display: none;">
                        <!-- Search results will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-4">Student Registration</h2>
        <!-- <form id="studentForm" action="process_form.php" method="post">
            <div class="mb-3">
            
                <input type="hidden" id="studentID" name="studentID" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form> -->

        <form id="studentForm" action="process_form.php" method="post">
            <div class="mb-3">
                <label for="student_code" class="form-label">Student Code:</label>
                <input type="hidden" id="student_code" name="student_code" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <select id="title" name="title" class="form-select" required>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                    <option value="Prof">Prof</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="certificate_name" class="form-label">Name for the Certificate:</label>
                <input type="text" id="certificate_name" name="certificate_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="preferred_name" class="form-label">Preferred Name:</label>
                <input type="text" id="preferred_name" name="preferred_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth:</label>
                <input type="date" id="dob" name="dob" class="form-control">
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nationality:</label>
                <input type="text" id="nationality" name="nationality" class="form-control">
            </div>
            <div class="mb-3">
                <label for="permanent_address" class="form-label">Permanent Address:</label>
                <textarea id="permanent_address" name="permanent_address" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="current_address" class="form-label">Current Address:</label>
                <textarea id="current_address" name="current_address" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile:</label>
                <input type="text" id="mobile" name="mobile" class="form-control">
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone:</label>
                <input type="text" id="telephone" name="telephone" class="form-control">
            </div>
            <div class="mb-3">
                <label for="emergency_contact_name" class="form-label">Emergency Contact Name:</label>
                <input type="text" id="emergency_contact_name" name="emergency_contact_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="emergency_contact_number" class="form-label">Emergency Contact Number:</label>
                <input type="text" id="emergency_contact_number" name="emergency_contact_number" class="form-control">
            </div>
            <div class="mb-3">
                <label for="english_ability" class="form-label">English Ability:</label>
                <input type="checkbox" id="english_ability" name="english_ability" value="1">
            </div>
            <div class="mb-3">
                <label for="minimum_entry_qualification" class="form-label">Minimum Entry Qualification:</label>
                <input type="checkbox" id="minimum_entry_qualification" name="minimum_entry_qualification" value="1">
            </div>
            <div class="mb-3">
                <label for="nic" class="form-label">NIC:</label>
                <input type="text" id="nic" name="nic" class="form-control">
            </div>
            <div class="mb-3">
                <label for="passport" class="form-label">Passport:</label>
                <input type="text" id="passport" name="passport" class="form-control">
            </div>
            <div class="mb-3">
                <label for="personal_email" class="form-label">Personal Email:</label>
                <input type="email" id="personal_email" name="personal_email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="bms_email" class="form-label">BMS Email:</label>
                <input type="email" id="bms_email" name="bms_email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="occupation" class="form-label">Occupation:</label>
                <input type="text" id="occupation" name="occupation" class="form-control">
            </div>
            <div class="mb-3">
                <label for="organization" class="form-label">Organization:</label>
                <input type="text" id="organization" name="organization" class="form-control">
            </div>
            <div class="mb-3">
                <label for="previous_organization" class="form-label">Previous Organization:</label>
                <input type="text" id="previous_organization" name="previous_organization" class="form-control">
            </div>
            <div class="mb-3">
                <label for="qualifications" class="form-label">Qualifications:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="Bachelors" id="bachelors">
                    <label class="form-check-label" for="bachelors">Bachelors</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="Masters" id="masters">
                    <label class="form-check-label" for="masters">Masters</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="Diploma" id="diploma">
                    <label class="form-check-label" for="diploma">Diploma</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="CBM" id="cbm">
                    <label class="form-check-label" for="cbm">CBM</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="AL" id="al">
                    <label class="form-check-label" for="al">A/L</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="PGDip" id="pgdip">
                    <label class="form-check-label" for="pgdip">PGDip</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="IFD" id="ifd">
                    <label class="form-check-label" for="ifd">IFD</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="qualifications[]" value="OL" id="ol">
                    <label class="form-check-label" for="ol">O/L</label>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1">
                <label class="form-check-label" for="active">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <h2 class="mt-5">Registered Students</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col">Student ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Cerificate Name</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch registered students from the database and display in the table


                $sql = "SELECT * FROM students";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['student_code']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['certificate_name']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No registered students found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Handle search input and display results
            $('#search').on('input', function() {
                let query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: 'search_students.php',
                        type: 'POST',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $('#search-results').html(response).show();
                        }
                    });
                } else {
                    $('#search-results').hide();
                }
            });

            // Handle selection of a search result
            $(document).on('click', '.dropdown-item', function() {
                let studentID = $(this).data('id');
                $('#search').val($(this).text());
                $('#search-results').hide();

                // Fetch and populate the student details
                $.ajax({
                    url: 'get_student.php',
                    type: 'POST',
                    data: {
                        id: studentID
                    },
                    success: function(data) {
                        let student = JSON.parse(data);
                        $('#studentID').val(student.id);
                        $('#name').val(student.name);
                        $('#email').val(student.email);
                    }
                });
            });

            // Hide the dropdown menu when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('#search, #search-results').length) {
                    $('#search-results').hide();
                }
            });
        });
    </script>
</body>

</html>