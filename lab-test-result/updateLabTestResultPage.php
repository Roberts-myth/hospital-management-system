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
            <h2>Update Lab Test Result</h2>

            <?php
            $db = new SQLite3('../Hospital Database.db');
            $labTestResultID = isset($_GET['LabTestResultID']) ? $_GET['LabTestResultID'] : ' ';
            $statement = $db->prepare("SELECT * FROM LabTestResult WHERE LabTestResultID = :labTestResultID;");
            $statement->bindValue(':labTestResultID', $labTestResultID, SQLITE3_INTEGER);
            $result = $statement->execute();
            $record = $result->fetchArray(SQLITE3_ASSOC);


            $labTestTypeID = $record['LabTestTypeID'];
            $patientID = $record['PatientID'];
            $dateOfTest = $record['date_of_test'];
            $description = $record['result_description'];

            ?>
            <form action="updateLabTestResult.php" method="post">

                <label for="LabTestResultID">Lab Test Result ID</label>
                <input type="number" id="LabTestResultID" name="LabTestResultID" value="<?php echo $labTestResultID; ?>" readonly>
                
                <label for="LabTestTypeID">Test Type</label>
                <?php

                $query = "SELECT LabTestTypeID, name FROM LabTestType ORDER BY name;";

                $result = $db->query($query);
                echo '<select id="LabTestTypeID" name="LabTestTypeID" required>';
                while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
                    if ($record['LabTestTypeID'] == $labTestTypeID) {
                        echo '<option value="' . $record['LabTestTypeID'] . '" selected>' . $record['name'] . '</option>';
                    } else {
                        echo '<option value="' . $record['LabTestTypeID'] . '">' . $record['name'] . '</option>';
                    }
                    
                }
                echo '</select>';


                ?>

                <label for="PatientID">A-Z Patient List (By Surname)</label>
                <?php

                $query = "SELECT PatientID, first_name || ' ' || coalesce(middle_name || '', '') || ' ' || last_name AS 'Patient Name'
                        FROM Patient ORDER BY last_name;";

                $result = $db->query($query);
                echo '<select id="PatientID" name="PatientID" required>';
                while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
                    if ($record['PatientID'] == $patientID) {
                        echo '<option value="' . $record['PatientID'] . '" selected> [' . $record['PatientID'] . '] ' . $record['Patient Name'] . '</option>';
                    } else {
                        echo '<option value="' . $record['PatientID'] . '"> [' . $record['PatientID'] . '] ' . $record['Patient Name'] . '</option>';
                    }
                }
                echo '</select>';

                $db->close();

                ?>

                <label for="date-of-test">Date of Test</label>
                <input type="date" id="date-of-test" name="date-of-test" value="<?php echo $dateOfTest; ?>" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe the results of the test here, in detail." required><?php echo $description; ?></textarea>

                <button type="submit">Update Lab Test Result</button>
            </form>
        </div>
    </div>

</body>

</html>