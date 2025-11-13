<?php
  // Connect to database and run SQL query
  include("db.php");

  // Read value from form
  $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
  $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
  $year = isset($_POST['year']) ? $_POST['year'] : '';
  $max_price = isset($_POST['max_price']) ? $_POST['max_price'] : '';

  // Run SQL query 
  $sql = "SELECT * FROM books WHERE 1=1";

  if (!empty($keywords)) {
      $sql .= " AND (Title LIKE '%{$keywords}%' 
                OR Author LIKE '%{$keywords}%'
                OR Description LIKE '%{$keywords}%'
                OR Actions LIKE '%{$keywords}%')";
  }

  if (!empty($genre)) {
      $sql .= " AND Genre LIKE '%{$genre}%'";
  }

  if (!empty($year)) {
      $sql .= " AND YEAR(Published_date) = '{$year}'";
  }

  if (!empty($max_price)) {
      $sql .= " AND Price <= {$max_price}";
  }

  $sql .= " ORDER BY Published_date DESC";

  $results = mysqli_query($conn, $sql);
?>

<!-- Added link for Add New Book -->
<a href="add-books.php" class="btn btn-success mb-3">+ Add New Book</a>

<!-- Add simple form for multiple criteria -->
<form method="post" class="mb-3">
  <input type="text" name="keywords" placeholder="Search title/author..." value="<?= htmlspecialchars($keywords) ?>">
  <input type="text" name="genre" placeholder="Genre (e.g. sci-fi)" value="<?= htmlspecialchars($genre) ?>">
  <input type="number" name="year" placeholder="Year (e.g. 2023)" value="<?= htmlspecialchars($year) ?>">
  <input type="number" step="0.01" name="max_price" placeholder="Max Price (£)" value="<?= htmlspecialchars($max_price) ?>">
  <button type="submit" class="btn btn-primary btn-sm">Search</button>
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
