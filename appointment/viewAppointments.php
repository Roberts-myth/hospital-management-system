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
      <h1>List of Appointments</h1>

      <form>
        <label for="date-of-appointment">Appointment Date</label>
        <input type="date" id="date-of-appointment" name="date-of-appointment">
        <label for="patient-name">Patient Name</label>
        <input type="text" id="patient-name" name="patient-name" placeholder="Patient Name">
        <label for="staff-name">Staff Name</label>
        <input type="text" id="staff-name" name="staff-name" placeholder="Staff Name">        
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
      $totalQuery = "SELECT COUNT(*) AS 'Total' FROM Appointment";
      $totalResult = $db->query($totalQuery);
      $totalQueryRecord = $totalResult->fetchArray(SQLITE3_ASSOC);
      $totalOfRecords = $totalQueryRecord['Total'];
      $totalPages = ceil($totalOfRecords / $recordsPerPage);

      $query = "SELECT a.AppointmentID, a.start_time, a.end_time, a.reason, 
      p.first_name || ' ' || coalesce(p.middle_name || '', '') || ' ' || p.last_name AS 'Patient Name',
      o.title || ' ' || s.first_name || ' ' || coalesce(s.middle_name || '', '') || ' ' || s.last_name AS 'Staff Name'
      FROM Appointment a
      INNER JOIN Patient p ON p.PatientID = a.PatientID
      INNER JOIN Staff s ON s.StaffID = a.StaffID
      INNER JOIN Occupation o ON o.OccupationID = s.OccupationID
      LIMIT $recordsPerPage OFFSET $offset;";
      $result = $db->query($query);
      ?>

      <table>
        <thead>
          <tr>
            <th>Appointment ID</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Reason</th>
            <th>Patient Name</th>
            <th>Staff Name</th>
            <th style="text-align: center" colspan="2" align="center">
              Action
            </th>
          </tr>
        </thead>

        <tbody>

          <?php

          while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
            $id = $record['AppointmentID'];
            $startTime = date("jS F Y g:iA", strtotime($record['start_time']));
            $endTime = date("jS F Y g:iA", strtotime($record['end_time']));
            $reason = $record['reason'];
            $patientName = $record['Patient Name'];
            $staffName = $record['Staff Name'];

            echo '<tr>
              <td>' . $id . '</td>
              <td>' . $startTime . '</td>
              <td>' . $endTime . '</td>
              <td>' . $reason . '</td>
              <td>' . $patientName . '</td>
              <td>' . $staffName . '</td>
              <td><a href="updateAppointmentPage.php?AppointmentID=' . $id . '"><button class="update-btn">Update</button></a></td>
              <td><a href="deleteAppointmentConfirmationPage.php?AppointmentID=' . $id . '"><button class="delete-btn">Delete</button></a></td>                    
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