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
        $db = new SQLite3("../Hospital Database.db");
        $labTestTypeID = isset($_GET['LabTestTypeID']) ? $_GET['LabTestTypeID'] : ' ';

        $statement = $db->prepare("SELECT name FROM LabTestType WHERE LabTestTypeID = :labTestTypeID;");
        $statement->bindValue(':labTestTypeID', $labTestTypeID, SQLITE3_INTEGER);
        $result = $statement->execute();
        $record = $result->fetchArray(SQLITE3_ASSOC);
        $name = $record['name'];
        $db->close();
      ?>
      <h1>Are you sure that you want to archive <?php echo $name; ?> from the Lab Test Type table?</h1>
      <h2>Archiving a record is permanent, and can't be reversed.</h2>
      <a href="archiveLabTestType.php?LabTestTypeID=<?php echo $labTestTypeID; ?>"><button class="delete-btn" style="width: 15%">Yes, archive the lab test type</button></a>
      <button onclick="goBack()" class="undo-btn" style="width: 15%">No, go back</button>
    </div>
  </div>

</body>

</html>