<?php
include("database/connection.php");
include("includes/header.php");



// Fetch universities for the dropdown
$universities_result = mysqli_query($conn, "SELECT * FROM universities");
$universities = [];
while ($row = mysqli_fetch_assoc($universities_result)) {
    $universities[] = $row;
}

// Fetch coordinators for the dropdown (assuming coordinators are necessary)
$coordinators_result = mysqli_query($conn, "SELECT * FROM coordinator_table");
$coordinators = [];
while ($row = mysqli_fetch_assoc($coordinators_result)) {
    $coordinators[] = $row;
}

// Fetch criteria for checkboxes
$criterias_result = mysqli_query($conn, "SELECT * FROM criterias");
$criterias = [];
while ($row = mysqli_fetch_assoc($criterias_result)) {
    $criterias[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_program'])) {
        if (!empty($_POST['program_code'])) {
            $program_code = mysqli_real_escape_string($conn, $_POST['program_code']);
            $delete_sql = "DELETE FROM program_table WHERE program_code='$program_code'";

            if (mysqli_query($conn, $delete_sql)) {
                // echo "<div class='alert alert-success'>Program deleted successfully.</div>";
                echo "<script>alert('Program deleted successfully!');</script>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: Program Code is missing.</div>";
        }
    } else {
        // Handle insert or update
        $program_code = isset($_POST['program_code']) ? mysqli_real_escape_string($conn, $_POST['program_code']) : '';
        $university_id = mysqli_real_escape_string($conn, $_POST['university']);
        $program_name = mysqli_real_escape_string($conn, $_POST['program_name']);
        $prog_code = mysqli_real_escape_string($conn, $_POST['prog_code']);
        $coordinator_name = mysqli_real_escape_string($conn, $_POST['coordinator_name']);
        $medium = mysqli_real_escape_string($conn, $_POST['medium']);
        $duration = mysqli_real_escape_string($conn, $_POST['duration']);
        $course_fee_lkr = mysqli_real_escape_string($conn, $_POST['course_fee_lkr']);
        $course_fee_gbp = mysqli_real_escape_string($conn, $_POST['course_fee_gbp']);
        $course_fee_usd = mysqli_real_escape_string($conn, $_POST['course_fee_usd']);
        $course_fee_euro = mysqli_real_escape_string($conn, $_POST['course_fee_euro']);

        // Handle entry requirements
        $entry_requirements = isset($_POST['entry_requirement']) ? implode(',', $_POST['entry_requirement']) : '';

        if (isset($_POST['edit_program']) && !empty($program_code)) {
            // Update existing program
            $update_sql = "UPDATE program_table SET 
                university_id='$university_id',
                program_name='$program_name',
                prog_code='$prog_code',
                coordinator_name='$coordinator_name',
                medium='$medium',
                duration='$duration',
                course_fee_lkr='$course_fee_lkr',
                course_fee_gbp='$course_fee_gbp',
                course_fee_usd='$course_fee_usd',
                course_fee_euro='$course_fee_euro',
                entry_requirement='$entry_requirements'
                WHERE program_code='$program_code'";

            // Output the query for debugging
            // echo $update_sql;

            if (mysqli_query($conn, $update_sql)) {
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            // Insert new program
            $insert_sql = "INSERT INTO program_table 
                (university_id, program_name, prog_code, coordinator_name, medium, duration, course_fee_lkr, course_fee_gbp, course_fee_usd, course_fee_euro, entry_requirement) 
                VALUES ('$university_id', '$program_name', '$prog_code', '$coordinator_name', '$medium', '$duration', '$course_fee_lkr', '$course_fee_gbp', '$course_fee_usd', '$course_fee_euro', '$entry_requirements')";

            if (mysqli_query($conn, $insert_sql)) {
                echo "<div class='alert alert-success'>Program added successfully.</div>";
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
    }
}

?>



<script>
    $(document).ready(function() {
        // Initialize select2 for dropdowns
        $('.select2').select2();

        // Event listener for program selection change
        $('#program_select').on('change', function() {
            var program_code = $(this).val();

            if (program_code) {
                // If a program is selected, fetch its data
                $.ajax({
                    url: 'fetch_program_data.php',
                    type: 'POST',
                    data: {
                        program_code: program_code
                    },
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);

                            // Populate the form fields with the fetched data
                            $('#program_code').val(data.program_code);
                            $('#university').val(data.university_id).trigger('change');
                            $('#program_name').val(data.program_name);
                            $('#prog_code').val(data.prog_code);
                            $('#coordinator_name').val(data.coordinator_name).trigger('change');
                            $('#medium').val(data.medium);
                            $('#duration').val(data.duration);
                            $('#course_fee_lkr').val(data.course_fee_lkr);
                            $('#course_fee_gbp').val(data.course_fee_gbp);
                            $('#course_fee_usd').val(data.course_fee_usd);
                            $('#course_fee_euro').val(data.course_fee_euro);

                            // Populate entry requirements checkboxes
                            $('input[name="entry_requirement[]"]').each(function() {
                                var value = $(this).val();
                                if (data.entry_requirements.includes(value)) {
                                    $(this).prop('checked', true);
                                } else {
                                    $(this).prop('checked', false);
                                }
                            });

                            // Show the "Update" button and hide the "Submit" button
                            $('#submit_button').hide();
                            $('#update_button').show();
                        } catch (e) {
                            console.error("Error parsing JSON response: ", e);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                    }
                });
            } else {
                // Clear form fields if no program is selected
                $('#program_code').val('');
                $('#university').val('').trigger('change');
                $('#program_name').val('');
                $('#prog_code').val('');
                $('#coordinator_name').val('').trigger('change');
                $('#medium').val('');
                $('#duration').val('');
                $('#course_fee_lkr').val('');
                $('#course_fee_gbp').val('');
                $('#course_fee_usd').val('');
                $('#course_fee_euro').val('');
                $('input[name="entry_requirement[]"]').prop('checked', false);

                // Show the "Submit" button and hide the "Update" button
                $('#submit_button').show();
                $('#update_button').hide();
            }
        });
    });
</script>






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
            <!-- Begin Page Content -->

            <!-- ----------------------------------------------------------  -->
            <!-- ----------------------------------------------------------  -->


            <div class="p-3">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="h4 mb-0 text-gray-800">Program managment</h4>
                </div>


                
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-md-4 ml-auto">

                            <!-- Add Criteria Form -->
                            <div class="form-group">
                                <label for="program_select" style="color: red; font-weight: 600;">Select Program to edit:</label>
                                <select class="form-control select2" id="program_select" name="program_select">
                                    <option value="">-- Select a Program --</option>
                                    <?php
                                    // Fetch program names for the dropdown
                                    $programs_result = mysqli_query($conn, "SELECT program_code, program_name FROM program_table");
                                    while ($row = mysqli_fetch_assoc($programs_result)) {
                                        echo '<option value="' . htmlspecialchars($row['program_code']) . '">' . htmlspecialchars($row['program_name']) . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>



                <!-- add form // create forms -->

                <div class="row mb-5">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex align-items-center" style="height: 60px;">
                                <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <i class="fas fa-plus-circle"></i>
                                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                <h6 class="mb-0 me-2">Add Program</h6>
                            </div>

                            <div class="card-body">
                                <form action="" method="post" class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!-- <label for="program_code">Program ID:</label> -->
                                                <input type="hidden" id="program_code" name="program_code">
                                            </div>
                                            <div class="form-group">
                                                <label for="university">University:</label>
                                                <select class="form-control select2" id="university" name="university" required>
                                                    <?php foreach ($universities as $uni): ?>
                                                        <option value="<?php echo htmlspecialchars($uni['id']); ?>">
                                                            <?php echo htmlspecialchars($uni['university_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="prog_code">Program Code:</label>
                                                <input type="text" class="form-control" id="prog_code" name="prog_code" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="program_name">Program Name:</label>
                                                <input type="text" class="form-control" id="program_name" name="program_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="coordinator_name">Coordinator Name:</label>
                                                <select class="form-control select2" id="coordinator_name" name="coordinator_name" required>
                                                    <?php foreach ($coordinators as $coord): ?>
                                                        <option value="<?php echo htmlspecialchars($coord['coordinator_name']); ?>">
                                                            <?php echo htmlspecialchars($coord['coordinator_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="medium">Medium:</label>
                                                <select class="form-control" id="medium" name="medium" required>
                                                    <option value="English">English</option>
                                                    <option value="Tamil">Tamil</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="duration">Duration:</label>
                                                <input type="text" class="form-control" id="duration" name="duration">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="course_fee_lkr">Course Fee (LKR):</label>
                                                <input type="number" step="0.01" class="form-control" id="course_fee_lkr" name="course_fee_lkr">
                                            </div>
                                            <div class="form-group">
                                                <label for="course_fee_gbp">Course Fee (GBP):</label>
                                                <input type="number" step="0.01" class="form-control" id="course_fee_gbp" name="course_fee_gbp">
                                            </div>
                                            <div class="form-group">
                                                <label for="course_fee_usd">Course Fee (USD):</label>
                                                <input type="number" step="0.01" class="form-control" id="course_fee_usd" name="course_fee_usd">
                                            </div>
                                            <div class="form-group">
                                                <label for="course_fee_euro">Course Fee (EURO):</label>
                                                <input type="number" step="0.01" class="form-control" id="course_fee_euro" name="course_fee_euro">
                                            </div>
                                            <div class="form-group">
                                                <label>Entry Requirements:</label>
                                                <?php foreach ($criterias as $criteria): ?>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="entry_requirement[]" value="<?php echo htmlspecialchars($criteria['criteria_name']); ?>">
                                                        <label class="form-check-label"><?php echo htmlspecialchars($criteria['criteria_name']); ?></label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="text-right">
                                        <button type="submit" id="submit_button" class="btn btn-primary">Submit</button>
                                        <button type="submit" id="update_button" class="btn btn-success" name="edit_program" style="display: none;">Update</button>
                                        <button type="submit" id="delete_button" class="btn btn-danger" name="delete_program" style="display: none;">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <!-- ----------------------------------------------------------  -->
            <!-- ----------------------------------------------------------  -->


            <div class="container-fluid" style="font-size: 13px;">

                <div class="card shadow mb-4">
                    <div class="card-header d-flex align-items-center" style="height: 60px;"> <!-- Added d-flex and align-items-center -->
                        <span class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="fas fa-list"></i>
                        </span> &nbsp;&nbsp;&nbsp;&nbsp;
                        <h6 class="mb-0">Current Programms</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Program Name</th>
                                        <th>University</th>
                                        <th>Program Code</th>
                                        <th>Coordinator Name</th>
                                        <th>Medium</th>
                                        <th>Duration</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch all programs to display in the table
                                    $programs_result = mysqli_query($conn, "SELECT * FROM program_table");
                                    while ($row = mysqli_fetch_assoc($programs_result)) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['program_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['university_id']) . '</td>'; // Assuming you have a way to get the university name from ID
                                        echo '<td>' . htmlspecialchars($row['prog_code']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['coordinator_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['medium']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['duration']) . '</td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-info btn-sm edit-button" data-prog-code="' . htmlspecialchars($row['program_code']) . '">Edit</button>';
                                        echo '<form action="" method="post" style="display:inline;">
                              <input type="hidden" name="program_code" value="' . htmlspecialchars($row['program_code']) . '">
                              <button type="submit" name="delete_program" class="btn btn-danger btn-sm">Delete</button>
                              </form>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<script>
    $(document).ready(function() {
        $('.edit-button').on('click', function() {
            var progCode = $(this).data('prog-code');
            $('#program_select').val(progCode).trigger('change');
        });
    });
</script>


<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="./vendor/datatables/dataTables.bootstrap4.min.css">

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

</body>

</html>