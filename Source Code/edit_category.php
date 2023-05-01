<!DOCTYPE html>
<html>
<head>
    <h1>Edit Category</h1>
</head>
<body>

<?php
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Check if an ID was passed to the script
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Retrieve the category data from the database
$category = null;
if ($id > 0) {
    $sql = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
    }
}

// Check if the form was submitted and the ID is valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && $id > 0) {
    // Get the updated category name
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Update the category in the database
    $sql = "UPDATE categories SET name='$name' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "Category updated successfully.<br>";
        echo "<a href='categories.php?ts=" . time() . "' class='btn btn-secondary'>Go back to categories page</a>";
    } else {
        $error_code = mysqli_errno($conn);
        if ($error_code == 1062) { // 1062 is the error code for duplicate entry
            echo "Error: The category name already exists.<br>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        echo "<a href='categories.php?ts=" . time() . "' class='btn btn-secondary'>Go back to categories page</a>";
    }
} elseif ($id <= 0) {
    echo "Invalid ID.";
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Category</h1>
        <?php if ($category): ?>
            <form action="edit_category.php?id=<?php echo $id; ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
