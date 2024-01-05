<?php global $mysqli;
include "Connection.php"; ?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_code = $_POST["item_code"];
    $item_category = $_POST["item_category"];
    $item_subcategory = $_POST["item_subcategory"];
    $item_name = $_POST["item_name"];
    $quantity = $_POST["quantity"];
    $unit_price = $_POST["unit_price"];

    // Validate the data (optional, you can add more validation here)
    if (empty($item_code) || empty($item_category) || empty($item_subcategory) || empty($item_name) || empty($quantity) || empty($unit_price)) {
        $errorMessage = "Please fill in all the required fields.";
    } else {
        $sql = "INSERT INTO item (item_code, item_category, item_subcategory, item_name, quantity, unit_price) VALUES ('$item_code','$item_category','$item_subcategory','$item_name','$quantity','$unit_price')";
        $result = mysqli_query($mysqli, $sql);
        $successMessage = "New record created successfully";
    }

}

$item_categories = array();

$sql = "SELECT id, category FROM item_category";

// Execute the query
$result = mysqli_query($mysqli, $sql);

// Check if the query was successful
if ($result) {
    // Loop through the query results and store the districts in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $item_categories[$row['id']] = $row['category'];
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the query error if needed
    echo mysqli_error($mysqli);
}

$item_SubCategories = array();

// Query to select all districts from the database
$sql = "SELECT id, sub_category FROM item_subcategory";

// Execute the query
$result = mysqli_query($mysqli, $sql);

// Check if the query was successful
if ($result) {
    // Loop through the query results and store the districts in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $item_SubCategories[$row['id']] = $row['sub_category'];
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the query error if needed
    echo mysqli_error($mysqli);
}

?>


<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <title>Item Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container border rounded-3 bg-img">
<!--    <div class="col-2">-->
        <?php include "sidebar.php"; ?>
        <br>
        <br>
        <a class="btn btn-sm btn-success" style="font-size: 18px;" href="viewItem.php" role="button">View Items</a>
        <h2 class="text-center display-6 heading">Item Registration Form</h2>
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
                <div class="col-md-3">
                    <label class="form-label" for="item_code">Item Code:</label>
                    <input class="form-control shadow-sm p-2 mb-1 bg-white rounded" type="text" id="item_code" name="item_code" required><br><br>
                </div>
                <div class="col-md-9">
                    <label class="form-label" for="item_name">Item Name:</label>
                    <input class="form-control shadow-sm p-2 mb-1 bg-white rounded" type="text" id="item_name" name="item_name" required><br><br>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="item_category">Item Category:</label>
                    <select class="form-select shadow-sm p-2 mb-1 bg-white rounded" id="item_category" name="item_category" required>
                        <option value="" disabled selected>Select Item-Category</option>
                        <?php
                        // Loop through the districts array and generate the options
                        foreach ($item_categories as $id => $category) {
                            echo "<option value=\"$id\">$category</option>";
                        }
                        ?>
                    </select><br><br>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="item_subcategory">Item Sub Category:</label>
                    <select class="form-select shadow-sm p-2 mb-1 bg-white rounded" id="item_subcategory" name="item_subcategory" required>
                        <option value="" disabled selected>Select Item-Subcategory</option>
                        <?php
                        // Loop through the districts array and generate the options
                        foreach ($item_SubCategories as $id => $subcategory) {
                            echo "<option value=\"$id\">$subcategory</option>";
                        }
                        ?>
                    </select><br><br>
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="quantity">Quantity:</label>
                    <input class="form-control shadow-sm p-2 mb-1 bg-white rounded" type="number" id="quantity" name="quantity" min="1" required><br><br>
                </div>
                <div class="col-md-7">
                    <label class="form-label" for="unit_price">Unit Price:</label>
                    <input class="form-control shadow-sm p-2 mb-1 bg-white rounded" type="number" id="unit_price" name="unit_price" min="0" step="0.01"
                           required><br><br>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-sm btn-success mb-4" style="width: 150px; font-size: 18px;">Submit</button>
                </div>
            </form>
        </section>
<!--    </div>-->
</div>
<script>
    function validateForm() {
        const itemCode = document.getElementById("itemCode").value;
        const itemName = document.getElementById("itemName").value;
        const itemCategory = document.getElementById("itemCategory").value;
        const itemSubCategory = document.getElementById("itemSubCategory").value;
        const quantity = document.getElementById("quantity").value;
        const unitPrice = document.getElementById("unitPrice").value;

        // Check if any of the fields are empty
        if (itemCode === "" || itemName === "" || itemCategory === "" || itemSubCategory === "" || quantity === "" || unitPrice === "") {
            alert("Please fill in all the required fields.");
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>
</body>
</html>
