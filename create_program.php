<?php
include './database/connection.php';

// Fetch universities for the dropdown
$universities_result = mysqli_query($conn, "SELECT * FROM universities");
$universities = [];
while ($row = mysqli_fetch_assoc($universities_result)) {
    $universities[] = $row;
}

// Fetch coordinators for the dropdown
$coordinators_result = mysqli_query($conn, "SELECT * FROM coordinator_table");
$coordinators = [];
while ($row = mysqli_fetch_assoc($coordinators_result)) {
    $coordinators[] = $row;
}

// Fetch criteria for checkboxes
$sql = "SELECT * FROM criterias";
$result = mysqli_query($conn, $sql);
$criterias = [];
while ($row = mysqli_fetch_assoc($result)) {
    $criterias[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_program'])) {
        if (isset($_POST['program_id'])) {
            $program_id = $_POST['program_id'];
            $delete_sql = "DELETE FROM program_table WHERE id='$program_id'";

            if (mysqli_query($conn, $delete_sql)) {
                echo "<div class='alert alert-success'>Program deleted successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: Program ID is missing.</div>";
        }
    } else {
        // Handle insert or update
        $program_id = $_POST['program_id'];
        $university = mysqli_real_escape_string($conn, $_POST['university']);
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

        if (isset($_POST['edit_program'])) {
            // Update existing program
            $update_sql = "UPDATE program_table SET 
                university='$university',
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
                WHERE id='$program_id'";

            if (mysqli_query($conn, $update_sql)) {
                // echo "<div class='alert alert-success'>Program updated successfully.</div>";
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            // Insert new program
            $insert_sql = "INSERT INTO program_table (university, program_name, prog_code, coordinator_name, medium, duration, course_fee_lkr, course_fee_gbp, course_fee_usd, course_fee_euro, entry_requirement) 
                VALUES ('$university', '$program_name', '$prog_code', '$coordinator_name', '$medium', '$duration', '$course_fee_lkr', '$course_fee_gbp', '$course_fee_usd', '$course_fee_euro', '$entry_requirements')";

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#program_select').on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: 'fetch_program_data.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            var data = JSON.parse(response);

                            // Populate the form fields with the fetched data
                            $('#program_id').val(data.id);
                            $('#university').val(data.university).trigger('change');
                            $('#program_name').val(data.program_name);
                            $('#prog_code').val(data.prog_code);
                            $('#coordinator_name').val(data.coordinator_name).trigger('change');
                            $('#medium').val(data.medium);
                            $('#duration').val(data.duration);
                            $('#course_fee_lkr').val(data.course_fee_lkr);
                            $('#course_fee_gbp').val(data.course_fee_gbp);
                            $('#course_fee_usd').val(data.course_fee_usd);
                            $('#course_fee_euro').val(data.course_fee_euro);

                            // Populate entry requirements
                            $('input[name="entry_requirement[]"]').each(function() {
                                $(this).prop('checked', data.entry_requirements.includes($(this).val()));
                            });

                            // Show the "Update" button and hide the "Submit" button
                            $('#submit_button').hide();
                            $('#update_button').show();
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: ", status, error);
                        }
                    });
                } else {
                    // Clear form fields if no program is selected
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
</head>

<body>
    <div class="container">
        <div class="form-group">
            <label for="program_select">Select Program to edit:</label>
            <select class="form-control select2" id="program_select" name="program_select">
                <option value="">-- Select a Program --</option>
                <?php
                // Fetch program names for the dropdown
                $programs_result = mysqli_query($conn, "SELECT * FROM program_table");
                while ($row = mysqli_fetch_assoc($programs_result)) {
                    echo '<option value="' . htmlspecialchars($row['id']) . '" >' . htmlspecialchars($row['program_name']) . '</option>';
                }
                ?>
            </select>
        </div>

        <h2 class="mt-4">Program </h2>
        <form action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="prog_code">ID:</label>
                        <input type="hidden" id="program_id" name="program_id">

                    </div>
                    <div class="form-group">
                        <label for="university">University:</label>
                        <select class="form-control select2" id="university" name="university" required>
                            <?php foreach ($universities as $uni): ?>
                                <option value="<?php echo htmlspecialchars($uni['university_name']); ?>">
                                    <?php echo htmlspecialchars($uni['university_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="form-group">
                        <label for="prog_code">Program Code:</label>
                        <input type="text" class="form-control" id="prog_code" name="prog_code" value="" required>
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

            <button type="submit" id="submit_button" class="btn btn-primary">Submit</button>
            <button type="submit" id="update_button" class="btn btn-success" name="edit_program" style="display: none;">Update</button>
            <button type="submit" id="delete_button" class="btn btn-danger" name="delete_program" style="display: none;">Delete</button>
        </form>



        <!-- ----------  -->


        <h2 class="mt-5">current courses</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Program Name</th>
                    <th>University</th>
                    <th>Program Code</th>
                    <th>Coordinator Name</th>
                    <th>Medium</th>
                    <th>Duration</th>

                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all programs to display in the table
                $programs_result = mysqli_query($conn, "SELECT * FROM program_table");
                while ($row = mysqli_fetch_assoc($programs_result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['program_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['university']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['prog_code']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['coordinator_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['medium']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['duration']) . '</td>';

                    echo '<td>';
                    echo '<button class="btn btn-info edit-button" data-prog-code="' . htmlspecialchars($row['id']) . '">Edit</button>';
                    echo '<form action="" method="post" style="display:inline;">
                            <input type="hidden" name="program_id" value="' . htmlspecialchars($row['id']) . '">
                            <button type="submit" name="delete_program" class="btn btn-danger">Delete</button>
                          </form>';
                    echo '</td>';

                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.edit-button').on('click', function() {
                var progCode = $(this).data('prog-code');
                $('#program_select').val(progCode).trigger('change');
            });
        });
    </script>

</body>

</html>