<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
  <link rel="stylesheet" href="../style.css">
  <script src="../script.js"></script>
  <title>Hospital Management System</title>
</head>

<body onload="loadNavbar()">
  <div class="main-container">
    <div id="navbar-container"></div> <!-- Navbar will be loaded here -->
    <div class="main">

      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $startTime = $_POST['start-time'];
        $endTime = $_POST['end-time'];
        $reason = $_POST['reason'];
        $patientID = $_POST['PatientID'];
        $staffID = $_POST['StaffID'];

        $db = new SQLite3('../Hospital Database.db');

        $julianDayQuery = "SELECT julianday(:startTime) AS 'Start Time Value', julianday(:endTime) AS 'End Time Value'";
        
        $statement = $db->prepare($julianDayQuery);
        $statement->bindValue(':startTime', $startTime, SQLITE3_TEXT);
        $statement->bindValue(':endTime', $endTime, SQLITE3_TEXT);
        $result = $statement->execute();
        $record = $result->fetchArray(SQLITE3_ASSOC);
        $julianStartTime = $record['Start Time Value'];
        $julianEndTime = $record['End Time Value'];

        if ($julianEndTime > $julianStartTime) {
            
            $statement = $db->prepare("INSERT INTO Appointment(start_time, end_time, reason, PatientID, StaffID)
                                        VALUES (:startTime, :endTime, :reason, :patientID, :staffID);");

            $statement->bindValue(':startTime', $startTime, SQLITE3_TEXT);
            $statement->bindValue(':endTime', $endTime, SQLITE3_TEXT);
            $statement->bindValue(':reason', $reason, SQLITE3_TEXT);
            $statement->bindValue(':patientID', $patientID, SQLITE3_INTEGER);
            $statement->bindValue(':staffID', $staffID, SQLITE3_INTEGER);

            if ($statement->execute()) {
              echo "<h1>Appointment was successfully created.</h1>";
            } else {
              echo "<h1>Failed to create Appointment.</h1>";
              // echo '<button onclick="goBack()" class="undo-btn" style="width: 15%">Go back</button>';
            }            
        } else {
            echo "<h1>Failed to create Appointment.</h1>";
            echo "<h2>The appointment end time must be after the start time.</h2>";
            echo '<button onclick="goBack()" class="undo-btn" style="width: 15%">Go back</button>';
        }

        $db->close();
      }
      ?>
    </div>
  </div>

</body>

</html>