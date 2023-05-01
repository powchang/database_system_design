<!DOCTYPE html>
<html>
<head>
  <title>Edit Book</title>
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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Book not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $publisher_id = $_POST['publisher_id'];
    $publication_year = $_POST['publication_year'];
    $category_id = $_POST['category_id'];
    $isbn = $_POST['isbn'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];

    $sql = "UPDATE books SET title = '$title', author_id = $author_id, publisher_id = $publisher_id, publication_year = $publication_year, category_id = $category_id, isbn = '$isbn', total_copies = $total_copies, available_copies = $available_copies WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<p>Book updated successfully.</p>";
        echo '<a href="index.php?ts=' . time() . '">Go back to main page</a>'; // Add a unique timestamp parameter
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . $id; ?>">
    <h2>Edit Book</h2>
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control" value="<?php echo $row['title']; ?>">
    </div>
    <div class="form-group">
        <label for="author_id">Author:</label>
        <select id="author_id" name="author_id" class="form-control">
            <?php
                $sql = "SELECT * FROM authors";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while($author_row = mysqli_fetch_assoc($result)) {
                        $selected = ($author_row["id"] == $row["author_id"]) ? "selected" : "";
                        echo "<option value='" . $author_row["id"] . "' " . $selected . ">" . $author_row["name"] . "</option>";
                    }
                } else {
                    echo "<option>No authors found.</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="publisher_id">Publisher:</label>
        <select id="publisher_id" name="publisher_id" class="form-control">
            <?php
                $sql = "SELECT * FROM publishers";
                $result = mysqli_query($conn, $sql);
                
            if (mysqli_num_rows($result) > 0) {
                while($publisher_row = mysqli_fetch_assoc($result)) {
                    $selected = ($publisher_row["id"] == $row["publisher_id"]) ? "selected" : "";
                    echo "<option value='" . $publisher_row["id"] . "' " . $selected . ">" . $publisher_row["name"] . "</option>";
                }
            } else {
                echo "<option>No publishers found.</option>";
            }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="publication_year">Publication Year:</label>
    <input type="number" id="publication_year" name="publication_year" class="form-control" value="<?php echo $row['publication_year']; ?>">
</div>
<div class="form-group">
    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id" class="form-control">
        <?php
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($category_row = mysqli_fetch_assoc($result)) {
                    $selected = ($category_row["id"] == $row["category_id"]) ? "selected" : "";
                    echo "<option value='" . $category_row["id"] . "' " . $selected . ">" . $category_row["name"] . "</option>";
                }
            } else {
                echo "<option>No categories found.</option>";
            }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="isbn">ISBN:</label>
    <input type="text" id="isbn" name="isbn" class="form-control" value="<?php echo $row['isbn']; ?>">
</div>
<div class="form-group">
    <label for="total_copies">Total Copies:</label>
    <input type="number" id="total_copies" name="total_copies" class="form-control" value="<?php echo $row['total_copies']; ?>">
</div>
<div class="form-group">
    <label for="available_copies">Available Copies:</label>
    <input type="number" id="available_copies" name="available_copies" class="form-control" value="<?php echo $row['available_copies']; ?>">
</div>
<button type="submit" class="btn btn-primary" name="submit">Update Book</button>
</form>
<?php
mysqli_close($conn);
?>
</body>
</html>