<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //establish connection info
        $server = "35.212.69.145";// your server
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
            $response['found'] = true;
        } 
        else {
            // If no user found, set the 'found' flag to false
            $response['found'] = false;
        }
        // Send the JSON-encoded response
        header('Content-Type: application/json');
        echo json_encode($response);
        $conn->close();
        
    }
        
?>