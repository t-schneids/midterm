<?php 
    session_start();

    if (!isset($_SESSION['user']) || !isset($_SESSION['logged']) || !$_SESSION['logged']) {
        header("Location: login.php");
        exit();
    }

    // Retrieve user's email from the session
    $email = $_SESSION['user'];


    // Establish connection info
    $server = "35.212.69.145"; 
    $userid = "urre4ivsfgzys"; 
    $pw = "DogDays12!"; 
    $db = "db5nvjnj3daedb"; 

    // Create connection
    $conn = new mysqli($server, $userid, $pw, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);
    $userID = $_SESSION['userID'];

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row['firstName']; 
        $lastName = $row['lastName'];
        // Display the dashboard with the user's information
    }

    // SQL query for all donation information
    $query2 = "SELECT * FROM donations WHERE userID='$userID'";
    $result2 = $conn->query($query2);

    // SQL query for all adoption status information
    $query3 = "SELECT * FROM adoptionStatus WHERE userID='$userID'";
    $result3 = $conn->query($query3);

    $query4 = "SELECT * FROM purchases WHERE userID = '$userID' ORDER BY date DESC";
    $result4 = $conn->query($query4);
?>

<html>
    <head>
        <title>Midterm</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="general.css">
        <!-- links library for hamburger and close icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="general.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <style>
            footer {
                position: relative !important;
            }

            h1 {
                text-align: center;
                color: rgb(209,21,28);
            }

            .dash {
                align-items: center;
                text-align: center;
                display: flex;
                justify-content: center;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            }

            td {
                padding: 10px 40px;
            }

            .info {
                height: 500px;
                background-color: rgba(152, 106, 79, 0.2);
                width: 360px;
                max-width: 360px;
            }

            .title {
                font-size: 35px;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                text-align: center;
            }

            .logout a {
                text-decoration: none;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                font-weight: 800;
                color: black;
            }

            .logout {
                width: fit-content;
                background-color: rgba(209,21,28, 0.6);
                padding: 14px 16px;
            }

            .button {
                justify-content: center;
                display: flex;
                margin-bottom: 15px;
                margin-top: 7px;
            }

            @media (max-width: 1200px) {     
                td {
                    text-align: center;
                    margin-bottom: 20px; 
                    padding: 5px;
                }

                tr {
                    display: flex;
                    flex-wrap: wrap;
                    width: fit-content;
                    align-items: center;
                    justify-content: center;
                }
            }

            #donation p {
                margin: 0;
                padding: 0;
            }

            #companyName a {
                text-decoration: none;
                color: black;
            }
        </style>

    </head>
    <body>
        <nav class="nav">
            <ul class="navlist">
                <div class="logo">
                    <li> 
                        <a href="index.html"> 
                            <img src="wagonLogo.png" alt="company logo">
                        </a> 
                    </li>
                    <li class="newTabs" id="companyName"> 
                        <a href="index.html"> Rescue Waggin </a>
                    </li>            
                </div> 
            </ul>
        </nav>

        <ul class="profile">
            <li>
                <a class="newTabs" href="dashboard.php" id="current">Dashboard</a>
            </li>
        </ul>
        <ul class="cart">
            <li>
                <a class="newTabs" href="shoppingCart.php"><img src="images/cart.png" width="20"></a>
            </li>
        </ul>
        <ul class="tabGroup">
            <li> 
                <a class="tabs" href="aboutUs.html" > OUR STORY</a> 
            </li>
            <li>
                <a class="tabs" href="rescues.html"> RECENT RESCUES</a>
            </li>
            <li>
            <a class="tabs" href="adoption.php"> ADOPT A DOG</a>
            </li>
            <li>
                <a class="tabs" href="availableDogs.php"> SEE OUR DOGS </a>
            </li>
            <li>
                <a class="tabs" href="events.html"> EVENTS </a>
            </li>
            <li>
                <a class="tabs" href="items.php"> SEE OUR ITEMS </a>
            </li>
            <li>
                <a class="tabs" href="contact.html"> CONTACT US</a>
            </li>
        </ul>

        <button class="hamburger">
            <div class="menuIcon material-icons"> menu</div>
            <div class="closeIcon material-icons"> close</div>
        </button>

        <div>
            <h1>Welcome to your dashboard, <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h1>
        </div>

        <table class="dash">
            <tr>
                <td> 
                    <div class="title"> Recent Donations </div>
                    <div id = "donation" class="info">
                        <!-- <h3 style="margin-top:0;">You Donated: </h3> -->
                        <?php
                            echo '<hr>';
                            while($row2 = $result2->fetch_assoc()) 
                            {
                                echo '<p>$' . $row2['amount'] . ' on  ' . $row2['theDate'] . '</p>';
                                echo '<hr>';
                            }
                        ?>
                    </div>
                </td>
                <td> 
                    <div class="title"> Recent Purchases </div>
                    <div class="info"> 
                        <?php 
                            if ($result4->num_rows >0){
                                $curDate = 0;
                                while ($row4 = $result4->fetch_assoc()){
                                    $itemName = $row4['Item'];
                                    $quantity = $row4['quantity'];
                                    $orderDate = $row4['date'];

                                    if ($curDate != $orderDate){
                                        $curDate = $orderDate;
                                        echo "<hr>";
                                        echo "<h3>$orderDate</h3>";
                                        echo "$quantity x $itemName";
                                    }
                                    else{
                                        echo "<br/>$quantity x $itemName";
                                    }
                                }
                                echo "<hr>";
                            }
                        ?>
                    </div>
                </td>
                <td> 
                    <div class="title"> Adoption Status</div>
                    <div class="info"> 
                        <?php
                            echo '<hr>';
                            while($row3 = $result3->fetch_assoc()) 
                            {
                                 // SQL query for all dog info relating to adoption info
                                $dogID = $row3['dogID']; // get dog ID
                                $query4  = "SELECT * FROM dogs WHERE dogID= '$dogID'";

                                $result4 = $conn->query($query4);
                                while($row4 = $result4->fetch_assoc())
                                {
                                    echo '<p> Adoption request submitted for ' . $row4['dogName'] . ' the ' . $row4['breed'] . ' on ' . $row3['theDate'] . '. The status of this request is ' . $row3['theStatus'] . '. </p>';
                                    echo '<hr>';
                                }

                            }
                        ?>
                    </div>
                </td>
            </tr>
        </table>

        <div class="button">
            <div class ="logout">
                <a href="logout.php"> Log Out </a>
            </div>
        </div>

        <footer>
            <h4> &copy; 2017 Rescue Waggin </h4>
            <ul class="nav">
                <li> <a href="https://www.gmail.com"><img src="images/gmailLogo.png" style="width:25px;height:20px;"></a> </li>
                <li> <a href="https://www.instagram.com"><img src="images/instagramLogo.png" style="width:20px;height:20px;"></a> </li>
                <li> <a href="https://www.facebook.com"><img src="images/facebookLogo.png" style="width:20px;height:20px;"></a> </li>
            </ul>
        </footer>
        </div>
    </body>
</html>


<?php
    $conn->close();
?>
