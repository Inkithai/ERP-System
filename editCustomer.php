<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ERP";

// Create database connection
$connection = new mysqli($servername, $username, $password, $database);

$id = "";
$title = "";
$fname = "";
$lname = "";
$contact = "";
$district = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the data of the customer
    if (!isset($_GET["id"])) {
        header("location:/erpsystem/ERP-System-Csquare.Cloud/index.php");
        exit;
    }

    $id = $_GET["id"];

    // Read the row of the selected customer from the database table
    $sql = "SELECT * FROM customer WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location:/erpsystem/ERP-System-Csquare.Cloud/index.php");
        exit;
    }

    // Populate the form fields with the customer data
    $title = $row['title'];
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $contact = $row['contact_no'];
    $district = $row['district'];
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // POST method: Update the customer data
    $id = $_POST["id"];
    $title = $_POST["title"];
    $fname = $_POST["Fname"];
    $lname = $_POST["Lname"];
    $contact = $_POST["Contact"];
    $district = $_POST["district"];

    do {
        if (empty($title) || empty($fname) || empty($lname) || empty($contact) || empty($district)) {
            $errorMessage = "Fill All Fields!";
            break;
        }

        $sql = "UPDATE customer SET title=?, first_name=?, last_name=?, contact_no=?, district=? WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssssi", $title, $fname, $lname, $contact, $district, $id);
        $result = $stmt->execute();
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Customer updated successfully!";
        header("location:/erpsystem/ERP-System-Csquare.Cloud/index.php");
        exit;

    } while (false);
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP-System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include "sidebar.php"; ?>


    <div class="container my-5">
        <h2>Edit Customer</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

   
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
            <button type="submit" class="btn btn-sm btn-success" style="font-size: 20px;">Save</button>
            <a class="btn btn-sm btn-success" href="viewCustomer.php" role="button" style="font-size: 20px;">Cancel</a>
            </div>
        </form>
    </section>
</div>
    </div>
</body>
</html>
