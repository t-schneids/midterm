<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //establish connection info
        $server = "localhost";// your server
        $userid = "urre4ivsfgzys"; // your user id
        $pw = "DogDays12!"; // your pw
        $db= "db5nvjnj3daedb"; // your database
            
        // Create connection
        $conn = new mysqli($server, $userid, $pw );
        
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $conn->select_db($db);
        extract($_POST);

        $query = "SELECT * FROM users WHERE email='$email' AND password='$password' ";
        $result = $conn->query($query);
        $response = array(); // Initialize a response array

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user'] = $email;
            $_SESSION['logged'] = true;
            $_SESSION['userID'] = $row['userID'];
            header('Location: dashboard.php');
        } 
        else {
            header('Location: login.php');
        }
        $conn->close();
        
    }
        
?>