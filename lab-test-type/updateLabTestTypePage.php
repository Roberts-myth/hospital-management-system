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
            <h2>Update Lab Test Type</h2>

            <?php
            $db = new SQLite3('../Hospital Database.db');
            $labTestTypeID = isset($_GET['LabTestTypeID']) ? $_GET['LabTestTypeID'] : ' ';
            $statement = $db->prepare("SELECT * FROM LabTestType WHERE LabTestTypeID = :labTestTypeID;");
            $statement->bindValue(':labTestTypeID', $labTestTypeID, SQLITE3_INTEGER);
            $result = $statement->execute();
            $record = $result->fetchArray(SQLITE3_ASSOC);

            $name = $record['name'];
            $turnaroundTime = $record['turnaround_time'];
            $description = $record['description'];

            $db->close();
            ?>
            <form action="updateLabTestType.php" method="post">

                <label for="LabTestTypeID">Lab Test Type ID</label>
                <input type="number" id="LabTestTypeID" name="LabTestTypeID" value="<?php echo $labTestTypeID; ?>" readonly>
                
                <label for="name">Test Name</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $name; ?>" required>

                <label for="turnaround-time">Turnaround Time (Hours)</label>
                <input type="number" id="turnaround-time" name="turnaround-time" placeholder="<?php echo $turnaroundTime; ?>" value="<?php echo $turnaroundTime; ?>" min="0" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe what the test involves here, in detail. Instructions can be included." required><?php echo $description; ?></textarea>

                <button type="submit">Update Lab Test Type</button>
            </form>
        </div>
    </div>

</body>

</html>