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

        <h2>Create New Appointment</h2>

        <p><b>Warning</b>: Creating an appointment using this form has no appointment clash prevention.
        <br>Please ensure that you are not creating an appointment that clashes with another one by checking with the <a href="viewAppointments.php">View Appointments</a> page.</p>
      
        <form action="createNewAppointment.php" method="post">

            <label for="start-time">Start Time</label>
            <input type="datetime-local" id="start-time" name="start-time" min="<?php echo date("Y-m-d"); ?>" required>

            <label for="end-time">End Time</label>
            <input type="datetime-local" id="end-time" name="end-time" min="<?php echo date("Y-m-d"); ?>" required>

            <label for="reason">Reason</label>
            <input type="text" id="reason" name="reason" placeholder="Reason" required>

            <label for="PatientID">A-Z Patient List (By Surname)</label>
                <?php
                $db = new SQLite3('../Hospital Database.db');

                $query = "SELECT PatientID, first_name || ' ' || coalesce(middle_name || '', '') || ' ' || last_name AS 'Patient Name'
                        FROM Patient ORDER BY last_name;";

                $result = $db->query($query);
                echo '<select id="PatientID" name="PatientID" required>';
                echo '<option value="">Select a patient</option>';
                while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
                    echo '<option value="' . $record['PatientID'] . '"> [' . $record['PatientID'] . '] ' . $record['Patient Name'] . '</option>';
                }
                echo '</select>';

                ?>
                <label for="StaffID">A-Z Staff List (By Role/Surname)</label>
                <?php

                $query = "SELECT s.StaffID, o.title, s.first_name || ' ' || coalesce(s.middle_name || '', '') || ' ' || s.last_name AS 'name'
                                   FROM Staff s INNER JOIN Occupation o ON o.OccupationID = s.OccupationID
                                   ORDER BY o.title, s.last_name;";

                $result = $db->query($query);
                echo '<select id="StaffID" name="StaffID" required>';
                echo '<option value="">Select a staff member</option>';
                while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
                    echo '<option value="' . $record['StaffID'] . '"> [' . $record['StaffID'] . '] '.$record['title'].' '. $record['name'] . '</option>';
                }
                echo '</select>';

                $db->close();

                ?>
            <button type="submit">Create New Appointment</button>
        </form>  
    </div>
  </div>

</body>

</html>