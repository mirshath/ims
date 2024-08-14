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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and escape form inputs
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
    $entry_requirement = implode(',', $_POST['entry_requirement']); // Convert array to comma-separated string

    // Insert data into the program_table
    $sql = "INSERT INTO program_table (university, program_name, prog_code, coordinator_name, medium, duration, course_fee_lkr, course_fee_gbp, course_fee_usd, course_fee_euro, entry_requirement) 
            VALUES ('$university', '$program_name', '$prog_code', '$coordinator_name', '$medium', '$duration', '$course_fee_lkr', '$course_fee_gbp', '$course_fee_usd', '$course_fee_euro', '$entry_requirement')";

    if (mysqli_query($conn, $sql)) {
        header("Location: create_program.php"); // Redirect back to the form page after successful insertion
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Add New Program</h2>
        <form action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="university">University:</label>
                        <select class="form-control" id="university" name="university" required>
                            <?php foreach ($universities as $uni): ?>
                                <option value="<?php echo htmlspecialchars($uni['university_name']); ?>">
                                    <?php echo htmlspecialchars($uni['university_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="program_name">Program Name:</label>
                        <input type="text" class="form-control" id="program_name" name="program_name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="prog_code">Program Code:</label>
                        <input type="text" class="form-control" id="prog_code" name="prog_code">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="coordinator_name">Coordinator Name:</label>
                        <select class="form-control" id="coordinator_name" name="coordinator_name">
                            <?php foreach ($coordinators as $coord): ?>
                                <option value="<?php echo htmlspecialchars($coord['coordinator_name']); ?>">
                                    <?php echo htmlspecialchars($coord['coordinator_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="medium">Medium:</label>
                        <select class="form-control" id="medium" name="medium" required>
                            <option value="English">English</option>
                            <option value="Tamil">Tamil</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
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
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="course_fee_gbp">Course Fee (GBP):</label>
                        <input type="number" step="0.01" class="form-control" id="course_fee_gbp" name="course_fee_gbp">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="course_fee_usd">Course Fee (USD):</label>
                        <input type="number" step="0.01" class="form-control" id="course_fee_usd" name="course_fee_usd">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="course_fee_euro">Course Fee (EURO):</label>
                        <input type="number" step="0.01" class="form-control" id="course_fee_euro" name="course_fee_euro">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="entry_requirement">Entry Requirements:</label><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_bachelors" name="entry_requirement[]" value="Bachelors">
                                    <label class="form-check-label" for="entry_requirement_bachelors">
                                        Bachelors
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_masters" name="entry_requirement[]" value="Masters">
                                    <label class="form-check-label" for="entry_requirement_masters">
                                        Masters
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_diploma" name="entry_requirement[]" value="Diploma">
                                    <label class="form-check-label" for="entry_requirement_diploma">
                                        Diploma
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_cbm" name="entry_requirement[]" value="CBM">
                                    <label class="form-check-label" for="entry_requirement_cbm">
                                        CBM
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_al" name="entry_requirement[]" value="A/L">
                                    <label class="form-check-label" for="entry_requirement_al">
                                        A/L
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_work_experience" name="entry_requirement[]" value="Work Experience">
                                    <label class="form-check-label" for="entry_requirement_work_experience">
                                        Work Experience
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_pgdip" name="entry_requirement[]" value="PGDip">
                                    <label class="form-check-label" for="entry_requirement_pgdip">
                                        PGDip
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_ifd" name="entry_requirement[]" value="IFD">
                                    <label class="form-check-label" for="entry_requirement_ifd">
                                        IFD
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_other" name="entry_requirement[]" value="Other">
                                    <label class="form-check-label" for="entry_requirement_other">
                                        Other
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_ol" name="entry_requirement[]" value="O/L">
                                    <label class="form-check-label" for="entry_requirement_ol">
                                        O/L
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_professional_qualification" name="entry_requirement[]" value="Professional Qualification">
                                    <label class="form-check-label" for="entry_requirement_professional_qualification">
                                        Professional Qualification
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="entry_requirement_ecm" name="entry_requirement[]" value="ECM">
                                    <label class="form-check-label" for="entry_requirement_ecm">
                                        ECM
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>




            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <h2 class="mt-5">Program List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>University</th>
                    <th>Program Name</th>
                    <th>Program Code</th>
                    <th>Coordinator Name</th>
                    <th>Medium</th>
                    <th>Duration</th>
                    <th>Fees (LKR/GBP/USD/EURO)</th>
                    <th>Entry Requirements</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display all programs from the program_table
                $result = mysqli_query($conn, "SELECT * FROM program_table");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['university']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['prog_code']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['coordinator_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['medium']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['duration']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course_fee_lkr']) . " / " . htmlspecialchars($row['course_fee_gbp']) . " / " . htmlspecialchars($row['course_fee_usd']) . " / " . htmlspecialchars($row['course_fee_euro']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['entry_requirement']) . "</td>";
                    echo "<td><a href='delete_program.php?id=" . urlencode($row['prog_code']) . "' class='btn btn-danger'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>