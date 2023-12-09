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
                color: rgb(209,21,28);
                margin: 10px;
                font-size: 40px;
                text-align: center;
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

            #information {
                /* padding-left: 40px; */
                margin-left: 30px;
            }

            #information h2 {
                text-align: center;
            }

            #information h3 {
                text-align: center;
            }

            .button {
                justify-content: center;
                display: flex;
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

            .breeds h2  {
                text-align: center;
                margin-bottom: -10px;
            }

            .breeds h3  {
                text-align: center;
            }

            .breeds {
                background-color: rgba(209,21,28, 0.15);
                padding: 10px;
                border-radius: 25px;
                max-width: 415px; 
                width: 100%;  
                flex: 1;   
                
            }

            .breed-wrapper {
                justify-content: center;
                display: flex;
                max-height: 200px;
                height: 100%;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

            }

            .wrapper {
                max-width: 415px; 
                width: 100%;     
                background-color: rgba(209,21,28, 0.15);
                padding: 10px;
                border-radius: 25px;
                margin-left: 20px;
                flex: 1;
            }

            .dogName {
                color: rgb(209,21,28);
            }
        </style>

        <script>

            //populates the subtotal, etc with information from the 
            //table based on if they want a service or not
            $(document).ready(function() {
                $(".choice select").change(function() {
                    index = parseInt(this.name);
                    price = services[index].cost;
                    chosen = this.selectedIndex;
                    totalCost = price.toFixed(2);
                    
                    // Update subtotal bar
                    if (chosen) {
                        subtotal = parseInt(document.forms[0].subtotal.value);
                        subtotal += parseInt(totalCost);
                        document.forms[0].subtotal.value = subtotal.toFixed(2);
                    } else {
                        subtotal = parseInt(document.forms[0].subtotal.value);
                        subtotal -= parseInt(totalCost);
                        document.forms[0].subtotal.value = subtotal.toFixed(2);
                    }

                    taxAmount = .0625 * subtotal;
                    document.forms[0].tax.value = taxAmount.toFixed(2);

                    final = taxAmount + subtotal;
                    document.forms[0].total.value = final.toFixed(2);
                })
            });

            function Dog(name, breed, age) {
                this.name = name;
                this.breed = breed;
                this.age = age;
            }

            function Service(name, cost) {
                this.name = name;
                this.cost = cost;
            }  

            services = new Array (
                new Service("Vaccinations", 400),
                new Service("Spay/neuter surgery", 450),
                new Service("Leash and Collar", 30)
            )

            dogs = new Array (
                new Dog("Bella", "Australian Shepard", "6 months"),
                new Dog("Charlie", "Mutt", "4 years"),
                new Dog("Daisy", "Mutt", "2 years"),
                new Dog("Duke", "Chihuahua", "3 years"),
                new Dog("Lucy", "West Highland Terrior", "5 years"),
                new Dog("Luna", "Pitbull", "3 years"),
                new Dog("Max", "Golden Retriever", "1 year"),
                new Dog("Milo", "Pitbull", "4 years"),
                new Dog("Rocky", "Mutt", "3 years"),
                new Dog("Rosie", "Pitbull", "2 years"),
                new Dog("Sadie and Bailey", "Chihuahuas", "5 and 4 years"),
                new Dog("Filou", "Golden Retriever", "6 months")
            )

            // selectDog
            // Parameters: a name a name I can give to each dog element
            // Purpose: to create a selection dropdown with dog names
            // returns: the html elements appended in string form
            function selectDog(name) {
                var temp = "";
                temp = "<select name='" + name + "' size='1'>";
	            for (j = 0; j < dogs.length; j++) {
                    temp += "<option>" + "\"" + dogs[j].name + "\"" + " the " + dogs[j].breed + ", age " + dogs[j].age + "</option>";
                }
	            temp+= "</select>"; 
	            return temp;
            }

            function tableData(content, className="" ) {
                return "<td class = '" + className + "'>" + content + "</td>";
            }

            // validateForm
            // Parameters: None
            // Purpose: To validate the adopt form
            // returns: A boolean representing if the form should be submitted
            function validateForm() {
                userInfo = document.querySelectorAll(".userInfo");
                for (let i = 0; i < userInfo.length - 1; i++) {
                    if (userInfo[i].value == "") {
                        alert("Missing " + userInfo[i].name + ". Please enter " + userInfo[i].name + " information");

                        return false;
                    }
                }

                email = userInfo[userInfo.length - 1].value;
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
                <a class="newTabs" href="index.html"><img src="images/cart.png" width="20"></a>
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
            <a class="tabs" href="adoption.php" id="current"> ADOPT A DOG</a>
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
            <li>
                <a class="tabs" href="items.php"> DOG PRODUCTS </a>
            </li>
        </ul>

        <button class="hamburger">
            <div class="menuIcon material-icons"> menu</div>
            <div class="closeIcon material-icons"> close</div>
        </button>

        
        <div class="content">
            <h1>Adopt a Dog!</h1>
            <script>
                function getDogInfo() {
                    const apiKey = "live_Z9Tg1JsWcpEvvoHwH0SjO8tjwBycis9SYiuEWT0CdbWNEzqKqbCz1b9F0RMWkrCY";
                    const breedInput = document.getElementById('breedInput');
                    const nameElement = document.getElementById("name");
                    const bredForElement = document.getElementById("bredFor");
                    const lifeSpanElement = document.getElementById("lifeSpan");
                    const temperamentElement = document.getElementById("temperament");
                    const errorElement = document.getElementById("error");
                    const heightElement = document.getElementById("height");
                    const weightElement = document.getElementById("weight");
                    const titleElement = document.getElementById("title");


                    const breed = breedInput.value.toLowerCase();

                    fetch(`https://api.thedogapi.com/v1/breeds/search?q=${breed}`, {
                        headers: {
                            'x-api-key': apiKey
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('API Response:', data);

                        if (data.length > 0) {
                            const breedInfo = data[0];
                            titleElement.innerHTML = "<br>";
                            nameElement.innerHTML = `<b class="dogName">${breedInfo.name}</b>`;
                            bredForElement.innerHTML = `<b> Bred For: </b> ${breedInfo.bred_for}`;
                            lifeSpanElement.innerHTML = `<b>Life Span: </b>${breedInfo.life_span}`;
                            temperamentElement.innerHTML = `<b>Temperament: </b>${breedInfo.temperament}`;
                            heightElement.innerHTML = `<b>Average Height: </b>${breedInfo.height.imperial} inches`;
                            weightElement.innerHTML = `<b>Average Weight: </b>${breedInfo.weight.imperial} pounds`;
                            errorElement.innerHTML = "";
                        } else {
                            titleElement.innerHTML = "<br>";
                            nameElement.innerHTML = "";
                            bredForElement.innerHTML = "";
                            lifeSpanElement.innerHTML = "";
                            temperamentElement.innerHTML = "";
                            heightElement.innerHTML = "";
                            weightElement.innerHTML = "";
                            errorElement.innerHTML = "Breed not found. Check spelling or try another one.";
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching breed information:', error);
                        alert('Error fetching breed information. Please try again.');
                    });
                }
            </script>
            <div class="breed-wrapper">
                <div class="breeds">
                    <h2> Not sure which dog breed is right for you? </h2>
                    <h3> Learn more about one you're interested in here. </h3>
                    <div class="search-container">
                        <label for="breedInput">Enter a dog breed: </label>
                        <input class="dog-input" type="text" id="breedInput">
                        <button onclick="getDogInfo()">Search</button>
                    </div>
                </div>
                <div class="wrapper">
                    <div id="title" class="info" style="text-align: center; font-weight: bold; font-size: 20px;">Breed information loads here</div>
                    <div id="name" class="info"></div>
                    <div id="bredFor" class="info"></div>
                    <div id="lifeSpan" class="info"></div>
                    <div id="temperament" class="info"></div>
                    <div id="error" class="info"></div>
                    <div id="height" class="info"></div>
                    <div id="weight" class="info"></div>
                </div>    
            </div>
            
            <div class="row" id="row1">
                <div class="column">
                    <div id="information">
                        <h2>Adoption Responsibilities and Guidelines:</h2>
                        <p>Welcome to our dog adoption page! We're thrilled that you're considering adopting a furry friend. Dog adoption is a rewarding experience, but it also comes with significant responsibilities. This page is designed to guide you through the adoption process and allow you to submit a request for adoption</p>

                        <h3>Adoption Process Overview</h3>
                        <p>Adopting a dog is a multi-step process to ensure the best fit for both you and the dog. Here's a brief overview of what to expect:</p>
                        <ol>
                            <li><strong>Application Submission: </strong>Start by submitting an adoption application on our website.</li>
                            <li><strong>Screening:</strong> Our team will review your application and may conduct a home visit.</li>
                            <li><strong>Approval:</strong> If your application is approved, you can proceed with adopting a dog</li>
                        </ol>

                        <h3>Dog Adoption Criteria</h3>
                        <p>To adopt a dog, you should meet the following criteria:</p>
                        <ol>
                            <li><strong>Age:</strong> You must be at least 18 years old to adopt.</li>
                            <li><strong>Residence:</strong> You should have a stable living environment suitable for a dog.</li>
                        </ol>

                        <h3>Choosing the Right Dog</h3>
                        <p>Selecting the right dog for your lifestyle is crucial. Consider factors like size, breed, energy level, and temperament when making your decision.</p>

                        <h3>Time Commitment</h3>
                        <p>Dogs require daily care, including feeding, grooming, exercise, and training. Plan to spend several hours each day with your new companion.</p>

                        <h3>Financial Responsibility</h3>
                        <p>Adoption fees are just the beginning. Be prepared for ongoing costs, including food, veterinary care, grooming, and unexpected expenses.</p>

                        <h3>Exercise, Play, and Nutrition</h3>
                        <p>Dogs need daily exercise and playtime to stay happy and healthy. Daily walks and interactive play are important.Also choose high-quality dog food and establish a regular feeding schedule. Consult with your vet for dietary recommendations.
                        </p>

                        <h3>Veterinary Care</h3>
                        <p>Regular vet visits for vaccinations, check-ups, and preventive care are essential. Spaying or neutering is also crucial for your dog's health and well-being.</p>

                        <h3>Additional Questions and Information</h3>
                        <div class="button">
                            <div class="contact">
                                <a href="contact.html">Contact Us!</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column">
                    <h2>Adoption Request</h2>
                    <!-- give form event handler for submitting -->
                    <form onsubmit="return validateForm()" action="#">

                        <p><label>First Name*:</label> <input class="userInfo"
                            type="text"  name='first name' /></p>
                        <p><label>Last Name*:</label>  <input class="userInfo"
                            type="text"  name='last name' /></p>
                        <p><label>Street*:</label> <input class="userInfo"
                            type="text" name='street' /></p>
                        <p><label>City*:</label> <input class="userInfo"
                            type="text" name='city' /></p>
                        <p><label>Email*:</label> <input class="userInfo"
                            type="email"  name='email' /></p>
        
                        <table border="0" cellpadding="3">
                          <tr>
                            <th>Choose a Dog!</th>
                          </tr>

                        <?php
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
                                
                            //select the database
                            $conn->select_db($db);

                            //run a query
                            $sql = "SELECT * FROM dogs";
                            $result = $conn->query($sql);
                            $output = "";
                            $output .= "<td class = 'selectQuantity'>";
                            $output .= "<select name= 'quan' size='1'>";

                            while($row = $result->fetch_array()) 
                            {
                                $output .= '<option> "' . $row['dogName'] . '"' . ' the ' . $row['breed'] . ', age ' . $row['dogAge'] . '</option>';
                            }

                            $output .= "</select></td>";
                            echo $output;
                        ?>

                        </table>

                        <h3>Optional Services</h3>
                        <table border="0" cellpadding="3">
                            <tr>
                                <th>Choice</th>
                                <th>Service</th>
                                <th>Price</th>
                              </tr>
                            <script>
                                //make a table for the services we have
                                var p=""
                                for (i = 0; i < services.length; i++) {
                                    p += "<tr>";
                                    p += tableData("<select name='" + i + "'> <option value=\"no\">No</option> <option value=\"yes\">Yes</option> </select>", "choice")
                                    p += tableData(services[i].name, 
                                                    "serviceName");
                                    p += tableData("$" + 
                                          services[i].cost.toFixed(2), "cost");
                                    p += "</tr>"
                                }
                                document.write(p);
                            </script>
                        </table>

                        <p class="subtotal:"><label>Subtotal:</label>
                           $ <input type="text"  name='subtotal' id="subtotal" 
                                value="0" readonly/>
                        </p>
                        <p class="tax"><label>Mass tax 6.25%:</label>
                          $ <input type="text" value="0" name='tax' id="tax" 
                                   readonly/>
                        </p>
                        <p class="total"><label>Total:</label> $ 
                            <input type="text" value="0" name='total' 
                                   id="total" readonly/>
                        </p>
                        
                        <input type ="submit" value = "Submit Order" />
                        
                        </form>
                        

                        
                        
                </div>
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