<?php
include("../../database/database.php");

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

        <hr>
        <h2 class="mt-4">Student Registration</h2>
        <hr>

        <form id="studentForm" action="process_form.php" method="post">
            <div class="mb-3">
                <!-- <label for="student_code" class="form-label">Student Code:</label> -->
                <input type="hidden" id="student_code" name="student_code" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-4">
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
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="certificate_name" class="form-label">Name for the Certificate:</label>
                        <input type="text" id="certificate_name" name="certificate_name" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="preferred_name" class="form-label">Preferred Name:</label>
                        <input type="text" id="preferred_name" name="preferred_name" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nationality" class="form-label">Nationality:</label>
                        <input type="text" id="nationality" name="nationality" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="permanent_address" class="form-label">Permanent Address:</label>
                        <textarea id="permanent_address" name="permanent_address" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="current_address" class="form-label">Current Address:</label>
                        <textarea id="current_address" name="current_address" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile:</label>
                        <input type="text" id="mobile" name="mobile" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Telephone:</label>
                        <input type="text" id="telephone" name="telephone" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="emergency_contact_name" class="form-label">Emergency Contact Name:</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="emergency_contact_number" class="form-label">Emergency Contact Number:</label>
                        <input type="text" id="emergency_contact_number" name="emergency_contact_number" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="english_ability" class="form-label">English Ability:</label>
                        <input type="checkbox" id="english_ability" name="english_ability" value="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="minimum_entry_qualification" class="form-label">Minimum Entry Qualification:</label>
                        <input type="checkbox" id="minimum_entry_qualification" name="minimum_entry_qualification" value="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nic" class="form-label">NIC:</label>
                        <input type="text" id="nic" name="nic" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="passport" class="form-label">Passport:</label>
                        <input type="text" id="passport" name="passport" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="personal_email" class="form-label">Personal Email:</label>
                        <input type="email" id="personal_email" name="personal_email" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="bms_email" class="form-label">BMS Email:</label>
                        <input type="email" id="bms_email" name="bms_email" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="occupation" class="form-label">Occupation:</label>
                        <input type="text" id="occupation" name="occupation" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="organization" class="form-label">Organization:</label>
                        <input type="text" id="organization" name="organization" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="previous_organization" class="form-label">Previous Organization:</label>
                        <input type="text" id="previous_organization" name="previous_organization" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
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
                </div>
                <div class="col-md-4">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="active" name="active" value="1">
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group ">
                        <button type="submit" class="btn btn-primary  float-right">Submit</button>
                    </div>
                </div>


            </div>




        </form>
        <h5 class="mt-5 mb-4 text-muted">Registered Students</h5>
        <table class="table table-striped mt-3 border">
            <thead>
                <tr>
                    <th scope="col">Student ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Cerificate Name</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <!-- <tbody>
                <?php



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
            </tbody> -->
            <tbody id="studentTableBody">
                <!-- Data will be loaded here -->
            </tbody>
        </table>

        <nav aria-label="Page navigation">
            <ul class="pagination" id="pagination">
                <!-- Pagination links will be loaded here -->
            </ul>
        </nav>


    </div>

    <script>
        $(document).ready(function() {
            const limit = 10;

            function loadStudents(page) {
                $.ajax({
                    url: 'fetch_students.php',
                    type: 'POST',
                    data: {
                        limit: limit,
                        page: page
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        let tableBody = '';
                        data.data.forEach(student => {
                            tableBody += `<tr>
                                <td>${student.student_code}</td>
                                <td>${student.first_name}</td>
                                <td>${student.last_name}</td>
                                <td>${student.certificate_name}</td>
                            </tr>`;
                        });
                        $('#studentTableBody').html(tableBody);

                        let pagination = '';
                        for (let i = 1; i <= data.pages; i++) {
                            pagination += `<li class="page-item ${i === page ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
                        }
                        $('#pagination').html(pagination);
                    }
                });
            }

            // Load initial data
            loadStudents(1);

            // Handle page click
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                loadStudents(page);
            });
        });
    </script>

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
                let studentCode = $(this).data('id');
                $('#search').val($(this).text());
                $('#search-results').hide();

                // Fetch and populate the student details
                $.ajax({
                    url: 'get_student.php',
                    type: 'POST',
                    data: {
                        id: studentCode
                    },
                    success: function(data) {
                        let student = JSON.parse(data);
                        $('#student_code').val(student.student_code);
                        $('#title').val(student.title);
                        $('#first_name').val(student.first_name);
                        $('#last_name').val(student.last_name);
                        $('#certificate_name').val(student.certificate_name);
                        $('#preferred_name').val(student.preferred_name);
                        $('#dob').val(student.date_of_birth);
                        $('#nationality').val(student.nationality);
                        $('#permanent_address').val(student.permanent_address);
                        $('#current_address').val(student.current_address);
                        $('#mobile').val(student.mobile);
                        $('#telephone').val(student.telephone);
                        $('#emergency_contact_name').val(student.emergency_contact_name);
                        $('#emergency_contact_number').val(student.emergency_contact_number);

                        // $('#english_ability').prop('checked', student.english_ability);
                        // $('#minimum_entry_qualification').prop('checked', student.minimum_entry_qualification);


                        // Handle checkboxes
                        $('#english_ability').prop('checked', student.english_ability == 1);
                        $('#minimum_entry_qualification').prop('checked', student.minimum_entry_qualification == 1);


                        $('#nic').val(student.nic);
                        $('#passport').val(student.passport);
                        $('#personal_email').val(student.personal_email);
                        $('#bms_email').val(student.bms_email);
                        $('#occupation').val(student.occupation);
                        $('#organization').val(student.organization);
                        $('#previous_organization').val(student.previous_organization);

                        // Set checkboxes
                        $('#bachelors').prop('checked', student.qualifications.includes('Bachelors'));
                        $('#masters').prop('checked', student.qualifications.includes('Masters'));
                        $('#diploma').prop('checked', student.qualifications.includes('Diploma'));
                        $('#cbm').prop('checked', student.qualifications.includes('CBM'));
                        $('#al').prop('checked', student.qualifications.includes('A/L'));
                        $('#pgdip').prop('checked', student.qualifications.includes('PGDip'));
                        $('#ifd').prop('checked', student.qualifications.includes('IFD'));
                        $('#ol').prop('checked', student.qualifications.includes('O/L'));

                        // Set active checkbox
                        $('#active').prop('checked', student.active == 1);
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