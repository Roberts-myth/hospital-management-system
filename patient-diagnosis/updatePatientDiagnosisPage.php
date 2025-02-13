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
            <h2>Update Patient Diagnosis</h2>

            <?php
            $db = new SQLite3('../Hospital Database.db');
            $patientDiagnosisID = isset($_GET['PatientDiagnosisID']) ? $_GET['PatientDiagnosisID'] : ' ';
            $statement = $db->prepare("SELECT * FROM PatientDiagnosis WHERE PatientDiagnosisID = :patientDiagnosisID;");
            $statement->bindValue(':patientDiagnosisID', $patientDiagnosisID, SQLITE3_INTEGER);
            $result = $statement->execute();
            $record = $result->fetchArray(SQLITE3_ASSOC);

            $patientID = $record['PatientID'];
            $diagnosisTypeID = $record['DiagnosisTypeID'];
            $dateOfDiagnosis = $record['diagnosis_date'];
            $description = $record['description'];

            $db->close();
            ?>
            <form action="updatePatientDiagnosis.php" method="post">

                <label for="PatientDiagnosisID">Patient Diagnosis ID</label>
                <input type="number" id="PatientDiagnosisID" name="PatientDiagnosisID" value="<?php echo $patientDiagnosisID; ?>" readonly>
                <label for="PatientID">A-Z Patient List (By Surname)</label>
                <?php
                $db = new SQLite3('../Hospital Database.db');

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

                ?>

                <label for="diagnosis-type">Diagnosis</label>

                <?php
                $query = "SELECT DiagnosisTypeID, title FROM DiagnosisType;";
                $result = $db->query($query);
                echo '<select id="diagnosis-type" name="diagnosis-type" required>';

                while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
                    if ($record['DiagnosisTypeID'] == $diagnosisTypeID) {
                        echo '<option value="' . $record['DiagnosisTypeID'] . '" selected>' . $record['title'] . '</option>';
                    } else {
                        echo '<option value="' . $record['DiagnosisTypeID'] . '">' . $record['title'] . '</option>';
                    }
                }
                echo '</select>';
                $db->close();
                ?>

                <label for="date-of-diagnosis">Date of Diagnosis</label>
                <input type="date" id="date-of-diagnosis" name="date-of-diagnosis" value="<?php echo $dateOfDiagnosis; ?>" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe the diagnosis of the patient here, in detail." required><?php echo $description; ?></textarea>

                <button type="submit">Update Patient Diagnosis</button>
            </form>
        </div>
    </div>

</body>

</html>