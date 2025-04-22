<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
  <link rel="stylesheet" href="../style.css" />
  <script src="../script.js"></script>
  <title>Hospital Management System</title>
</head>

<body onload="loadNavbar()">
  <div class="main-container">
    <div id="navbar-container"></div>
    <!-- Navbar will be loaded here -->
    <div class="main">
      <h1>List of Lab Test Types</h1>

      <form>
        <label for="name">Lab Test Type Name</label>
        <input type="text" id="name" name="name" placeholder="Lab Test Type Name">
        <label for="turnaround-time">Turnaround Time (Hours)</label>
        <input type="number" id="turnaround-time" name="turnaround-time" placeholder="Turnaround Time (Hours)" step="0.1" min="0">
        <button type="submit">Search</button>
      </form>

      <?php
      $db = new SQLite3('../Hospital Database.db');


      $recordsPerPage = 5;
      $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
      if ($currentPage < 1) {
        $currentPage = 1;
      }
      $offset = ($currentPage - 1) * $recordsPerPage;
      $totalQuery = "SELECT COUNT(*) AS 'Total' FROM LabTestType";
      $totalResult = $db->query($totalQuery);
      $totalQueryRecord = $totalResult->fetchArray(SQLITE3_ASSOC);
      $totalOfRecords = $totalQueryRecord['Total'];
      $totalPages = ceil($totalOfRecords / $recordsPerPage);

      $query = "SELECT * FROM LabTestType LIMIT $recordsPerPage OFFSET $offset;";
      $result = $db->query($query);
      ?>

      <table>
        <thead>
          <tr>
            <th>Lab Test Type ID</th>
            <th>Name</th>
            <th>Turnaround Time (Hours)</th>
            <th>Description</th>
            <th style="text-align: center" colspan="2" align="center">
              Action
            </th>
          </tr>
        </thead>

        <tbody>

          <?php

          while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
            $id = $record['LabTestTypeID'];
            $name = $record['name'];
            $turnaroundTime = $record['turnaround_time'];
            $description = $record['description'];

            echo '<tr>
              <td>' . $id . '</td>
              <td>' . $name . '</td>
              <td>' . $turnaroundTime . '</td>
              <td>' . $description . '</td>
              <td><a href="updateLabTestTypePage.php?LabTestTypeID=' . $id . '"><button class="update-btn">Update</button></a></td>
              <td><a href="archiveLabTestTypeConfirmationPage.php?LabTestTypeID=' . $id . '"><button class="delete-btn">Archive</button></a></td>                    
          </tr>';
          }

          $db->close();

          ?>
        </tbody>
      </table>

      <?php
      echo '<ul class="pagination">';
      if ($currentPage > 1) {
        $previousPage = $currentPage - 1;
        echo '<li><a href="?page=' . $previousPage . '">&laquo;</a></li>';
      }

      for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
          echo '<li class="active"><a>' . $i . '</a></li>';
        } else {
          echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
        }
      }


      if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        echo '<li><a href="?page=' . $nextPage . '">&raquo;</a></li>';
      }

      echo '</ul>';
      ?>

    </div>
  </div>
</body>

</html>