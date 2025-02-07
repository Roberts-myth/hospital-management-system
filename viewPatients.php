<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
  <link rel="stylesheet" href="style.css" />
  <script src="script.js"></script>
  <title>Hospital Management System</title>
</head>

<body onload="loadNavbar()">
  <div class="main-container">
    <div id="navbar-container"></div>
    <!-- Navbar will be loaded here -->
    <div class="main">
      <h1>List of Patients</h1>

      <form>
        <label for="first-name">First Name</label>
        <input type="text" id="first-name" name="first-name" placeholder="First Name">

        <label for="middle-name">Middle Name</label>
        <input type="text" id="middle-name" name="middle-name" placeholder="Middle Name">

        <label for="last-name">Last Name</label>
        <input type="text" id="last-name" name="last-name" placeholder="Last Name">

        <label for="date-of-birth">Date of Birth</label>
        <input type="date" id="date-of-birth" name="date-of-birth">

        <button type="submit">Search</button>
      </form>

      <?php
      $db = new SQLite3('Hospital Database.db');


      $recordsPerPage = 5;
      $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
      if ($currentPage < 1) {
        $currentPage = 1;
      }
      $offset = ($currentPage - 1) * $recordsPerPage;
      $totalQuery = "SELECT COUNT(*) AS 'Total' FROM Patient";
      $totalResult = $db->query($totalQuery);
      $totalQueryRecord = $totalResult->fetchArray(SQLITE3_ASSOC);
      $totalOfRecords = $totalQueryRecord['Total'];
      $totalPages = ceil($totalOfRecords / $recordsPerPage);

      $query = "SELECT * FROM Patient LIMIT $recordsPerPage OFFSET $offset;";
      $result = $db->query($query);
      ?>

      <table>
        <thead>
          <tr>
            <th>Patient ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Date of Birth</th>
            <th>Address Line 1</th>
            <th>Address Line 2</th>
            <th>City</th>
            <th>Postcode</th>
            <th>Country</th>

            <th style="text-align: center" colspan="2" align="center">
              Action
            </th>
          </tr>
        </thead>

        <tbody>

        <?php 
          while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
            $id = $record['PatientID'];
            $fName = $record['first_name'];
            if (is_null($record['middle_name'])) {
              $mName = "";
            } else {
              $mName = $record['middle_name'];
            }
            $lName = $record['last_name'];
            $contactNumber = $record['contact_number'];
            $dateOfBirth = date("jS F Y", strtotime($record['date_of_birth']));
            $addressLine1 = $record['address_line1'];
            if (is_null($record['address_line2'])) {
              $addressLine2 = "";
            } else {
              $addressLine2 = $record['address_line2'];
            }
            $city = $record['city'];
            $postcode = $record['postcode'];
            $country = $record['country'];

            echo '<tr>
              <td>' . $id . '</td>
              <td>' . $fName . '</td>
              <td>' . $mName . '</td>
              <td>' . $lName . '</td>
              <td>' . $contactNumber . '</td>
              <td>' . $dateOfBirth . '</td>
              <td>' . $addressLine1 . '</td>
              <td>' . $addressLine2 . '</td>
              <td>' . $city . '</td>
              <td>' . $postcode . '</td>
              <td>' . $country . '</td>
              <td><a href="updatePatientPage.php?PatientID=' . $id . '"><button class="update-btn">Update</button></a></td>
              <td><a href="deletePatientConfirmationPage.php?PatientID=' . $id . '"><button class="delete-btn">Delete</button></a></td>                    
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