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
        <h2>Update Occupation</h2>

        <?php 
          $db = new SQLite3('../Hospital Database.db');
          $occupationID = isset($_GET['OccupationID']) ? $_GET['OccupationID'] : ' ';
          $statement = $db->prepare("SELECT * FROM Occupation WHERE OccupationID = :occupationID;");
          $statement->bindValue(':occupationID', $occupationID, SQLITE3_INTEGER);
          $result = $statement->execute();
          $record = $result->fetchArray(SQLITE3_ASSOC);

          $title = $record['title'];
          $payPerHour = $record['pay_per_hour'];

          $db->close();
        ?>
        <form action="updateOccupation.php" method="post">
          
          <label for="OccupationID">Occupation ID</label>
          <input type="number" id="OccupationID" name="OccupationID" value="<?php echo $occupationID; ?>" readonly>

          <label for="title">Title</label>
          <input type="text" id="title" name="title" placeholder="<?php echo $title; ?>" value="<?php echo $title; ?>" required>
        
          <label for="pay-per-hour">Pay Per Hour (£)</label>
          <input type="number" id="pay-per-hour" name="pay-per-hour" placeholder="<?php echo $payPerHour; ?>" value="<?php echo $payPerHour; ?>" step="0.01" min="0.01" required>
          
          <button type="submit">Update Occupation</button>
        </form>  
    </div>
  </div>

</body>

</html>