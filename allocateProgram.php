<?php
include("database/connection.php");
include("includes/header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_code = $_POST['student_code'];
    $university_id = $_POST['university_id'];
    $programme_code = $_POST['programme_code'];
    $batch_id = $_POST['batch_id'];
    $student_registration_id = $_POST['student_registration_id'];

    // Insert data into `allocate_programme` table
    $sql = "INSERT INTO `allocate_programme` (student_code, university_id, programme_code, batch_id, student_registration_id) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiis", $student_code, $university_id, $programme_code, $batch_id, $student_registration_id);

    if ($stmt->execute()) {
        echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
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
            <!-- End of Topbar -->
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <!-- Modules display area -->
                    <div id="module-list" class="form-group mt-4">
                        <h5>Modules</h5>
                        <div id="modules-container">
                            <!-- Modules will be dynamically loaded here -->
                        </div>
                    </div>
                    <!-- Hidden fields to store checked module IDs -->
                    <input type="hidden" id="compulsory-modules" name="compulsory_subs">
                    <input type="hidden" id="elective-modules" name="elective_subs">
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
        // $('#programme').change(function() {
        //     const programmeCode = $(this).val();
        //     $('#batch').empty().append('<option value="">Select Batch</option>');

        //     if (programmeCode) {
        //         // Fetch batches
        //         $.ajax({
        //             url: 'allocateProgram_files/get_batches.php',
        //             type: 'GET',
        //             data: {
        //                 programme_code: programmeCode
        //             },
        //             dataType: 'json',
        //             success: function(data) {
        //                 $('#batch').empty().append('<option value="">Select Batch</option>');
        //                 $.each(data, function(key, value) {
        //                     $('#batch').append(`<option value="${value.id}">${value.batch_name}</option>`);
        //                 });
        //             }
        //         });

        //         // Fetch modules for the selected programme
        //         $.ajax({
        //             url: 'allocateProgram_files/get_modules.php',
        //             type: 'GET',
        //             data: {
        //                 programme_code: programmeCode
        //             },
        //             dataType: 'json',
        //             success: function(data) {
        //                 $('#modules-container').empty();
        //                 if (data.length > 0) {
        //                     $.each(data, function(key, value) {
        //                         $('#modules-container').append(`
        //                         <div class="form-check">
        //                             <input class="form-check-input" type="checkbox" id="module${value.module_id}" name="modules[]" value="${value.module_id}">
        //                             <label class="form-check-label" for="module${value.module_id}">
        //                                 ${value.module_name}
        //                             </label>
        //                         </div>
        //                     `);
        //                     });
        //                 } else {
        //                     $('#modules-container').append('<p>No modules found for this programme.</p>');
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 $('#modules-container').empty().append('<p>Error fetching modules.</p>');
        //                 console.error('Error:', error);
        //             }
        //         });
        //     }
        // });

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
                        $('#modules-container').empty();
                        let compulsoryModules = [];
                        let electiveModules = [];

                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                const moduleType = value.module_type; // Assuming module_type is 'compulsory' or 'elective'
                                const moduleId = value.module_id;
                                const moduleName = value.module_name;

                                if (moduleType === 'compulsory') {
                                    compulsoryModules.push(moduleId);
                                } else if (moduleType === 'elective') {
                                    electiveModules.push(moduleId);
                                }

                                $('#modules-container').append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="module${moduleId}" name="${moduleType}_modules[]" value="${moduleId}">
                                    <label class="form-check-label" for="module${moduleId}">
                                        ${moduleName}
                                    </label>
                                </div>
                            `);
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
    });
</script>
</body>

</html>
<?php $conn->close(); ?>