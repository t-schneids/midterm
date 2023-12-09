<!DOCTYPE html>
<html>
<head>
    <title> Dog Products </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="general.css">
    <!-- links library for hamburger and close icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="general.js"></script>

    <style>
        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 25px;
        }

        .content {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .content img {
            border-radius: 25px;
            background-color: rgba(152, 106, 79, 0.2);
            padding: 10px;
            border-radius: 25px;
            width: 95%;
            height: 280px;
            max-width: 394px;
        }

        .description {
            display: block;
            max-width: 400px;
            padding: 20px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px;
            background-color: rgba(209, 21, 27, 0.394);
            text-decoration: none;
            color: black;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            position: relative;
        }

        p {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;;
        }

        h2 {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;;
        }

        h1 {
            color: rgb(209,21,28);
            margin: 10px;
            font-size: 40px;
            text-align: center;
        }

        @media (max-width: 600px) {
            img {
                max-width: 300px;
            }

            .card {
                max-width: 300px;
            }
        }

        @media (max-width: 1460px) {
            .card {
                max-width: 300px;
            }

            img {
                max-width: 300px;
            }
        }
    </style>
    <script>
        function addToCart(productID) {
            var formData = $('#form' + productID).serialize();

            $.ajax({
                type: 'POST',
                url: 'processForm.php',
                data: formData,
                success: function(response) {
                    alert("Successfully added to cart!");
                    alert(response);
                    // You can update the UI or perform other actions here
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
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
            <a class="tabs" href="aboutUs.html"> OUR STORY</a>
        </li>
        <li>
            <a class="tabs" href="rescues.html"> RECENT RESCUES</a>
        </li>
        <li>
            <a class="tabs" href="adoption.php"> ADOPT A DOG</a>
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
            <a class="tabs" href="items.php" id="current"> DOG PRODUCTS </a>
        </li>
    </ul>

    <button class="hamburger">
        <div class="menuIcon material-icons"> menu</div>
        <div class="closeIcon material-icons"> close</div>
    </button>

    <h1 style="text-align: center">Dog Products</h1>
    <div class="content">
        <!-- BEGIN CARDS-->
        <?php
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

        //select the database
        $conn->select_db($db);

        //run a query
        $sql = "SELECT * FROM DogProducts";
        $result = $conn->query($sql);
        $output = "";
        $count = 1;

    while($row = $result->fetch_array())
    {
        $output .= '<div id="card' . $count . '" class="card">';
        $output .= '<form method="post" action="processForm.php" class="cart-form" id="form' . $row['productID'] . '">';
        $output .= '<img src="' . $row['Image'] . '" alt="Dog ' . $count . '">';
        $output .= '<h2>' . $row['Item'] . '</h2>';
        $output .= '<div class="description">';
        $output .= '<p>Price: $' . $row['Price'] . '</p>';
        $output .= '<p>' . $row['Description'] . '</p>';
        $output .= '<div class="quantity-container">';
        $output .= '<label for="quantity' . $count . '">Quantity:</label>';
        $output .= '<select name="quantity" id="quantity' . $count . '">';
        for ($i = 0; $i <= 10; $i++) {
            $output .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $output .= '</select>';
        $output .= '</div>';
        $output .= '<div class="button-container">';
        $output .= '<input type="hidden" name="productID" value="' . $row['productID'] . '">';
        $output .= '<button type="button" class="button addToCartButton" onclick="addToCart(' . $row['productID'] . ')">Add to Cart</button>';
        $output .= '</div> </div> </form> </div>';

            $count += 1;
        }

        echo $output;
        ?>

        <!-- END -->
    </div>

<footer>
    <h4> &copy; 2017 Rescue Waggin' </h4>
    <ul class="nav">
        <ul class="nav">
            <li> <a href="https://www.gmail.com"><img src="images/gmailLogo.png" style="width:25px;height:20px;"></a> </li>
            <li> <a href="https://www.instagram.com"><img src="images/instagramLogo.png" style="width:20px;height:20px;"></a> </li>
            <li> <a href="https://www.facebook.com"><img src="images/facebookLogo.png" style="width:20px;height:20px;"></a> </li>
        </ul>
    </ul>
</footer>

</body>
</html>
