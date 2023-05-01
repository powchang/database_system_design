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

  <!-- reservations.php content starts here -->
  <h1>Reservations Update</h1>

  <?php
  // Include the database connection file
  $servername = "localhost";
  $username = "u96kbujupxtov";
  $password = "cujxib-6nurfY-zetcib";
  $dbname = "dbw3ghaodzjq1g";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  /// Retrieve the reservations data from the database
$sql = "SELECT * FROM reservations";
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
                  <th>Reserve Date</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['member_id']; ?></td>
                      <td><?php echo $row['book_id']; ?></td>
                      <td><?php echo $row['reserve_date']; ?></td>
                      <td>
                        <a href="edit_reservation.php?reservation_id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_reservation.php?reservation_id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
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
    if (!empty($_POST['member_id']) && !empty($_POST['book_id']) && !empty($_POST['reserve_date'])) {
      // Get the submitted form data
      $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
      $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
      $reserve_date = mysqli_real_escape_string($conn, $_POST['reserve_date']);

      // Insert the new reservation into the database
      $sql = "INSERT INTO reservations (member_id, book_id, reserve_date) VALUES ('$member_id', '$book_id', '$reserve_date')";
      if (mysqli_query($conn, $sql)) {
          echo "New reservation added successfully!<br>";
          header("Location: reservations.php?ts=" . time());

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

  <h2>Add New Reservation</h2>
<form action="reservations.php" method="post" onsubmit="return validateForm();">
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
    <label for="reserve_date" class="form-label">Reserve Date:</label>
    <input type="date" class="form-control" id="reserve_date" name="reserve_date" required>
  </div>
  
  <button type="submit" class="btn btn-primary">Add Reservation</button>
</form>
</div>
</body>
<script>
  function confirmDelete(reservation_id) {
    if (confirm("Are you sure you want to delete this reservation with ID: " + reservation_id + "?")) {
      window.location.href = "delete_reservation.php?reservation_id=" + reservation_id;
    }
  }
  function validateForm() {
  const member_id = document.getElementById('member_id').value;
  const book_id = document.getElementById('book_id').value;
  const reserve_date = document.getElementById('reserve_date').value;

  if (!member_id || !book_id || !reserve_date) {
    alert('Please fill in all required fields.');
    return false;
  }

  const today = new Date();
  const selectedDate = new Date(reserve_date);

  if (selectedDate < today) {
    alert('Please select a date that is not in the past.');
    return false;
  }

  const maxDate = new Date();
  maxDate.setDate(today.getDate() + 7);

  if (selectedDate > maxDate) {
    alert('You can only reserve a book up to 7 days in advance.');
    return false;
  }

  return true;
}

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</html>


