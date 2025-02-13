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
            <h2>Update Diagnosis Type</h2>

            <?php
            $db = new SQLite3('../Hospital Database.db');
            $diagnosisTypeID = isset($_GET['DiagnosisTypeID']) ? $_GET['DiagnosisTypeID'] : ' ';
            $statement = $db->prepare("SELECT * FROM DiagnosisType WHERE DiagnosisTypeID = :diagnosisTypeID;");
            $statement->bindValue(':diagnosisTypeID', $diagnosisTypeID, SQLITE3_INTEGER);
            $result = $statement->execute();
            $record = $result->fetchArray(SQLITE3_ASSOC);

            $diagnosisTypeID = $record['DiagnosisTypeID'];
            $title = $record['title'];
            $symptoms = $record['symptoms'];

            $db->close();
            ?>
            <form action="updateDiagnosisType.php" method="post">

                <label for="DiagnosisTypeID">Diagnosis Type ID</label>
                <input type="number" id="DiagnosisTypeID" name="DiagnosisTypeID" value="<?php echo $diagnosisTypeID; ?>" readonly>
                
                <label for="title">Diagnosis Title</label>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>" placeholder="<?php echo $title; ?>" required>

                <label for="symptoms">Symptoms</label>
                <textarea id="symptoms" name="symptoms" placeholder="Describe the symptoms of the diagnosis here, in detail." required><?php echo $symptoms; ?></textarea>

                <button type="submit">Update Diagnosis Type</button>
            </form>
        </div>
    </div>

</body>

</html>