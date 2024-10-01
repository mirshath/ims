<?php
include("database/connection.php");
include("includes/header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_code = $_POST['student_code'];
    $university_id = $_POST['university_id'];
    $programme_code = $_POST['programme_code'];
    $batch_id = $_POST['batch_id'];
    $student_registration_id = $_POST['student_registration_id'];

    // Store selected compulsory modules
    // $compulsory_subs = isset($_POST['compulsory_modules']) ? implode(',', $_POST['compulsory_modules']) : '';    compulsory_subs = ?, $compulsory_subs,
    // Store selected elective modules
    $elective_subs = isset($_POST['elective_modules']) ? implode(',', $_POST['elective_modules']) : '';

    // Check if the student already has a record
    $checkSql = "SELECT * FROM allocate_programme WHERE student_code = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $student_code);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update existing record
        $updateSql = "UPDATE allocate_programme SET university_id = ?, programme_code = ?, batch_id = ?, student_registration_id = ?,  elective_subs = ? WHERE student_code = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("iisssi", $university_id, $programme_code, $batch_id, $student_registration_id,  $elective_subs, $student_code);

        if ($updateStmt->execute()) {
            echo '<script>alert("Record updated successfully!"); window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
        } else {
            echo "Error: " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        // Insert new record     , compulsory_subs,    $compulsory_subs, 
        $insertSql = "INSERT INTO allocate_programme (student_code, university_id, programme_code, batch_id, student_registration_id ,elective_subs) VALUES (?,  ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("iiiiss", $student_code, $university_id, $programme_code, $batch_id, $student_registration_id,  $elective_subs);

        if ($insertStmt->execute()) {
            echo '<script>alert("Record added successfully!"); window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
        } else {
            echo "Error: " . $insertStmt->error;
        }
        $insertStmt->close();
    }
    $checkStmt->close();
}
$conn->close();
?>

<!-- Page Wrapper -->
<div id="wrapper">
    <?php include("nav.php"); ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <?php include("includes/topnav.php"); ?>
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="container">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h4 class="h4 mb-0 text-gray-800">Allocate Programs</h4>
                    </div>
                    <!-- forms  -->
                    <form id="allocate-form" action="" method="POST">
                        <div class="form-group">
                            <label for="student">Student</label>
                            <select id="student" name="student_code" class="form-control select2" required></select>
                        </div>
                        <div class="form-group">
                            <label for="university">University</label>
                            <select id="university" name="university_id" class="form-control select2" required></select>
                        </div>
                        <div class="form-group">
                            <label for="programme">Programme</label>
                            <select id="programme" name="programme_code" class="form-control select2" required></select>
                        </div>
                        <div class="form-group">
                            <label for="batch">Batch</label>
                            <select id="batch" name="batch_id" class="form-control select2" required></select>
                        </div>
                        <div class="form-group">
                            <label for="registration_id">Student Registration ID</label>
                            <input type="text" id="registration_id" name="student_registration_id" class="form-control" required>
                        </div>
                        <!-- Modules display area -->
                        <div id="module-list" class="form-group mt-4">
                            <h5>Modules</h5>
                            <div id="modules-container">
                                <h6>Compulsory Modules</h6>
                                <div id="compulsory-modules-container">
                                    <!-- Compulsory modules will be dynamically loaded here -->
                                </div>

                                <h6>Elective Modules</h6>
                                <div id="elective-modules-container">
                                    <!-- Elective modules will be dynamically loaded here -->
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="compulsory-modules" name="compulsory_subs">
                        <input type="hidden" id="elective-modules" name="elective_subs">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();

        // Load students
        $.ajax({
            url: 'allocateProgram_files/get_students.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#student').empty().append('<option value="">Select Student</option>');
                $.each(data, function(key, value) {
                    $('#student').append(`<option value="${value.student_code}">${value.first_name} ${value.last_name}</option>`);
                });
            }
        });

        // On student selection, load existing details
        $('#student').change(function() {
            const studentCode = $(this).val();

            if (studentCode) {
                $.ajax({
                    url: 'allocateProgram_files/get_student_details.php',
                    type: 'GET',
                    data: {
                        student_code: studentCode
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            // Populate fields with existing data
                            $('#university').val(data.university_id).trigger('change');
                            $('#programme').val(data.programme_code).trigger('change');
                            $('#batch').val(data.batch_id).trigger('change');
                            $('#registration_id').val(data.student_registration_id);
                            // If you need to handle module checkboxes
                            // You may need to implement additional logic to check the relevant modules based on `data.elective_subs`
                        } else {
                            // Clear fields if no data is found
                            $('#university').val('').trigger('change');
                            $('#programme').val('').trigger('change');
                            $('#batch').val('').trigger('change');
                            $('#registration_id').val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching student details:', error);
                    }
                });
            } else {
                // Clear fields if no student is selected
                $('#university').val('').trigger('change');
                $('#programme').val('').trigger('change');
                $('#batch').val('').trigger('change');
                $('#registration_id').val('');
            }
        });
        

        // Load universities
        $.ajax({
            url: 'allocateProgram_files/get_universities.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#university').empty().append('<option value="">Select University</option>');
                $.each(data, function(key, value) {
                    $('#university').append(`<option value="${value.id}">${value.university_name}</option>`);
                });
            }
        });

        // On university change, load programmes
        $('#university').change(function() {
            const universityId = $(this).val();
            $('#programme').empty().append('<option value="">Select Programme</option>');
            $('#batch').empty().append('<option value="">Select Batch</option>');
            $('#modules-container').empty(); // Clear modules when university changes

            if (universityId) {
                $.ajax({
                    url: 'allocateProgram_files/get_programmes.php',
                    type: 'GET',
                    data: {
                        university_id: universityId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#programme').empty().append('<option value="">Select Programme</option>');
                        $.each(data, function(key, value) {
                            $('#programme').append(`<option value="${value.program_code}">${value.program_name}</option>`);
                        });
                    }
                });
            }
        });

        // On programme change, load batches and modules
        $('#programme').change(function() {
            const programmeCode = $(this).val();
            $('#batch').empty().append('<option value="">Select Batch</option>');

            if (programmeCode) {
                // Fetch batches
                $.ajax({
                    url: 'allocateProgram_files/get_batches.php',
                    type: 'GET',
                    data: {
                        programme_code: programmeCode
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#batch').empty().append('<option value="">Select Batch</option>');
                        $.each(data, function(key, value) {
                            $('#batch').append(`<option value="${value.id}">${value.batch_name}</option>`);
                        });
                    }
                });

                // Fetch modules for the selected programme
                $.ajax({
                    url: 'allocateProgram_files/get_modules.php',
                    type: 'GET',
                    data: {
                        programme_code: programmeCode
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Clear both sections
                        $('#modules-container').empty();
                        $('#modules-container').append(`
                        <h6>Compulsory Modules</h6>
                        <div id="compulsory-modules-container"></div>
                        <h6>Elective Modules</h6>
                        <div id="elective-modules-container"></div>
                    `);

                        let compulsoryModules = [];
                        let electiveModules = [];

                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                const moduleType = value.type;
                                const moduleId = value.id;
                                const moduleName = value.module_name;

                                // Create the module checkbox HTML
                                const moduleHTML = `
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="module${moduleId}" name="elective_modules[]" value="${moduleName}">
                                        <label class="form-check-label" for="module${moduleId}">
                                            ${moduleName}
                                        </label>
                                    </div>
                                `;

                                // Append to the corresponding container based on the module type
                                if (moduleType === 'Compulsory') {
                                    compulsoryModules.push(moduleId);
                                    $('#compulsory-modules-container').append(moduleHTML);
                                } else if (moduleType === 'Elective') {
                                    electiveModules.push(moduleId);
                                    $('#elective-modules-container').append(moduleHTML);
                                }
                            });

                            // Update hidden fields with selected module IDs
                            $('#compulsory-modules').val(compulsoryModules.join(','));
                            $('#elective-modules').val(electiveModules.join(','));
                        } else {
                            $('#modules-container').append('<p>No modules found for this programme.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#modules-container').empty().append('<p>Error fetching modules.</p>');
                        console.error('Error:', error);
                    }
                });
            }
        });

        // Handle form submission
        $('#allocate-form').submit(function(e) {
            e.preventDefault();

            // Collect checked compulsory modules
            var compulsoryModules = $('input[name="compulsory_modules[]"]:checked').map(function() {
                return this.value;
            }).get().join(',');

            // Collect checked elective modules
            var electiveModules = $('input[name="elective_modules[]"]:checked').map(function() {
                return this.value;
            }).get().join(',');

            // Set the values to hidden fields
            $('#compulsory-modules').val(compulsoryModules);
            $('#elective-modules').val(electiveModules);

            // Submit the form
            this.submit();
        });

    });
</script>
</body>

</html>