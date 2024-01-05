<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP-System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>

<body>
        <?php include "sidebar.php"; ?>

    <div class="container my-5">
        <h2>List of Customers</h2>
        
        <br>
        <table class="table">
            <!-- Table content goes here -->
            <thead>
                <th>ID</th>
                <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact number</th>
                <th>District</th>
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
                $sql = "SELECT * FROM customer";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid Query: " . $connection->error);
                }

                // Read data of each row and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['contact_no'] . "</td>";
                    echo "<td>" . $row['district'] . "</td>";
                    echo "<td>
                            <a class='btn btn-sm btn-success' href='editCustomer.php?id=$row[id]' >EDIT</a>
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