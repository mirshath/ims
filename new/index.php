<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="scripts.js"></script> <!-- Link to your JS file -->
</head>

<body>
    <div class="container">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label style="color: red;" for="search">Search Students for Edit:</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Type to search..." autocomplete="off">
                <div id="search-results" class="dropdown-menu" style="display: none;">
                    <!-- Search results will be dynamically inserted here -->
                </div>
            </div>
        </div>

        <h2>Student Registration</h2>
        <form id="studentForm" action="process_form.php" method="post">

            <div>
                <label for="studentID">Student ID:</label>
                <input type="text" id="studentID" name="studentID" readonly>
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <!-- Add more fields as needed -->
            <button type="submit">Save</button>
        </form>
    </div>



    <script>
        // scripts.js

        // scripts.js

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
                            // Populate search results
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
                    data: {
                        id: studentID
                    },
                    success: function(data) {
                        let student = JSON.parse(data);
                        $('#studentID').val(student.id);
                        $('#name').val(student.name);
                        $('#email').val(student.email);
                        // Populate other fields as needed
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