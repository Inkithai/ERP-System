<?php global $mysqli;
include "Connection.php"; ?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $title = $_POST["title"];
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $contact_no = $_POST["contact_no"];
    $district = $_POST["district"];

    // Validate the data (optional, you can add more validation here)
    if (empty($title) || empty($first_name) || empty($middle_name) || empty($last_name) || empty($contact_no) || empty($district)) {
        $errorMessage = "Please fill in all the required fields.";
    } else {
        $sql = "INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) VALUES ('$title','$first_name','$middle_name','$last_name','$contact_no','$district')";
        $result = mysqli_query($mysqli, $sql);
        $successMessage = "New record created successfully";
    }

} else {
    echo mysqli_error($mysqli);
}

// Initialize an array to store the district options
$districts = array();

// Query to select all districts from the database
$sql = "SELECT district, id FROM district";

// Execute the query
$result = mysqli_query($mysqli, $sql);

// Check if the query was successful
if ($result) {
    // Loop through the query results and store the districts in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $districts[$row['id']] = $row['district'];
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the query error if needed
    echo "Error: " . mysqli_error($mysqli);
}
?>


<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Registration Form</title>
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="container border rounded-3">
    <?php include "sidebar.php"; ?>
        <br>
        <br>
        <a class="btn btn-sm btn-success" style="font-size: 18px;" href="viewCustomer.php" role="button">View Customers</a>

    <!--        <div class="col-9">-->
    <h2 class="text-center display-6 heading">Customer Registration Form</h2>
    <?php
    // Display success message if registration is successful
    if (isset($successMessage)) {
        echo "<p class='success-message'>$successMessage</p>";
    }

    // Display error message if there's any validation error or database error
    if (isset($errorMessage)) {
        echo "<p class='error-message'>$errorMessage</p>";
    }
    ?>

    <section class="container">
        <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
              onsubmit="return validateForm()">
            <div class="col-xl-12">
                <label class="form-label" for="title">Title:</label><br>
                <select class="form-select shadow-sm p-2 mb-2 bg-white rounded" id="title" name="title" required>
                    <option value="" disabled selected>Select Title</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Dr">Dr</option>
                </select><br><br>
            </div>
            <div class="col-xl-4 m-auto">
                <label class="form-label" for="first_name">First Name</label><br>
                <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="text" id="first_name" name="first_name" required><br><br>
            </div>
            <div class="col-xl-4 m-auto">
                <label class="form-label" for="middle_name">Middle Name</label><br>
                <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="text" id="middle_name" name="middle_name" required><br><br>
            </div>
            <div class="col-xl-4 m-auto">
                <label class="form-label" for="last_name">Last Name</label><br>
                <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="text" id="last_name" name="last_name" required><br><br>
            </div>
            <br>
            <div class="col-xl-6 margin">
                <label class="form-label" for="contact_no">Contact Number</label><br>
                <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="number" id="contact_no" name="contact_no" required><br><br>
            </div>
            <div class="col-xl-6">
                <label class="form-label" for="id">District</label><br>
                <select class="form-select shadow-sm p-2 mb-2 bg-white rounded" id="id" name="district" required>
                    <option value="" disabled selected>Select District</option>
                    <?php
                    // Loop through the districts array and generate the options
                    foreach ($districts as $id => $district) {
                        echo "<option value=\"$id\">$district</option>";
                    }
                    ?>
                </select><br><br>
            </div>
            <div class="pb-5 text-center">
            <button type="submit" class="btn btn-sm btn-success" style="font-size: 20px;">Submit</button>
            </div>
        </form>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
<script>
    function validateForm() {
        const title = document.getElementById("title").value;
        const firstName = document.getElementById("first_name").value;
        const middleName = document.getElementById("middle_name").value;
        const lastName = document.getElementById("last-name").value;
        const contactNumber = document.getElementById("contact_no").value;
        const district = document.getElementById("district").value;

        // Check if any of the fields are empty
        if (title === "" || firstName === "" || middleName === "" || lastName === "" || contactNumber === "" || district === "") {
            alert("Please fill in all the required fields.");
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>

</body>
</html>
