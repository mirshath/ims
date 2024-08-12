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
        <form id="studentForm" action="process_form.php" method="post">
            <div class="mb-3">
                <label for="studentID" class="form-label">Student ID:</label>
                <input type="text" id="studentID" name="studentID" class="form-control" readonly>
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
        </form>
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
                        data: { query: query },
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
                    data: { id: studentID },
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
