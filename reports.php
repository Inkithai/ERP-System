<?php global $mysqli;
include "Connection.php"; ?>


<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Report</title>
    <link rel="stylesheet" type="text/css" href="style/index.css">
</head>
<body>
<div class="container border rounded-3 bg-img">
    <?php include "sidebar.php"; ?>
    <h2 class="text-center display-6 heading">Invoice Report</h2>
    <?php
    // Display error message if there's any validation error or database error
    if (isset($errorMessage)) {
        echo "<p class='error-message'>$errorMessage</p>";
    }
    ?>
    <form class="row p-auto m-auto text-center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
          onsubmit="return validateInvoiceReport()">
        <div class="col-md-6 m-auto">
            <label for="startDate">Start Date:</label>
            <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="date" id="startDate" name="startDate" required><br><br>
        </div>
        <div class="col-md-6 m-auto">
            <label for="endDate">End Date:</label>
            <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="date" id="endDate" name="endDate" required><br><br>
        </div>
        <div>
        <button type="submit" class="btn btn-success mb-4 rounded-pill">Generate Report</button>
        </div>
        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get the form data
            $start_date = $_POST["startDate"];
            $end_date = $_POST["endDate"];

            // Validate the data (optional, you can add more validation here)
            if (empty($start_date) || empty($end_date)) {
                $errorMessage = "Please select both start and end dates.";
            } else {
                // Prepare the SQL query to retrieve invoices within the specified date range
                $sql = "SELECT i.invoice_no ,i.date, c.first_name, c.middle_name, c.last_name, 
                d.district, i.item_count, i.amount 
                FROM invoice AS i 
                JOIN customer AS c ON i.id = c.id 
                JOIN district AS d ON c.district = d.id
                WHERE i.date BETWEEN ? AND ?";

                // Prepare the statement
                $stmt = $mysqli->prepare($sql);

                // Bind the date range values to the prepared statement
                $stmt->bind_param("ss", $start_date, $end_date);

                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                $currentDate = date("Y-m-d");
                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    // Display the invoice report table
                    echo "<h3 class='text-center display-6 heading'>Invoice Report for $start_date to $end_date</h3>";
                    echo "<div class='table-responsive-sm'>";
                    echo "<table class='table table-borderless table-dark' >";
                    echo "<tr><th scope='col'>Invoice Number</th><th scope='col'>Current Date</th><th scope='col'>Invoiced Date</th><th scope='col'>Customer</th><th scope='col'>Customer District</th><th scope='col'>Item Count</th><th scope='col'>Amount</th></tr>";

                    // Loop through the rows and display the invoice data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["invoice_no"] . "</td>";
                        echo "<td>" . $currentDate . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</td>";
                        echo "<td>" . $row["district"] . "</td>";
                        echo "<td>" . $row["item_count"] . "</td>";
                        echo "<td>" . $row["amount"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    // If no rows were returned display a message
                    echo "No invoices found.";
                }
            }
            // Close the statement and connection
            $stmt->close();
            $mysqli->close();

        }
        ?>
    </form>
</div>
<script>
    function validateInvoiceReport() {
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;

        // Check if both start date and end date are selected
        if (startDate === "" || endDate === "") {
            alert("Please select both start and end dates.");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
<script>
    $(function(){
        $('#datepicker').datepicker();
    });
</script>
</body>
</html>

