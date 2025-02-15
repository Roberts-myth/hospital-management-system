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

          $labTestTypeID = $_POST['LabTestTypeID'];
          $name = $_POST['name'];
          $turnaroundTime = $_POST['turnaround-time'];
          $description = $_POST['description'];

          $db = new SQLite3('../Hospital Database.db');

          $statement = $db->prepare("UPDATE LabTestType SET name = :name, turnaround_time = :turnaroundTime, description = :description WHERE LabTestTypeID = :labTestTypeID");

          $statement->bindValue(':labTestTypeID', $labTestTypeID, SQLITE3_INTEGER);
          $statement->bindValue(':name', $name, SQLITE3_TEXT);
          $statement->bindValue(':turnaroundTime', $turnaroundTime, SQLITE3_FLOAT);
          $statement->bindValue(':description', $description, SQLITE3_TEXT);

          if ($statement->execute()) {
              echo "<h1>Lab Test Type was successfully updated.</h1>";
          } else {
              echo "<h1>Failed to update Lab Test Type.</h1>";
          }
          
          $db->close();
        }

      ?>
      
    </div>
  </div>

</body>

</html>