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
      <h1>List of Lab Test Results</h1>

      <form>
        <label>Search fields will be here</label>
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
      $totalQuery = "SELECT COUNT(*) AS 'Total' FROM LabTestResult";
      $totalResult = $db->query($totalQuery);
      $totalQueryRecord = $totalResult->fetchArray(SQLITE3_ASSOC);
      $totalOfRecords = $totalQueryRecord['Total'];
      $totalPages = ceil($totalOfRecords / $recordsPerPage);

      $query = "SELECT ltr.LabTestResultID, ltt.name AS 'Test Type', 
      p.first_name || ' ' || coalesce(p.middle_name || '', '') || ' ' || p.last_name AS 'Patient Name',
      ltr.date_of_test, ltr.result_description
      FROM LabTestResult ltr
      INNER JOIN LabTestType ltt ON ltt.LabTestTypeID = ltr.LabTestTypeID
      INNER JOIN Patient p ON ltr.PatientID = p.PatientID
      LIMIT $recordsPerPage OFFSET $offset;";
      $result = $db->query($query);
      ?>

      <table>
        <thead>
          <tr>
            <th>Lab Test Result ID</th>
            <th>Test Type</th>
            <th>Patient Name</th>
            <th>Date of Test</th>
            <th>Description</th>
            <th style="text-align: center" colspan="2" align="center">
              Action
            </th>
          </tr>
        </thead>

        <tbody>

          <?php

          while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
            $id = $record['LabTestResultID'];
            $testType = $record['Test Type'];
            $patientName = $record['Patient Name'];
            $dateOfTest = date("jS F Y", strtotime($record['date_of_test']));
            $description = $record['result_description'];

            echo '<tr>
              <td>' . $id . '</td>
              <td>' . $testType . '</td>
              <td>' . $patientName . '</td>
              <td>' . $dateOfTest . '</td>
              <td>' . $description . '</td>
              <td><a href="updateLabTestResultPage.php?LabTestResultID=' . $id . '"><button class="update-btn">Update</button></a></td>
              <td><a href="deleteLabTestResultConfirmationPage.php?LabTestResultID=' . $id . '"><button class="delete-btn">Archive</button></a></td>                    
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