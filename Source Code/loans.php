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

  <!-- loans.php content starts here -->
  <h1>Loans Update Page</h1>

  <?php
  // Include the database connection file
  $servername = "localhost";
  $username = "u96kbujupxtov";
  $password = "cujxib-6nurfY-zetcib";
  $dbname = "dbw3ghaodzjq1g";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Retrieve the loans data from the database
  $sql = "SELECT * FROM loans";
  $result = mysqli_query($conn, $sql);

  // Fetch all the books from the database
  $sql_books = "SELECT * FROM books";
  $result_books = mysqli_query($conn, $sql_books);

  // Fetch all the members from the database
  $sql_members = "SELECT * FROM members";
  $result_members = mysqli_query($conn, $sql_members);

  // // Close the connection
  // mysqli_close($conn);
  ?>

  <div class="container">
    <div class="table-wrapper">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Member ID</th>
                    <th>Book ID</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['member_id']; ?></td>
                        <td><?php echo $row['book_id']; ?></td>
                        <td><?php echo $row['issue_date']; ?></td>
                        <td><?php echo $row['due_date']; ?></td>
                        <td><?php echo $row['return_date']; ?></td>
                        <td>
                          <a href="edit_loan.php?loan_id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                          <a href="delete_loan.php?loan_id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
</div>
<br>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the required form fields are not empty
  if (!empty($_POST['member_id']) && !empty($_POST['book_id']) && !empty($_POST['issue_date']) && !empty($_POST['due_date'])) {
    // Get the submitted form data
    $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $issue_date = mysqli_real_escape_string($conn, $_POST['issue_date']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $return_date = mysqli_real_escape_string($conn, $_POST['return_date']);

    // Check if the return_date field is empty, and if so, set it to NULL
    if (empty($return_date)) {
        $return_date = "NULL";
    } else {
        $return_date = "'$return_date'";
    }

    // Insert the new loan into the database
    $sql = "INSERT INTO loans (member_id, book_id, issue_date, due_date, return_date) VALUES ('$member_id', '$book_id', '$issue_date', '$due_date', $return_date)";
    if (mysqli_query($conn, $sql)) {
        echo "New loan added successfully!<br>";
        header("Location: loans.php?ts=" . time());

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  } else {
    echo "Please fill in all required fields.";
  }
}
// Close the connection
mysqli_close($conn);
?>



<h2>Add New Loan</h2>
<form action="loans.php" method="post" onsubmit="return validateForm();">
  <div class="mb-3">
    <label for="member_id" class="form-label">Member ID:</label>
    <select class="form-control" id="member_id" name="member_id" required>
      <?php while ($row_members = mysqli_fetch_assoc($result_members)): ?>
        <option value="<?php echo $row_members['id']; ?>"><?php echo $row_members['id']; ?> - <?php echo $row_members['name']; ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="mb-3">
    <label for="book_id" class="form-label">Book ID:</label>
    <select class="form-control" id="book_id" name="book_id" required>
      <?php while ($row_books = mysqli_fetch_assoc($result_books)): ?>
        <option value="<?php echo $row_books['id']; ?>"><?php echo $row_books['id']; ?> - <?php echo $row_books['title']; ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="mb-3">
    <label for="issue_date" class="form-label">Issue Date:</label>
    <input type="date" class="form-control" id="issue_date" name="issue_date" required>
  </div>
  <div class="mb-3">
    <label for="due_date" class="form-label">Due Date:</label>
    <input type="date" class="form-control" id="due_date" name="due_date" required>
  </div>
  <div class="mb-3">
    <label for="return_date" class="form-label">Return Date (optional):</label>
    <input type="date" class="form-control" id="return_date" name="return_date">
  </div>
  <button type="submit" class="btn btn-primary">Add Loan</button>
</form>

</div>
</body>
<script>
  function confirmDelete(loan_id) {
    if (confirm("Are you sure you want to delete this loan with ID: " + loan_id + "?")) {
      window.location.href = "delete_loan.php?loan_id=" + loan_id;
    }
  }

  function validateForm() {
    const member_id = document.getElementById('member_id').value;
    const book_id = document.getElementById('book_id').value;
    const issue_date = document.getElementById('issue_date').value;
    const due_date = document.getElementById('due_date').value;

    if (!member_id || !book_id || !issue_date || !due_date) {
      alert('Please fill in all required fields.');
      return false;
    }
    return true;
  }

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</html>
