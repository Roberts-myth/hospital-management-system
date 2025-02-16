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
      <h1>List of Diagnosis Types</h1>

      <?php
      
      $titleCriteria = isset($_GET['title']) ? $_GET['title'] : ' ';
      $symptomKeywordCriteria = isset($_GET['symptom-keyword']) ? $_GET['symptom-keyword'] : ' ';

      $firstTime = ($titleCriteria == ' ') && ($symptomKeywordCriteria == ' ');
      
      ?> 

      <form method="get">

        <label for="title">Diagnosis Title</label>
        <input type="text" id="title" name="title" placeholder="Title" value="<?php if(!$firstTime) { echo $titleCriteria; } ?>">
        <label for="symptom-keyword">Symptom keyword</label>
        <input type="text" id="symptom-keyword" name="symptom-keyword" placeholder="Symptom keyword" value="<?php if(!$firstTime) { echo $symptomKeywordCriteria; } ?>">
        <button type="submit">Search</button>
      </form>

      <?php
      $db = new SQLite3('../Hospital Database.db');

      $criteriaQuery = "SELECT * FROM DiagnosisType WHERE title LIKE '%$titleCriteria%' AND symptoms LIKE '%$symptomKeywordCriteria%'";
      $totalQuery = "SELECT COUNT(*) AS 'Total' FROM";
      $recordsPerPage = 5;
      $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
      if ($currentPage < 1) {
        $currentPage = 1;
      }
      $offset = ($currentPage - 1) * $recordsPerPage;
      $totalQuery = $totalQuery." DiagnosisType;";
      // if (!$firstTime) {
      //   $totalQuery = $totalQuery." ($criteriaQuery);";
      // } else {
      //   $totalQuery = $totalQuery." DiagnosisType;";
      // }

      // echo $criteriaQuery;
      // echo "<br>",$totalQuery;
      
      $totalResult = $db->query($totalQuery);
      $totalQueryRecord = $totalResult->fetchArray(SQLITE3_ASSOC);
      $totalOfRecords = $totalQueryRecord['Total'];
      $totalPages = ceil($totalOfRecords / $recordsPerPage);

      
      if (!$firstTime) {
        $query = $criteriaQuery;
      } else {
        $query = "SELECT * FROM DiagnosisType LIMIT $recordsPerPage OFFSET $offset;";
      }


      $result = $db->query($query);
      ?>

      <table>
        <thead>
          <tr>
            <th>Diagnosis Type ID</th>
            <th>Title</th>
            <th>Symptoms</th>
            <th style="text-align: center" colspan="2" align="center">
              Action
            </th>
          </tr>
        </thead>

        <tbody>

          <?php

          while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
            $id = $record['DiagnosisTypeID'];
            $diagnosisTitle = $record['title'];
            $symptoms = $record['symptoms'];

            echo '<tr>
              <td>' . $id . '</td>
              <td>' . $diagnosisTitle . '</td>
              <td>' . $symptoms . '</td>
              <td><a href="updateDiagnosisTypePage.php?DiagnosisTypeID=' . $id . '"><button class="update-btn">Update</button></a></td>
              <td><a href="archiveDiagnosisTypeConfirmationPage.php?DiagnosisTypeID=' . $id . '"><button class="delete-btn">Archive</button></a></td>                    
          </tr>';
          }

          $db->close();

          ?>
        </tbody>
      </table>

      <?php
      if ($firstTime) {
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
      }

      ?>

    </div>
  </div>
</body>

</html>