<?php
    $username = "root";
    $password = "";
    $servername = "localhost";
    $dbname = "torchlightTutoring";
    $port = "3306";

    $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die(mysqli_connect_error());
        }
