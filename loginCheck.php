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

<body>
    <div class="main-container">
        <div class="main">
            <?php

            $db = new SQLite3('Hospital Database.db');
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            $statement = $db->prepare("SELECT password_hash, COUNT(*) AS 'Records Found' FROM User WHERE username = :username");
            $statement->bindValue(':username', $username, SQLITE3_TEXT);
            $result = $statement->execute();
            $record = $result->fetchArray(SQLITE3_ASSOC);

            if ($record['Records Found'] > 0) {
                $passwordHashInDb = $record['password_hash'];
                if (password_verify($password, $passwordHashInDb)) {
                    $db->close();
                    header('location: index.html');
                } else {
                    echo "<h1>Incorrect password.</h1><br>";
                    $db->close();
                }
            } else {
                echo "<h1>Your username couldn't be found in our records.</h1><br>";
            }

            ?>

            <p>You can return to the <a href="login.html">login page</a> and try again.</p>

        </div>
    </div>

</body>

</html>