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

            <h2>Create New Patient Diagnosis</h2>
            <form action="createNewPatientDiagnosis.php" method="post">

                <label for="PatientID">A-Z Patient List (By Surname)</label>
                <?php
                $db = new SQLite3('../Hospital Database.db');

                $query = "SELECT PatientID, first_name || ' ' || coalesce(middle_name || '', '') || ' ' || last_name AS 'Patient Name'
                        FROM Patient ORDER BY last_name;";

                $result = $db->query($query);
                echo '<select id="PatientID" name="PatientID" required>';
                echo '<option value="">Select a Patient</option>';
                while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
                    echo '<option value="' . $record['PatientID'] . '"> [' . $record['PatientID'] . '] ' . $record['Patient Name'] . '</option>';
                }
                echo '</select>';

                ?>

                <label for="diagnosis-type">Diagnosis</label>

                <?php
                $query = "SELECT DiagnosisTypeID, title FROM DiagnosisType;";
                $result = $db->query($query);
                echo '<select id="diagnosis-type" name="diagnosis-type" required>';
                echo '<option value="">Select a diagnosis</option>';

                while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
                    echo '<option value="' . $record['DiagnosisTypeID'] . '">' . $record['title'] . '</option>';
                }
                echo '</select>';
                $db->close();
                ?>

                <label for="date-of-diagnosis">Date of Diagnosis</label>
                <input type="date" id="date-of-diagnosis" name="date-of-diagnosis" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe the diagnosis of the patient here, in detail." required></textarea>

                <button type="submit">Create New Patient Diagnosis</button>
            </form>
        </div>
    </div>

</body>

</html>