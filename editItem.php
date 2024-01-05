<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Update Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
</head>

<body>
      <?php include "sidebar.php"; ?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ERP";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getCategories($conn)
{
    $sql = "SELECT * FROM item_category";
    $result = $conn->query($sql);
    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[$row["id"]] = $row["category"];
    }
    return $categories;
}

function getSubCategories($conn)
{
    $sql = "SELECT * FROM item_subcategory";
    $result = $conn->query($sql);
    $subcategories = array();
    while ($row = $result->fetch_assoc()) {
        $subcategories[$row["id"]] = $row["sub_category"];
    }
    return $subcategories;
}

$categories = getCategories($conn);
$subcategories = getSubCategories($conn);

if (isset($_POST["update_item_submit"])) {

    $item_id = $_POST["item_id"];
    $item_code = $_POST["item_code"];
    $item_name = $_POST["item_name"];
    $item_category = $_POST["item_category"];
    $item_subcategory = $_POST["item_subcategory"];
    $quantity = $_POST["quantity"];
    $unit_price = $_POST["unit_price"];

    // query of update the item data
    $sql = "UPDATE item 
            SET item_code = '$item_code', 
                item_name = '$item_name', 
                item_category = '$item_category', 
                item_subcategory = '$item_subcategory', 
                quantity = '$quantity', 
                unit_price = '$unit_price' 
            WHERE id = '$item_id'";

    if ($conn->query($sql) === true) {
        echo "<p class='text-success text-center'>Item updated successfully!</p>";
        header("Location: item.php");
        exit();
    } else {
        echo "<p class='text-danger text-center'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

if (isset($_GET["id"])) {
    $item_id = $_GET["id"];
    $sql = "SELECT * FROM item WHERE id = '$item_id'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $item_id = $row["id"];
        $item_code = $row["item_code"];
        $item_name = $row["item_name"];
        $item_category_id = $row["item_category"];
        $item_subcategory_id = $row["item_subcategory"];
        $quantity = $row["quantity"];
        $unit_price = $row["unit_price"];
    } else {
        echo "<p class='text-danger text-center'>Item not found.</p>";
        exit(); 
    }
} else {
    echo "<p class='text-danger text-center'>Invalid request.</p>";
    exit(); 
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Update Item</h1>
            <form action="update_item.php" method="POST">
                <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
              
                <div class="mb-3">
                    <label for="item_code" class="form-label">Item Code:</label>
                    <input type="text" class="form-control" name="item_code" value="<?php echo $item_code; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="item_name" class="form-label">Item Name:</label>
                    <input type="text" class="form-control" name="item_name" value="<?php echo $item_name; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="item_category" class="form-label">Category:</label>
                    <select class="form-control" name="item_category" required>
                        <?php
                        foreach ($categories as $id => $category) {
                            $selected = ($item_category_id == $id) ? 'selected' : '';
                            echo "<option value='$id' $selected>$category</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="item_subcategory" class="form-label">Subcategory:</label>
                    <select class="form-control" name="item_subcategory" required>
                        <?php
                        foreach ($subcategories as $id => $subcategory) {
                            $selected = ($item_subcategory_id == $id) ? 'selected' : '';
                            echo "<option value='$id' $selected>$subcategory</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="text" class="form-control" name="quantity" value="<?php echo $quantity; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="unit_price" class="form-label">Unit Price:</label>
                    <input type="text" class="form-control" name="unit_price" value="<?php echo $unit_price; ?>" required>
                </div>
                <button type="submit" class="btn btn-success" name="update_item_submit">Update Item</button>
                <a class="btn btn-secondary" href="viewItem.php" role="button" style="font-size: 20px;">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
