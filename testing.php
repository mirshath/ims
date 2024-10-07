<?php
include("database/connection.php");
include("includes/header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_code = $_POST['student_code'];
    $university_id = $_POST['university_id'];
    $programme_code = $_POST['programme_code'];
    $batch_id = $_POST['batch_id'];
    $student_registration_id = $_POST['student_registration_id'];
    $compulsory_subs = $_POST['compulsory_subs'];
    $elective_subs = $_POST['elective_subs'];

    // Check for duplicate student_registration_id
    $checkSql = "SELECT COUNT(*) FROM `allocate_programme` WHERE student_registration_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $student_registration_id);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        echo '<script>alert("Duplicate Student Registration ID found! Please use a unique ID.");</script>';
    } else {
        // Insert data into `allocate_programme` table
        $sql = "INSERT INTO `allocate_programme` (student_code, university_id, programme_code, batch_id, student_registration_id, elective_subs) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiss", $student_code, $university_id, $programme_code, $batch_id, $student_registration_id, $elective_subs);

        if ($stmt->execute()) {
            echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>



<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <?php include("nav.php"); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <?php include("includes/topnav.php"); ?>

            <div class="p-3">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="h4 mb-0 text-gray-800">Allocate Programs</h4>
                </div>


                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center" style="height: 60px;">
                                <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fas fa-plus-circle"></i>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <h6 class="mb-0 me-2">Allocate Programs</h6>
                            </div>
                            <div class="card-body">
                                <form id="allocate-form" action="" method="POST">

                                    <div class="row">
                                        <!-- left column  -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4"> <label for="student">Student</label></div>
                                                    <div class="col-md-8">
                                                        <select id="student" name="student_code" class="form-control select2" required></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4"> <label for="university">University</label></div>
                                                    <div class="col-md-8">
                                                        <select id="university" name="university_id" class="form-control select2" required></select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4"> <label for="programme">Programme</label></div>
                                                    <div class="col-md-8">
                                                        <select id="programme" name="programme_code" class="form-control select2" required></select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4"> <label for="batch">Batch</label></div>
                                                    <div class="col-md-8"><select required id="batch" name="batch_id" class="form-control select2" required></select></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4"><label for="registration_id">Student Registration ID</label></div>
                                                    <div class="col-md-8"><input type="text" placeholder="Student Registration ID" id="registration_id" name="student_registration_id" class="form-control" required></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- right column   -->
                                        <div class="col-md-6">
                                            <!-- Modules display area -->
                                            <div id="module-list" class="form-group mt-4">
                                                <h5>Modules</h5>
                                                <hr>
                                                <div id="modules-container">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Compulsory Modules</h6>
                                                            <div id="compulsory-modules-container">
                                                                <!-- Compulsory modules will be dynamically loaded here -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Elective Modules</h6>
                                                            <div id="elective-modules-container">
                                                                <!-- Elective modules will be dynamically loaded here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="text-right">
                                        <input type="hidden" id="compulsory-modules" name="compulsory_subs">
                                        <input type="hidden" id="elective-modules" name="elective_subs">
                                        <button type="submit" class="btn btn-primary" style="padding-left: 35px; padding-right: 35px;">Add</button>
                                    </div>
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
                                        // Populate the university dropdown and load programs and batches after it's populated
                                        populateUniversities(data.university_id, data.programme_code, data.batch_id);
                                        $('#registration_id').val(data.student_registration_id);

                                        // Additional logic to handle compulsory and elective subjects
                                        if (data.compulsory_subs) {
                                            // Process and display compulsory subjects
                                        }
                                        if (data.elective_subs) {
                                            // Process and display elective subjects
                                        }
                                    } else {
                                        // Clear fields if no data is found
                                        clearFields();
                                    }

                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching student details:', error);
                                }
                            });
                        } else {
                            // Clear fields if no student is selected
                            clearFields();
                        }
                    });

                    // Function to populate university, program, and batch dropdowns
                    function populateUniversities(selectedUniversityId, selectedProgrammeId, selectedBatchId) {
                        $.ajax({
                            url: 'allocateProgram_files/get_universities.php',
                            type: 'GET',
                            dataType: 'json',
                            success: function(universityData) {
                                $('#university').empty().append('<option value="">Select University</option>');
                                $.each(universityData, function(key, value) {
                                    $('#university').append(`<option value="${value.id}">${value.university_name}</option>`);
                                });

                                // Set the selected university
                                $('#university').val(selectedUniversityId).trigger('change');

                                // Load programmes after university is set
                                loadProgrammes(selectedUniversityId, selectedProgrammeId, selectedBatchId);
                            }
                        });
                    }

                    // Function to load programmes based on selected university
                    function loadProgrammes(universityId, selectedProgrammeId, selectedBatchId) {
                        $('#programme').empty().append('<option value="">Select Programme</option>');
                        $('#batch').empty().append('<option value="">Select Batch</option>');

                        if (universityId) {
                            $.ajax({
                                url: 'allocateProgram_files/get_programmes.php',
                                type: 'GET',
                                data: {
                                    university_id: universityId
                                },
                                dataType: 'json',
                                success: function(programmeData) {
                                    $('#programme').empty().append('<option value="">Select Programme</option>');
                                    $.each(programmeData, function(key, value) {
                                        $('#programme').append(`<option value="${value.program_code}">${value.program_name}</option>`);
                                    });

                                    // Set the selected programme and load batches
                                    $('#programme').val(selectedProgrammeId).trigger('change');
                                    loadBatches(selectedProgrammeId, selectedBatchId);
                                }
                            });
                        }
                    }

                    // Function to load batches based on selected programme
                    function loadBatches(programmeCode, selectedBatchId) {
                        $('#batch').empty().append('<option value="">Select Batch</option>');

                        if (programmeCode) {
                            $.ajax({
                                url: 'allocateProgram_files/get_batches.php',
                                type: 'GET',
                                data: {
                                    programme_code: programmeCode
                                },
                                dataType: 'json',
                                success: function(batchData) {
                                    $('#batch').empty().append('<option value="">Select Batch</option>');
                                    $.each(batchData, function(key, value) {
                                        $('#batch').append(`<option value="${value.id}">${value.batch_name}</option>`);
                                    });

                                    // Set the selected batch
                                    $('#batch').val(selectedBatchId).trigger('change');
                                }
                            });
                        }
                    }

                    // Function to clear all fields
                    function clearFields() {
                        $('#university').val('').trigger('change');
                        $('#programme').val('').trigger('change');
                        $('#batch').val('').trigger('change');
                        $('#registration_id').val('');
                    }

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
                            loadProgrammes(universityId, '', '');
                        }
                    });

                    // On programme change, load batches and modules
                    $('#programme').change(function() {
                        const programmeCode = $(this).val();
                        $('#batch').empty().append('<option value="">Select Batch</option>');

                        if (programmeCode) {
                            loadBatches(programmeCode, '');
                        }
                    });

                    // Handle form submission
                    $('#allocate-form').submit(function(e) {
                        e.preventDefault();

                        // Collect checked compulsory and elective modules
                        var compulsoryModules = $('input[name="compulsory_modules[]"]:checked').map(function() {
                            return this.value;
                        }).get().join(',');

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
                                //             $('#modules-container').append(`
                                //     <h6>Compulsory Modules</h6>
                                //     <div id="compulsory-modules-container"></div>
                                //     <h6>Elective Modules</h6>
                                //     <div id="elective-modules-container"></div>
                                // `);

                                $('#modules-container').append(`
                                    <div class="row">
                                        <!-- Compulsory Modules Column -->
                                        <div class="col-md-6">
                                            <h6>Compulsory Modules</h6>
                                            <div id="compulsory-modules-container"></div>
                                        </div>

                                        <!-- Elective Modules Column -->
                                        <div class="col-md-6">
                                            <h6>Elective Modules</h6>
                                            <div id="elective-modules-container"></div>
                                        </div>
                                    </div>
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
            </script>





        </div>
    </div>
</div>
</body>

</html>