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

  <!-- penalties.php content starts here -->
  <h1>Penalties Update Page</h1>

  <?php
  // Include the database connection file
  $servername = "localhost";
  $username = "u96kbujupxtov";
  $password = "cujxib-6nurfY-zetcib";
  $dbname = "dbw3ghaodzjq1g";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Retrieve the penalties data from the database
  $sql = "SELECT * FROM penalties";
  $result = mysqli_query($conn, $sql);

  // Fetch all the loans from the database
  $sql_loans = "SELECT * FROM loans";
  $result_loans = mysqli_query($conn, $sql_loans);

  // Check if the form has been submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required form fields are not empty
    if (!empty($_POST['loan_id']) && !empty($_POST['penalty_amount'])) {
      // Get the submitted form data
      $loan_id = mysqli_real_escape_string($conn, $_POST['loan_id']);
      $penalty_amount = mysqli_real_escape_string($conn, $_POST['penalty_amount']);
      $paid = isset($_POST['paid']) ? 1 : 0;

      // Insert the new penalty into the database
      $sql = "INSERT INTO penalties (loan_id, penalty_amount, paid) VALUES ('$loan_id', '$penalty_amount', '$paid')";
      if (mysqli_query($conn, $sql)) {
          echo "New penalty added successfully!<br>";
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    } else {
      echo "Please fill in all required fields";
}
}

// Retrieve the penalties data from the database
$sql = "SELECT * FROM penalties";
$result = mysqli_query($conn, $sql);

// Fetch all the loans from the database
$sql_loans = "SELECT * FROM loans";
$result_loans = mysqli_query($conn, $sql_loans);

// Close the connection
mysqli_close($conn);
?>
<div class="container">
  <div class="table-wrapper">
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Loan ID</th>
                  <th>Penalty Amount</th>
                  <th>Paid</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['loan_id']; ?></td>
                      <td><?php echo $row['penalty_amount']; ?></td>
                      <td><?php echo $row['paid']; ?></td>
                      <td>
                        <a href="edit_penalty.php?penalty_id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>                           
                        <a href="delete_penalty.php?penalty_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirmDelete('<?php echo $row['id']; ?>')">Delete</a>
                      </td>
                      </tr>
              <?php endwhile; ?>
              </tbody>
          </table>
  </div>
  <br>
  <h2>Add New Penalty</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
          <label for="loan_id">Loan ID:</label>
          <select class="form-control" id="loan_id" name="loan_id">
              <?php while ($loan = mysqli_fetch_assoc($result_loans)) : ?>
                  <option value="<?php echo $loan['id']; ?>"><?php echo $loan['id']; ?></option>
              <?php endwhile; ?>
          </select>
      </div>
      <div class="form-group">
          <label for="penalty_amount">Penalty Amount:</label>
          <input type="text" class="form-control" id="penalty_amount" name="penalty_amount" required>
      </div>
      <div class="form-group">
          <label for="paid">Paid:</label>
          <select class="form-control" id="paid" name="paid" required>
              <option value="1">Yes</option>
              <option value="0">No</option>
          </select>
      </div>
      <button type="submit" class="btn btn-primary">Add Penalty</button>
  </form>
</div>
<script>
  function confirmDelete(penalty_id) {
      if (confirm("Are you sure you want to delete this penalty with ID: " + penalty_id + "?")) {
          window.location.href = "delete_penalty.php?penalty_id=" + penalty_id;
      }
  }
</script>
</body>
</html>

