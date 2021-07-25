<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>
<body>
    <h1><?= 'PHP - '.phpversion() ?></h1>
    <?php
        $servername = "mysql";
        $username = "root";
        $password = "1234";
        $dbname = "test";
      
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          echo "Connection failed: " . $conn->connect_error;
        }else{
          echo "Connected successfully to the mysql server in service named \"$servername\"";
        }

        die();
       
        $conn->close();
    ?>
</body>
</html>
