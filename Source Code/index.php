
** Final Version 1.0 For Submission -7th May 2023 **

<!DOCTYPE html>
<html>
<head>
  <title>powpage</title>
  <h1>Pow Library Management System</h1>
  <style>
    /* Add CSS style block */

    table {
      border: 1px solid black;
    }
    td, th {
      border: 1px solid black;
      padding: 5px;
    }

    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
    }

    li {
      float: left;
    }

    li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    li a:hover {
      background-color: #111;
    }
   
  </style>
</head>
<body>
  <!-- Add this navigation menu right after the body tag -->
  
  <ul>
    <li><a href="index.php">Books</a></li>
    <li><a href="authors.php">Authors</a></li>
    <li><a href="publishers.php">Publishers</a></li>
    <li><a href="categories.php">Categories</a></li>
    <li><a href="members.php">Members</a></li>
    <li><a href="loans.php">Loans</a></li>
    <li><a href="reservations.php">Reservations</a></li>
    <li><a href="penalties.php">Penalties</a></li>
    <li><a href="display_book_view.php">Display Books View</a></li>
    <li><a href="display_loans_view.php">Display Loans View</a></li>
  </ul>
 
  
<h1>Books Update Page</h1>


<?php
// establish connection to MySQL database
$servername = "localhost";
$username = "u96kbujupxtov";
$password = "cujxib-6nurfY-zetcib";
$dbname = "dbw3ghaodzjq1g";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// check if connection was successful
if (!$conn) {
    die("Connection failed Pow: " . mysqli_connect_error());
}


// check if form was submitted
if(isset($_POST['submit'])) {
    // get form data
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $publisher_id = $_POST['publisher_id'];
    $publication_year = $_POST['publication_year'];
    $category_id = $_POST['category_id'];
    $isbn = $_POST['isbn'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];
    
    // insert new book into 'books' table
    $sql = "INSERT INTO books (title, author_id, publisher_id, publication_year, category_id, isbn, total_copies, available_copies) VALUES ('$title', $author_id, $publisher_id, $publication_year, $category_id, '$isbn', $total_copies, $available_copies)";// insert new book into 'books' table
    
    if(mysqli_query($conn, $sql)) {
        echo "<p>Book added to the database successfully.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// retrieve all books from the 'books' table
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);

// check if any books were found
if (mysqli_num_rows($result) > 0) {
    // display all the books in a table
    echo "<table>";
    echo "<tr><th>Title</th><th>Author</th><th>Publisher</th><th>Year</th><th>Category</th><th>ISBN</th><th>Total Copies</th><th>Available Copies</th><th>Actions</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        // retrieve the author's name
        $author_sql = "SELECT name FROM authors WHERE id = " . $row["author_id"];
        $author_result = mysqli_query($conn, $author_sql);
        $author_row = mysqli_fetch_assoc($author_result);
        $author_name = $author_row["name"];
        
        // retrieve the publisher's name
        $publisher_sql = "SELECT name FROM publishers WHERE id = " . $row["publisher_id"];
        $publisher_result = mysqli_query($conn, $publisher_sql);
        $publisher_row = mysqli_fetch_assoc($publisher_result);
        $publisher_name = $publisher_row["name"];
        
        // retrieve the category's name
        $category_sql = "SELECT name FROM categories WHERE id = " . $row["category_id"];
        $category_result = mysqli_query($conn, $category_sql);
    $category_row = mysqli_fetch_assoc($category_result);
    $category_name = $category_row["name"];
    
    // display the book information
    echo "<tr>";
    echo "<td>" . $row["title"] . "</td>";
    echo "<td>" . $author_name . "</td>";
    echo "<td>" . $publisher_name . "</td>";
    echo "<td>" . $row["publication_year"] . "</td>";
    echo "<td>" . $category_name . "</td>";
    echo "<td>" . $row["isbn"] . "</td>";
    echo "<td>" . $row["total_copies"] . "</td>";
    echo "<td>" . $row["available_copies"] . "</td>";
    echo "<td><a href='edit.php?id=" . $row["id"] . "'><button>Edit</button></a> <a href='delete.php?id=" . $row["id"] . "'><button>Delete</button></a></td>";
    echo "</tr>";
}
echo "</table>";
} else {
echo "No books found.";
}
mysqli_close($conn);
?>

<!-- add book form -->
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h2>Add Book</h2>
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="form-control">
    </div>
    <div class="form-group">
        <label for="author_id">Author:</label>
        <select id="author_id" name="author_id" class="form-control">
            <?php
                // retrieve all authors from the 'authors' table
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                $sql = "SELECT * FROM authors";
                $result = mysqli_query($conn, $sql);
                            // check if any authors were found
            if (mysqli_num_rows($result) > 0) {
                // display each author as an option in the dropdown menu
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            } else {
                echo "<option>No authors found.</option>";
            }
            mysqli_close($conn);
        ?>
    </select>
</div>

<div class="form-group">
    <label for="publisher_id">Publisher:</label>
    <select id="publisher_id" name="publisher_id" class="form-control">
        <?php
            // retrieve all publishers from the 'publishers' table
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM publishers";
            $result = mysqli_query($conn, $sql);
            
            // check if any publishers were found
            if (mysqli_num_rows($result) > 0) {
                // display each publisher as an option in the dropdown menu
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            } else {
                echo "<option>No publishers found.</option>";
            }
            mysqli_close($conn);
        ?>
    </select>
</div>
<div class="form-group">
    <label for="publication_year">Publication Year:</label>
    <input type="text" id="publication_year" name="publication_year" class="form-control">
</div>
<div class="form-group">
    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id" class="form-control">
       
    <?php
            // retrieve all categories from the 'categories' table
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $sql);
            
            // check if any categories were found
            if (mysqli_num_rows($result) > 0) {
                // display each category as an option in the dropdown menu
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            } else {
                echo "<option>No categories found.</option>";
            }
            mysqli_close($conn);
    ?>
    </select>
</div>

<div class="form-group">
    <label for="isbn">ISBN (13-Digit):</label>
    <input type="text" id="isbn" name="isbn" class="form-control">
</div>
<div class="form-group">
    <label for="total_copies">Total Copies:</label>
    <input type="text" id="total_copies" name="total_copies" class="form-control">
</div>
<div class="form-group">
    <label for="available_copies">Available Copies:</label>
    <input type="text" id="available_copies" name="available_copies" class="form-control">
</div>
<button type="submit" class="btn btn-primary" name="submit">Add Book</button>
</form>

<script>
  if (performance.navigation.type === performance.navigation.TYPE_BACK_FORWARD) {
    location.reload();
  }
</script>

</body>
</html>
