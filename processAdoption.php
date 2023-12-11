<?php    
    session_start();
    //check if user is logged in, if not redirect them to login
    if (!isset($_SESSION['user']) || !isset($_SESSION['logged']) || !$_SESSION['logged']) {
        header("Location: login.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //establish connection info
        $server = "35.212.69.145";// your server
        $userid = "urre4ivsfgzys"; // your user id
        $pw = "DogDays12!"; // your pw
        $db= "db5nvjnj3daedb"; // your database
        
        $userID = $_SESSION['userID'];
        $currentDate = date("m/d/Y");
        $dog = $_POST['quan'];
        $startPos = strpos($dog, '"');

        // Extract just the dogs name
        $endPos = strpos($dog, '"', $startPos + 1);

        
        if ($startPos !== false && $endPos !== false) {
            $substring = substr($dog, $startPos + 1, $endPos - $startPos - 1);
        }

       // Create connection
        $conn = new mysqli($server, $userid, $pw );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //select the database
        $conn->select_db($db);

        //get the dog id from dog name
        $dogIDQuery = "SELECT dogID FROM dogs WHERE dogName = '$substring'";
        $dogIDResult = $conn->query($dogIDQuery);

        if ($dogIDResult->num_rows > 0) {
            // Fetch the first row
            $firstRow = $dogIDResult->fetch_assoc();
        } else {
            echo "no results";
        }

        //insert into the database
        $dogID = $firstRow['dogID'];
        $query = "INSERT INTO adoptionStatus (userID, dogID, theDate, theStatus) VALUES ('$userID', '$dogID', '$currentDate', 'under review')";
        $result = $conn->query($query);


        echo '<html> <head>';
        echo '<meta http-equiv="refresh" content="6;url=adoption.php">';
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
        echo '<h1>Adoption request submitted! Your request is under review!</h1>';
        echo '<p id="countdown">Redirecting in 6 seconds...</p>';
        echo '</body> </html>';


        
        $conn->close();
        
    }
        
?>