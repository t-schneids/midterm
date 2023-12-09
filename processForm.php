<?php
    session_start();
    
    
    if (!isset($_SESSION['user']) || !isset($_SESSION['logged'])) {
        header("Location: login.php");
        exit();
    }

    

    //establish connection info
    $server = "35.212.69.145";// your server
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
        $userID = $_SESSION['userID'];


        $output = "";
        $output .= $productID . " is productID.";
        //run a query
        $sql = "INSERT INTO cart (userID, productID, quantity) VALUES ('$userID', '$productID', '$quantity')";

        //  $output .= 'user id is ' . $userid;
        // $sql = "SELECT * FROM cart";

        $result = $conn->query($sql);
        // while($row = $result->fetch_assoc())
        // {
        //     // $output .= ' The product is ' . $row['Item'] . '. Ordered with quanitity ' . $quantity . '.' . "userID is " . $userid . '.';
        // }
        
        echo $output;
        // Close the database connection 
        $conn->close();
    } else {
        // If the request is not a POST request, return an error response
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
?>