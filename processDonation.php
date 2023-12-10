<?php
    session_start();
    //check if user is logged in, if not redirect them to login
    if (!isset($_SESSION['user']) || !isset($_SESSION['logged']) || !$_SESSION['logged']) {
        header("Location: login.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //establish connection info
        $server = "localhost";// your server
        $userid = "urre4ivsfgzys"; // your user id
        $pw = "DogDays12!"; // your pw
        $db= "db5nvjnj3daedb"; // your database
        
        $userID = $_SESSION['userID'];
        $amount = $_POST['amount'];
        $currentDate = date("m/d/Y");

       // Create connection
        $conn = new mysqli($server, $userid, $pw );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //select the database
        $conn->select_db($db);

        $query = "INSERT INTO donations (userID, amount, theDate) VALUES ('$userID', '$amount', '$currentDate')";
        $result = $conn->query($query);


        echo '<html> <head>';
        echo '<meta http-equiv="refresh" content="6;url=contact.html">';
        echo '<style>';
        echo 'body {';
        echo '  background-color: rgb(255, 248, 238);';
        echo '  text-align: center;';
        echo '}';
        echo 'h1 {';
        echo '  font-size: xx-large;';
        echo '  font-weight: bold;';
        echo '}';
        echo '</style>';
        echo '<script>';
        echo 'var countdown = 6;';
        echo 'function updateCountdown() {';
        echo '  countdown--;';
        echo '  if (countdown >= 0) {';
        echo '    document.getElementById("countdown").innerHTML = "Redirecting in " + countdown + " seconds...";';
        echo '    setTimeout(updateCountdown, 1000);';
        echo '  }';
        echo '}';
        echo 'setTimeout(updateCountdown, 1000);';
        echo '</script>';
        echo '</head>';
        echo '<body>';
        echo '<h1>Donations accepted! Thank you for your support!</h1>';
        echo '<p id="countdown">Redirecting in 6 seconds...</p>';
        echo '</body> </html>';


        
        $conn->close();
        
    }
        
?>