<?php
include("database/connection.php");
include("includes/header.php");

$coordinator_query = "SELECT * FROM coordinator_table";
$coordinator_result = mysqli_query($conn, $coordinator_query);

// Fetch universities
$university_query = "SELECT * FROM universities";
$university_result = mysqli_query($conn, $university_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO program_table (university, program_name, prog_code, coordinator, medium, duration, course_fee_lkr, course_fee_gbp, course_fee_usd, course_fee_euro, entry_requirement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $university, $program_name, $prog_code, $coordinator, $medium, $duration, $course_fee_lkr, $course_fee_gbp, $course_fee_usd, $course_fee_euro, $entry_requirement);

    // Set parameters and execute
    $university = $_POST['university'];
    $program_name = $_POST['program_name'];
    $prog_code = $_POST['prog_code'];
    $coordinator = $_POST['coordinator'];
    $medium = $_POST['medium'];
    $duration = $_POST['duration'];
    $course_fee_lkr = $_POST['course_fee_lkr'];
    $course_fee_gbp = $_POST['course_fee_gbp'];
    $course_fee_usd = $_POST['course_fee_usd'];
    $course_fee_euro = $_POST['course_fee_euro'];

    // Convert array to a comma-separated string for SET data type
    $entry_requirement = isset($_POST['entry_requirement']) ? implode(',', $_POST['entry_requirement']) : '';

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">New record created successfully</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Program Registration Form</h2>

        <form action="" method="POST">
            <div class="form-group">
                <label for="university">University:</label>
                <select class="form-control select2" id="university" name="university" required>
                    <?php while ($row = mysqli_fetch_assoc($university_result)): ?>
                        <option value="<?php echo $row['university_name']; ?>"><?php echo $row['university_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="program_name">Program Name:</label>
                <input type="text" class="form-control" id="program_name" name="program_name" required>
            </div>
            <div class="form-group">
                <label for="prog_code">Program Code:</label>
                <input type="text" class="form-control" id="prog_code" name="prog_code">
            </div>
            <div class="form-group">
                <label for="coordinator">Coordinator:</label>
                <select class="form-control select2" id="coordinator" name="coordinator">
                    <?php while ($row = mysqli_fetch_assoc($coordinator_result)): ?>
                        <option value="<?php echo $row['coordinator_name']; ?>"><?php echo $row['coordinator_name']; ?></option>
                    <?php endwhile; ?>
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
            <div class="form-group">
                <label for="course_fee_lkr">Course Fee (LKR):</label>
                <input type="number" class="form-control" id="course_fee_lkr" name="course_fee_lkr" step="0.01">
            </div>
            <div class="form-group">
                <label for="course_fee_gbp">Course Fee (GBP):</label>
                <input type="number" class="form-control" id="course_fee_gbp" name="course_fee_gbp" step="0.01">
            </div>
            <div class="form-group">
                <label for="course_fee_usd">Course Fee (USD):</label>
                <input type="number" class="form-control" id="course_fee_usd" name="course_fee_usd" step="0.01">
            </div>
            <div class="form-group">
                <label for="course_fee_euro">Course Fee (Euro):</label>
                <input type="number" class="form-control" id="course_fee_euro" name="course_fee_euro" step="0.01">
            </div>
            <div class="form-group">
                <label>Entry Requirement:</label><br>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="bachelors" name="entry_requirement[]" value="Bachelors">
                    <label class="form-check-label" for="bachelors">Bachelors</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="masters" name="entry_requirement[]" value="Masters">
                    <label class="form-check-label" for="masters">Masters</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="diploma" name="entry_requirement[]" value="Diploma">
                    <label class="form-check-label" for="diploma">Diploma</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="cbm" name="entry_requirement[]" value="CBM">
                    <label class="form-check-label" for="cbm">CBM</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="al" name="entry_requirement[]" value="A/L">
                    <label class="form-check-label" for="al">A/L</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="work_experience" name="entry_requirement[]" value="Work Experience">
                    <label class="form-check-label" for="work_experience">Work Experience</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="pgdip" name="entry_requirement[]" value="PGDip">
                    <label class="form-check-label" for="pgdip">PGDip</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="ifd" name="entry_requirement[]" value="IFD">
                    <label class="form-check-label" for="ifd">IFD</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="other" name="entry_requirement[]" value="Other">
                    <label class="form-check-label" for="other">Other</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="ol" name="entry_requirement[]" value="O/L">
                    <label class="form-check-label" for="ol">O/L</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="professional_qualification" name="entry_requirement[]" value="Professional Qualification">
                    <label class="form-check-label" for="professional_qualification">Professional Qualification</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="ecm" name="entry_requirement[]" value="ECM">
                    <label class="form-check-label" for="ecm">ECM</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>
</html>
