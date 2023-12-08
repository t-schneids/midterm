<?php
    session_start();

    

    //establish connection info
    $server = "localhost";// your server
    $userid = "urre4ivsfgzys"; // your user id
    $pw = "DogDays12!"; // your pw
    $db = "db5nvjnj3daedb"; // your database

    // Create connection
    $conn = new mysqli($server, $userid, $pw );

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //select the database
    $conn->select_db($db);

    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $productID = $_POST['productID'];
        $quantity = $_POST['quantity'];



        //run a query
        $sql = "SELECT * FROM DogProducts where 'productID' = $productID";
        $result = $conn->query($sql);

        echo 'success';

        // Close the database connection 
        $conn->close();
    } else {
        // If the request is not a POST request, return an error response
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
?>