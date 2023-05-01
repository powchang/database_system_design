<!DOCTYPE html>
<html>
<head>
    <h1>Edit Author</h1>
</head>
<body>
    <?php
    // establish connection to MySQL database
    $servername = "localhost";
    $username = "u96kbujupxtov";
    $password = "cujxib-6nurfY-zetcib";
    $dbname = "dbw3ghaodzjq1g";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // check if connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_GET['id'])) {
        $author_id = $_GET['id'];
        $sql = "SELECT * FROM authors WHERE id = $author_id";
        $result = mysqli_query($conn, $sql);
        $author = mysqli_fetch_assoc($result);
    }

    if (isset($_POST['submit'])) {
        $author_id = $_POST['author_id'];
        $name = $_POST['name'];
        $birth_year = $_POST['birth_year'];
        $nationality = $_POST['nationality'];

        $sql = "UPDATE authors SET name = '$name', birth_year = $birth_year, nationality = '$nationality' WHERE id = $author_id";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Author updated successfully!</p>";
            echo '<a href="authors.php?ts=' . time() . '">Go back to author page</a>'; 
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
    ?>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="author_id" value="<?php echo $author['id']; ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $author['name']; ?>">
        </div>
        <div class="form-group">
            <label for="birth_year">Birth Year:</label>
            <input type="number" id="birth_year" name="birth_year" class="form-control" value="<?php echo $author['birth_year']; ?>">
        </div>
        <div class="form-group">
            <label for="nationality">Nationality:</label>
            <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo $author['nationality']; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Update Author</button>
    </form>
</body>
</html>
