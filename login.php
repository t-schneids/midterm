<?php
session_start();
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
            footer {
                position: relative !important;
            }
            h1 {
                text-align: center;
                color: rgb(209,21,28);
            }

            label {
                width: 130px;
                display: flex;
            }

            form {
                background-color: rgba(152, 106, 79, 0.2);
                padding: 10px;
                border-radius: 25px;
            }

            .contact a {
                text-decoration: none;
                font-weight: 800;
                color: black;
            }

            .contact {
                width: fit-content;
                background-color: rgb(246, 207, 66);
                border-radius: 25px;
                padding: 14px 16px;
            }

            .row {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                padding-left: 10px;
                padding-right: 5px;
                padding-bottom: 30px;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            }

            .column {
                display: flex;
                flex-direction: column;
                flex: 50%;
                align-items: center;
            }
            .search-container {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }

            label {
                white-space: nowrap;
            }

            #breedInput {
                margin-left: 5px; 
            }

            label, input, button {
                margin-right: 10px; 
            }
            .dog-input {
                flex-grow: 1;
            }
        </style>

        <script>
            //handling db_response asynchronously in order not to refresh page

            // $(document).ready(function(){
            //     $('#login_form').on('submit', function(e){
            //         e.preventDefault(); // Prevent form submission

            //         // AJAX call to handle form submission
            //         if(validate()){
            //             $.ajax({
            //                 type: 'POST',
            //                 url: 'processLogin.php', // Send request to the same PHP file
            //                 data: $(this).serialize(), // Serialize form data
            //                 dataType: 'json', // Expect JSON response
            //                 success: function(response){
            //                     if (response.found) {
            //                         // User found, display user data or perform necessary actions
            //                         alert('user found');
            //                         $('#messageDiv').html("Account found!");
            //                         form = $(this);
            //                         form.off('submit'); // Remove previous submit handler to avoid infinite loop
            //                         form.submit(); // Submit the form
                                    
            //                     } else {
            //                         // No user found, display the message
            //                         $('#messageDiv').html("No account found with this email/password combination.");
            //                     }
            //                 },
            //                 error: function(xhr, status, error){
            //                     console.error(xhr.responseText); // Log the error to console
            //                     // Handle the error or debug the issue
            //                 }
            //             });
            //         }

            //     });
            // });

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
                        <img src="logo.png" alt="company logo">
                    </a> 
                </li>
            </div> 
            </ul>
        </nav>

        <ul class="tabGroup">
            <li> 
                <a class="tabs" href="aboutUs.html" > OUR STORY</a> 
            </li>
            <li>
                <a class="tabs" href="rescues.html"> RECENT RESCUES</a>
            </li>
            <li>
            <a class="tabs" href="adoption.php" id="current"> ADOPTION</a>
            </li>
            <li>
                <a class="tabs" href="availableDogs.php"> AVAILABLE DOGS</a>
            </li>
            <li>
                <a class="tabs" href="contact.html"> CONTACT US</a>
            </li>
            <li>
                <a class="tabs" href="events.html"> EVENTS </a>
            </li>
        </ul>

        <button class="hamburger">
            <div class="menuIcon material-icons"> menu</div>
            <div class="closeIcon material-icons"> close</div>
        </button>


            <div id='loginDiv'>
                <form method="POST" id="login_form" name="login_form" action="processLogin.php" onsubmit="return validate()">
                <h1>Login</h1>
                  Email:  <input id='email' type='text' name='email' class="userInfo"/> <br/>
                  Password:  <input id="password" type="password" name="password" class="userInfo"/> <br/>
                    <input id='submit_button' type='submit' name='submit_button' class="userInfo"><br/>
                </form>
            </div>
            <div id='messageDiv'>
            </div>
            <div id='signupDiv'>
                Don't have an account? Sign Up <a href='signup.php'> HERE! </a>
            </div>

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