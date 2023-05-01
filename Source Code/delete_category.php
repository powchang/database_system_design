<<?php
// database connection
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// check if 'id' parameter exists
if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);

    // retrieve category name
    $sql = "SELECT name FROM categories WHERE id = $category_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $category_name = $row['name'];

    if (isset($_POST['confirm'])) {
        if ($_POST['confirm'] == 'yes') {
            $sql = "DELETE FROM categories WHERE id = $category_id";
            if (mysqli_query($conn, $sql)) {
                echo "Category deleted successfully.<br>";
                echo "<a href='categories.php?ts=" . time() . "' class='btn btn-secondary'>Go back to categories page</a>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            header("Location: categories.php?ts=" . time());
        }
    } else {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <title>Delete Category</title>
          <style>
            .btn {
              padding: 8px 12px;
              cursor: pointer;
              color: #fff;
              border: none;
              background-color: #007bff;
              text-decoration: none;
              font-size: 16px;
            }

            .btn-secondary {
              background-color: #6c757d;
            }
          </style>
        </head>
        <body>
          <h1>Delete Category</h1>
          <p>Are you sure you want to delete the category '<?php echo $category_name; ?>'?</p>
          <form method="post">
            <input type="hidden" name="id" value="<?php echo $category_id; ?>">
            <button type="submit" name="confirm" value="yes" class="btn btn-danger">Yes, delete category</button>
            <a href="categories.php?ts=<?php echo time(); ?>" class="btn btn-secondary">No, go back to categories page</a>
          </form>
        </body>
        </html>
        <?php
    }
} else {
    echo "Invalid ID.";
    echo "<a href='categories.php?ts=" . time() . "' class='btn btn-secondary'>Go back to categories page</a>";
}

mysqli_close($conn);
?>
