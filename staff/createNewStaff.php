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

        $statement = $db->prepare("INSERT INTO Staff(first_name, middle_name, last_name, OccupationID, contact_number, address_line1, address_line2, city, postcode, country)
                                      VALUES(:FirstName, :MiddleName, :LastName, :OccupationID, :ContactNumber, :AddressLine1, :AddressLine2, :City, :Postcode, :Country);");

        $statement->bindValue(':FirstName', $fName, SQLITE3_TEXT);
        $statement->bindValue(':MiddleName', $mName, SQLITE3_TEXT);
        $statement->bindValue(':LastName', $lName, SQLITE3_TEXT);
        $statement->bindValue(':OccupationID', $occupation, SQLITE3_INTEGER);
        $statement->bindValue(':ContactNumber', $contactNumber, SQLITE3_TEXT);
        $statement->bindValue(':AddressLine1', $addressLine1, SQLITE3_TEXT);
        $statement->bindValue(':AddressLine2', $addressLine2, SQLITE3_TEXT);
        $statement->bindValue(':City', $city, SQLITE3_TEXT);
        $statement->bindValue(':Postcode', $postcode, SQLITE3_TEXT);
        $statement->bindValue(':Country', $country, SQLITE3_TEXT);

        if ($statement->execute()) {
          echo "<h1>Staff was successfully created.</h1>";
        } else {
          echo "<h1>Failed to create Staff.<h1>";
        }

        $db->close();
      }
      ?>
    </div>
  </div>

</body>

</html>