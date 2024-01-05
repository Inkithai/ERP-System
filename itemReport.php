<?php
global $mysqli;
include "Connection.php"; ?>

<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <title>Item Report</title>
</head>
<body>
<div class="container border rounded-3 bg-img">
    <?php include "sidebar.php"; ?>
    <div class="item-report">
        <h2 class="text-center display-6 heading">Item Report</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="text-center">
  <button type="submit" class="btn btn-sm btn-success mb-4" style="width: 150px;">Generate Report</button>
</div>
            <?php
            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // SQL query to retrieve the item details for the report
                $sql = "SELECT i.item_name, ic.category, isc.sub_category, SUM(quantity) AS total_quantity
                FROM item AS i
                JOIN item_category AS ic ON i.id = ic.id
                JOIN item_subcategory AS isc ON i.id = isc.id
                GROUP BY i.item_name, ic.category, isc.sub_category;";

                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='table-responsive-sm'>";
                    echo "<table class='table table-dark' >";
                    echo "<tr><th scope='col'>Item Name</th><th scope='col'>Item Category</th><th scope='col'>Item Subcategory</th><th scope='col'>Item Quantity</th></tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["item_name"] . "</td>";
                        echo "<td>" . $row["category"] . "</td>";
                        echo "<td>" . $row["sub_category"] . "</td>";
                        echo "<td>" . $row["total_quantity"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "No items found in the database.";
                }

                $mysqli->close();
            }
            ?>
        </form>
    </div>
</div>
</body>
</html>

<?php
global $mysqli;
include "Connection.php"; ?>
