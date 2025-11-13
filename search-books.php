<?php
  // Connect to database and run SQL query
  include("db.php");

  // Read value from form
  $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';

  // Run SQL query 
  $sql = "SELECT * FROM books 
          WHERE Title LIKE '%{$keywords}%' 
          OR Author LIKE '%{$keywords}%'
          OR Genre LIKE '%{$keywords}%'
          OR Description LIKE '%{$keywords}%'
          OR Actions LIKE '%{$keywords}%'
          ORDER BY Published_date DESC";
          
  $results = mysqli_query($conn, $sql);
?>

<!-- Added link for Add New Book -->
<a href="add-books.php" class="btn btn-success mb-3">+ Add New Book</a>

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

