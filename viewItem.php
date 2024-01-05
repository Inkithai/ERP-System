<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View items list</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
</head>

<body>
        <?php include "sidebar.php"; ?>

    <div class="container my-5">
        <h2>List of Items</h2>
        
        <br>
        <table class="table">
            <!-- Table content goes here -->
            <thead>
                <th>ID</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Item Category</th>
                <th>Item Subcategory</th>
                <th>Quantity</th>
                <th>Unit Price</th>                
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "ERP";

                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all rows from the database table
                $sql = "SELECT * FROM item";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid Query: " . $connection->error);
                }

                // Read data of each row and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['item_code'] . "</td>";
                    echo "<td>" . $row['item_name'] . "</td>";
                    echo "<td>" . $row['item_category'] . "</td>";
                    echo "<td>" . $row['item_subcategory'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['unit_price'] . "</td>";
                    echo "<td>
                            <a class='btn btn-sm btn-success' href='editItem.php?id=$row[id]' >EDIT</a>
                          </td>";
                    echo "</tr>";
                }

                $connection->close();
                ?>
            </tbody>
        </table>
        <br>
        <br>
        
    </div>


    

    <!-- Required scripts for Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>