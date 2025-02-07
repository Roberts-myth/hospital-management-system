<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>Hospital Management System</title> 
</head>

<body onload="loadNavbar()">
  <div class="main-container">
    <div id="navbar-container"></div> <!-- Navbar will be loaded here -->
    <div class="main">
      <?php 
        $db = new SQLite3("Hospital Database.db");
        $staffID = isset($_GET['StaffID']) ? $_GET['StaffID'] : ' ';

        $statement = $db->prepare("SELECT o.title, s.first_name || ' ' || coalesce(s.middle_name || '', '') || ' ' || s.last_name AS 'name'
                                   FROM Staff s INNER JOIN Occupation o ON o.OccupationID = s.OccupationID
                                   WHERE s.StaffID = :staffID;");
        $statement->bindValue(':staffID', $staffID, SQLITE3_INTEGER);
        $result = $statement->execute();
        $record = $result->fetchArray(SQLITE3_ASSOC);
        $occupation = $record['title'];
        $name = $record['name'];

      ?>
      <h1>Are you sure that you want to delete <?php echo $occupation, " ", $name; ?> from the Patient table?</h1>
      <h2>Deleting a record is permanent, and can't be reversed.</h2>
      <a href="deleteStaff.html"><button class="delete-btn" style="width: 15%">Yes, delete <?php echo $occupation, " ", $name; ?></button></a>
    </div>
  </div>

</body>

</html>