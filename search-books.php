<?php
  // Connect to database and run SQL query
  include("db.php");

  // Read values from form (we’ll add genre and year support)
  $keywords = isset($_POST['keywords']) ? $_POST['keywords'] : '';
  $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
  $year = isset($_POST['year']) ? $_POST['year'] : '';

  // Build SQL query dynamically
  $sql = "SELECT * FROM books WHERE 1=1";

  if (!empty($keywords)) {
    $sql .= " AND (Title LIKE '%{$keywords}%' 
              OR Author LIKE '%{$keywords}%'
              OR Description LIKE '%{$keywords}%')";
  }

  if (!empty($genre)) {
    $sql .= " AND Genre LIKE '%{$genre}%'";
  }

  if (!empty($year)) {
    $sql .= " AND YEAR(Published_date) = '{$year}'";
  }

  $sql .= " ORDER BY Published_date DESC";

  $results = mysqli_query($conn, $sql);
?>

<!-- Added link for Add New Book -->
<a href="add-books.php" class="btn btn-success mb-3">+ Add New Book</a>

<!-- ✅ Add extra search inputs -->
<form method="post" class="mb-3">
  <input type="text" name="keywords" placeholder="Search title/author..." value="<?= htmlspecialchars($keywords) ?>">
  <input type="text" name="genre" placeholder="Genre" value="<?= htmlspecialchars($genre) ?>">
  <input type="number" name="year" placeholder="Year (e.g. 2023)" value="<?= htmlspecialchars($year) ?>">
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
