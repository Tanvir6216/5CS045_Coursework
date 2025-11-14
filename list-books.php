<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>List of ALL my Books!!!</title>

  <?php
  include("db.php");
  $sql = "SELECT * FROM books ORDER BY Published_date DESC";
  $results = mysqli_query($mysqli, $sql);
  ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    #result {
      position: absolute;
      background: white;
      width: 50%;
      z-index: 1000;
      border-radius: 5px;
      max-height: 300px;
      overflow-y: auto;
      border: 1px solid #ccc;
    }
    .list-group-item:hover {
      background: #f1f1f1;
      cursor: pointer;
    }
  </style>
</head>

<body class="container py-4">
  <h1>My Books List</h1>

  <div class="position-relative" style="max-width: 50%;">
    <input id="search" class="form-control" type="text" placeholder="Search by title, author, or genre..." autocomplete="off">
    <div id="result"></div>
  </div>

  <br>

  <a href="add-books.php" class="btn btn-primary">+ Add New Book</a>

  <br><br>

  <table class="table table-bordered table-striped" id="bookTable">
    <thead class="table-dark">
      <tr>
        <th>ISBN</th>
        <th>Title</th>
        <th>Author</th>
        <th>Genre</th>
        <th>Price (£)</th>
        <th>Published Date</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="bookData">
      <?php
      if ($results && mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_assoc($results)) {
          echo "<tr>
                  <td>{$row['ISBN']}</td>
                  <td>{$row['Title']}</td>
                  <td>{$row['Author']}</td>
                  <td>{$row['Genre']}</td>
                  <td>£{$row['Price']}</td>
                  <td>{$row['Published_date']}</td>
                  <td>{$row['Description']}</td>
                  <td style='white-space: nowrap;'>
                      <a href='view-books.php?isbn={$row['ISBN']}' class='btn btn-info btn-sm me-1'>View</a>
                      <a href='edit-books.php?isbn={$row['ISBN']}' class='btn btn-warning btn-sm me-1'>Edit</a>
                      <a href='delete-books.php?isbn={$row['ISBN']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='8'>No books found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let focused = false;

// When focusing → show ALL books + suggestions
$(document).on("focus", "#search", function () {
    focused = true;

    // Show full dropdown list
    $.post("search-books.php", { search: "" }, function (data) {
        $("#result").html(data);
    });

    // Show full table list
    $.post("filter-books.php", { search: "" }, function (tableRows) {
        $("#bookData").html(tableRows);
    });
});

// Hide dropdown on outside click
$(document).on("click", function (e) {
    if (!$(e.target).closest("#search, #result").length) {
        $("#result").html("");
    }
});

// LIVE FILTERING
$(document).on("keyup", "#search", function () {
    let text = $(this).val().trim();

    // 1️⃣ Search empty + not focused → hide everything
    if (text === "" && !focused) {
        $("#bookData").html("");  // hide full table
        $("#result").html("");    // hide suggestions
        return;
    }

    // 2️⃣ Search empty + focused → show ALL books again
    if (text === "" && focused) {
        $.post("search-books.php", { search: "" }, function (data) {
            $("#result").html(data);
        });

        $.post("filter-books.php", { search: "" }, function (tableRows) {
            $("#bookData").html(tableRows);
        });

        return;
    }

    // 3️⃣ When typing → filter suggestions
    $.post("search-books.php", { search: text }, function (data) {
        $("#result").html(data);
    });

    // 4️⃣ Filter MAIN book table
    $.post("filter-books.php", { search: text }, function (tableRows) {
        $("#bookData").html(tableRows);
    });
});

// Dropdown click → fill input + filter table
$(document).on("click", ".suggestion-item", function () {
    const text = $(this).data("title");

    $("#search").val(text);
    $("#result").html("");

    $.post("filter-books.php", { search: text }, function (tableRows) {
        $("#bookData").html(tableRows);
    });
});
</script>
