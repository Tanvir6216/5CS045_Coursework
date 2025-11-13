<?php
  // Connect to database and run SQL query
  include("db.php");

  // Read value from form
  $keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';

  //  If no keyword entered, show ALL books
  if ($keywords == '') {
    $sql = "SELECT * FROM books ORDER BY Published_date DESC";
  } else {
    //  Otherwise, search by keyword (genre, title, author, etc.)
    $sql = "SELECT * FROM books 
            WHERE Title LIKE '%{$keywords}%' 
            OR Author LIKE '%{$keywords}%'
            OR Genre LIKE '%{$keywords}%'
            OR Description LIKE '%{$keywords}%'
            OR Actions LIKE '%{$keywords}%'
            ORDER BY Published_date DESC";
  }

  $results = mysqli_query($conn, $sql);
?>

<!-- Added link for Add New Book -->
<a href="add-books.php" class="btn btn-success mb-3">+ Add New Book</a>

<!-- Search form (same as before) -->
<form method="POST" class="mb-3">
  <input type="text" name="keywords" placeholder="Search by title, author, or genre..." 
         class="form-control mb-2" value="<?= htmlspecialchars($keywords) ?>">
  <button type="submit" class="btn btn-primary">Search</button>
</form>

<table class="book-table"> 
  <tr>
    <th>Book Title</th>
  </tr>

  <?php while($a_row = mysqli_fetch_assoc($results)): ?>
    <tr>
      <td><a href="view-books.php?isbn=<?= $a_row['ISBN'] ?>"><?= $a_row['Title'] ?></a></td>
    </tr>
  <?php endwhile; ?>
</table>
