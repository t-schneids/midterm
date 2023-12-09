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

    // SQL query for donation information
    $query2 = "SELECT * FROM donations WHERE userID='$userID'";
    $result2 = $conn->query($query2);
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
            }

            td {
                padding: 10px 40px;
            }

            .info {
                height: 500px;
                border-radius: 25px;
                background-color: rgba(152, 106, 79, 0.2);
                width: 360px;
                max-width: 360px;
            }

            .title {
                font-size: 35px;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                text-align: center;
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
                <li class="newTabs" id="companyName"> Rescue Waggin</li>
            </div> 
            </ul>
        </nav>

        <ul class="profile">
            <li>
                <a class="newTabs" href="dashboard.php">Dashboard</a>
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
                <a class="tabs" href="availableDogs.php" id="current"> AVAILABLE DOGS</a>
            </li>
            <li>
                <a class="tabs" href="contact.html"> CONTACT US</a>
            </li>
            <li>
                <a class="tabs" href="events.html"> EVENTS </a>
            </li>
            <li>
                <a class="tabs" href="items.php"> DOG PRODUCTS </a>
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
                        <h3>You Donated: </h3>
                        <?php
                            while($row2 = $result2->fetch_assoc()) 
                            {
                                echo '<p>$' . $row2['amount'] . ' -- ' . $row2['theDate'] . '</p>';
                                echo '<hr>';
                            }
                        ?>
                    </div>
                </td>
                <td> 
                    <div class="title"> Recent Purchases </div>
                    <div class="info"> </div>
                </td>
                <td> 
                    <div class="title"> Adoption Status </div>
                    <div class="info"> </div>
                </td>
            </tr>
        </table>

        <a id="logout" href="logout.php">Log Out</a>

        <footer>
            <h4> &copy; 2017 Rescue Waggin' </h4>
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
