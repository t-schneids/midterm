<?php
    session_start();

    if(isset($_POST['First_Name']) && isset($_POST['Last_Name']) && isset($_POST['password']) && isset($_POST['email'])){
        //establish connection info
        $server = "35.212.69.145";
        $userid = "urre4ivsfgzys"; 
        $pw = "DogDays12!"; 
        $db= "db5nvjnj3daedb"; 
            
        // Create connection
        $conn = new mysqli($server, $userid, $pw );
        
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $conn->select_db($db);
        extract($_POST);
        $query = "INSERT INTO users (userID, firstName, lastName, email, password) VALUES (NULL, '$First_Name', '$Last_Name', '$email', '$password')";
        $conn->query($query);
        $conn->close();
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
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
    body {
        margin: 0;
        padding: 0;
    }

    form {
        background-color: rgba(152, 106, 79, 0.2);
        padding: 20px;
        border-radius: 10px;
        width: 300px;
        margin: 43px auto 0;
        margin-bottom: 20px;
    }

    h1 {
        text-align: center;
        color: #d1151c;
    }

    label {
        display: block;
        margin-bottom: 7px;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        background-color: #d1151c;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* footer {
        position: relative !important;
    } */

    .menuIcon {
        color: black;
    }

    .hamburger {
        border-radius: 0px
    }

    #companyName a {
        text-decoration: none;
        color: black;
    }

    .closeIcon {
        color: black;
    }
</style>

        <script>

            // validateForm
            // Parameters: None
            // Purpose: To validate the adopt form
            // returns: A boolean representing if the form should be submitted
            function validate() {
                userInfo = document.querySelectorAll(".userInfo");
                for (let i = 0; i < userInfo.length - 1; i++) {
                    if (userInfo[i].value == "") {
                        alert("Missing " + userInfo[i].name + ". Please enter " + userInfo[i].name + " information");

                        return false;
                    }
                }

                email = $("#email").val();
                emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

                if (!email.match(emailPattern)) {
                    alert("Email does not match specified format. Please retry")
                    return false;
                }
                
                return true;
            }
        </script>

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
                <a class="tabs" href="aboutUs.html"> OUR STORY</a> 
            </li>
            <li>
                <a class="tabs" href="rescues.html"> RECENT RESCUES</a>
            </li>
            <li>
            <a class="tabs" href="adoption.php"> ADOPT A DOG</a>
            </li>
            <li>
                <a class="tabs" href="availableDogs.php"> SEE OUR DOGS</a>
            </li>
            <li>
                <a class="tabs" href="events.html"> EVENTS </a>
            </li>
            <li>
                <a class="tabs" href="items.php"> SEE OUR ITEMS </a>
            </li>
            <li><a class='tabs' href='contact.html'>CONTACT US</a></li>

        </ul>

        <button class="hamburger">
            <div class="menuIcon material-icons"> menu</div>
            <div class="closeIcon material-icons"> close</div>
        </button>


            <div>
                <form method="POST" id="signup_form" name="signup_form" action="signup.php" onsubmit="return validate()">
                <h1>Sign Up</h1>
                  First Name:  <input id='fname' type='text' name='First Name' class="userInfo"/> <br/>
                  Last Name:   <input id="lname" type="text" name="Last Name" class="userInfo"/> <br/>
                  Email:  <input id='email' type='text' name='email' class="userInfo"/> <br/>
                  Password:  <input id="password" type="password" name="password" class="userInfo"/> <br/>
                    <input id='submit_button' type='submit' name='submit_button' class="userInfo" value="Sign Up"><br/>
                </form>
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