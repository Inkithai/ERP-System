<?php
global $mysqli;
include "Connection.php";
?>

<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <title>Invoice Item Report</title>
</head>
<body>
<div class="container border rounded-3 bg-img">
    <?php include "sidebar.php"; ?>
    <div class="invoice-report">
        <h2 class="text-center display-6 heading">Invoice Item Report</h2>
        <form class="row p-auto m-auto text-center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
              onsubmit="return validateInvoiceItemReport()">
            <div class="col-md-6 m-auto">
                <label for="startDate">Start Date:</label>
                <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="date" id="startDate" name="startDate" required><br><br>
            </div>
            <div class="col-md-6 m-auto">
                <label for="endDate">End Date:</label>
                <input class="form-control shadow-sm p-2 mb-2 bg-white rounded" type="date" id="endDate" name="endDate" required><br><br>
            </div>
            <div>
            <button type="submit" class="btn btn-success mb-4" style="width: 150px;">Generate Report</button>
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $start_date = $_POST["startDate"];
                $end_date = $_POST["endDate"];

                if (empty($start_date) || empty($end_date)) {
                    $errorMessage = "Please select both start and end dates.";
                } else {
                    $sql = "SELECT i.invoice_no, i.date AS invoiced_date, c.first_name, c.middle_name ,c.last_name, 
                it.item_name, it.item_code, ic.category, it.unit_price
                FROM invoice AS i
                JOIN customer AS c ON i.id = c.id
                JOIN item AS it ON c.id = it.id
                JOIN item_category AS ic ON it.item_category = ic.id
                WHERE i.date BETWEEN ? AND ?";

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("ss", $start_date, $end_date);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<h3 class='text-center display-6 heading'>Invoice Item Report for $start_date to $end_date</h3>";
                        echo "<div class='table-responsive-sm'>";
                        echo "<table class='table table-borderless table-dark'>";
                        echo "<tr><th scope='col'>Invoice Number</th><th scope='col'>Invoiced Date</th><th scope='col'>Customer Name</th><th scope='col'>Item Code and Name</th><th scope='col'>Item Category</th><th scope='col'>Item Unit Price</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["invoice_no"] . "</td>";
                            echo "<td>" . $row["invoiced_date"] . "</td>";
                            echo "<td>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</td>";
                            echo "<td>" . $row["item_code"] . " " . $row["item_name"] . "</td>";
                            echo "<td>" . $row["category"] . "</td>";
                            echo "<td>" . $row["unit_price"] . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "No invoice items found for the selected date range.";
                    }

                    $stmt->close();
                    $mysqli->close();
                }
            }
            ?>
        </form>
    </div>
</div>
<script>
    function validateInvoiceItemReport() {
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;

        if (startDate === "" || endDate === "") {
            alert("Please select both start and end dates.");
            return false;
        }

        return true;
    }
</script>
</body>
</html>
