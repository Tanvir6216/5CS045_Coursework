<?php
include "db.php";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ISBN = trim($_POST['ISBN']);
    $Title = trim($_POST['Title']);
    $Author = trim($_POST['Author']);
    $Genre = trim($_POST['Genre']);
    $Price = floatval($_POST['Price']);
    $Published_date = $_POST['Published_date'];
    $Description = trim($_POST['Description']);
	$Actions = trim($_POST['Actions']);


    if ($ISBN === '' || $Title === '' || $Author === '' || $Genre === '') {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO books (ISBN, Title, Author, Genre, Price, Published_date, Description, Actions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $ISBN, $Title, $Author, $Genre, $Price, $Published_date, $Description, $Actions);
        if ($stmt->execute()) {
            header("Location: search-books.php");
            exit;
        } else {
            $errors[] = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h1>Add New Book</h1>

<?php if ($errors): ?>
<div class="alert alert-danger"><?php foreach($errors as $e) echo "<div>$e</div>"; ?></div>
<?php endif; ?>

<form method="post">
  <div class="mb-3"><label>ISBN</label><input name="ISBN" class="form-control"></div>
  <div class="mb-3"><label>Title</label><input name="Title" class="form-control"></div>
  <div class="mb-3"><label>Author</label><input name="Author" class="form-control"></div>
  <div class="mb-3"><label>Genre</label><input name="Genre" class="form-control"></div>
  <div class="mb-3"><label>Price (£)</label><input name="Price" type="number" step="0.01" class="form-control"></div>
  <div class="mb-3"><label>Published Date</label><input name="Published_date" type="date" class="form-control"></div>
  <div class="mb-3"><label>Description</label><textarea name="Description" class="form-control" rows="4"></textarea></div>
  <div class="mb-3"><label>Actions</label><input name="Actions" class="form-control" rows="5"></div>
  <button class="btn btn-success" type="submit">Save</button>
  <a href="search-books.php" class="btn btn-secondary">Cancel</a>
</form>
</body>
</html>
