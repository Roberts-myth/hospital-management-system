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

          $staffID = $_POST['StaffID'];
          $fName = $_POST['first-name'];
          $mName = $_POST['middle-name'];
          if (empty($mName)) {
            $mName = null;
          }
          $lName = $_POST['last-name'];
          $occupation = $_POST['occupation'];
          $contactNumber = $_POST['contact-number'];
          $addressLine1 = $_POST['address-line-1'];
          $addressLine2 = $_POST['address-line-2'];
          if (empty($addressLine2)) {
            $addressLine2 = null;
          }
          $city = $_POST['city'];
          $postcode = $_POST['postcode'];
          $country = $_POST['country'];

          $db = new SQLite3('../Hospital Database.db');

          $statement = $db->prepare("UPDATE Staff SET first_name = :fName, middle_name = :mName, last_name = :lName, OccupationID = :occupation, contact_number = :contactNumber,
                                      address_line1 = :addressLine1, address_line2 = :addressLine2, city = :city, postcode = :postcode, country = :country
                                      WHERE StaffID = :staffID");

          $statement->bindValue(':staffID', $staffID, SQLITE3_INTEGER);
          $statement->bindValue(':fName', $fName, SQLITE3_TEXT);
          $statement->bindValue(':mName', $mName, SQLITE3_TEXT);
          $statement->bindValue(':lName', $lName, SQLITE3_TEXT);
          $statement->bindValue(':occupation', $occupation, SQLITE3_INTEGER);
          $statement->bindValue(':contactNumber', $contactNumber, SQLITE3_TEXT);
          $statement->bindValue(':addressLine1', $addressLine1, SQLITE3_TEXT);
          $statement->bindValue(':addressLine2', $addressLine2, SQLITE3_TEXT);
          $statement->bindValue(':city', $city, SQLITE3_TEXT);
          $statement->bindValue(':postcode', $postcode, SQLITE3_TEXT);
          $statement->bindValue(':country', $country, SQLITE3_TEXT);

          if ($statement->execute()) {
              echo "<h1>Staff was successfully updated.</h1>";
          } else {
              echo "<h1>Failed to update Staff.</h1>";
          }

        }

      ?>
      
    </div>
  </div>

</body>

</html>