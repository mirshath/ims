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
    $('#programme').change(function() {
        const programmeCode = $(this).val();
        $('#batch').empty().append('<option value="">Select Batch</option>');

        if (programmeCode) {
            // Fetch batches
            $.ajax({
                url: 'allocateProgram_files/get_batches.php',
                type: 'GET',
                data: { programme_code: programmeCode },
                dataType: 'json',
                success: function(data) {
                    $('#batch').empty().append('<option value="">Select Batch</option>');
                    $.each(data, function(key, value) {
                        $('#batch').append(`<option value="${value.id}">${value.batch_name}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });

            // Fetch modules
            $.ajax({
                url: 'allocateProgram_files/get_modules.php',
                type: 'GET',
                data: { programme_code: programmeCode },
                dataType: 'json',
                success: function(data) {
                    $('#modules-container').empty();
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#modules-container').append(`<p>${value.module_name}</p>`);
                        });
                    } else {
                        $('#modules-container').append('<p>No modules found for this programme.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    });
    });
</script>
</body>

</html>
<?php $conn->close(); ?>