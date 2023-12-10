<?php 
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: login.php");
    exit();
}

// Retrieve user's email from the session
$email = $_SESSION['user'];
$userID = $_SESSION['userID'];

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

// SQL query to Show all products in Cart
$showAllQuery = "SELECT cart.productID, Item, quantity, Price, Image FROM cart INNER JOIN DogProducts ON cart.productID = DogProducts.productID WHERE userID='$userID'";

function removeItemQuery($itemID){
    global $userID;
    return "DELETE FROM cart WHERE userID = '$userID' AND productID = '$itemID'";
}
 
// If removeItem is set, run the query
if (isset($_GET['removeItem'])){
    $itemID = $_GET['removeItem'];
    $query = removeItemQuery($itemID);
    $result = $conn->query($query);
    echo "success";
    exit();
}
// function insertIntoOrdersTable($userID, $itemName, $quantity, $date){
//     return "INSERT "
// }

//if checkout is set, run script below to submit order and exit
if (isset($_GET['checkout']) && $_GET['checkout']){
    //get items from shopping cart
    $result = $conn->query($showAllQuery);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $itemID = $row['productID'];
            $item = $row['Item']; 
            $quantity = $row['quantity'];
            $date = date('m/d/Y');
            $conn->query("INSERT INTO purchases (userID, item, quantity, date) VALUES ('$userID', '$item', '$quantity', '$date')");
            $conn->query(removeItemQuery($itemID));
        }
    }
    echo "success";
    exit();
}
// Event handling script
$script = "<script>
    function getTotalPrice() {
        var totalOrderPrice = 0;
        $('.totalPriceCell').each(function() {
            var cellValue = parseFloat($(this).text());
            if (!isNaN(cellValue)) {
                totalOrderPrice += cellValue;
            }
        });
        return totalOrderPrice;
    }

    $(document).ready(function(){
        $('#completePurchaseButton').click(function(){
                itemID = $(this).attr('id');
                $.ajax({
                    type: 'GET', 
                    data: {'checkout' : true}, 
                    success: function(response){
                        alert('Thank you for your support! Your order has been submitted');
                        window.location = 'dashboard.php';
                    },
                    error: function(){alert('Sorry, we cannot complete your purchase at the moment.' + itemID);}
                });
        });

        $('.removeItemButton').click(function(){
            itemID = $(this).attr('id');
            $.ajax({
                type: 'GET', 
                data: {'removeItem' : itemID}, 
                success: function(response){
                    $('#cartRow' + itemID).css('display', 'none');
                    $('#cartRow' + itemID).remove();
                    $('#totalOrderPriceSpan').html(getTotalPrice().toFixed(2));
                },
                error: function(){alert('error removing item ' + itemID);}
            });
        });
    });
</script>";

// Header for output page
$head = "<head>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <link rel='stylesheet' href='general.css'>
    <link rel='stylesheet' href='shoppingCart.css'>
    <script src='general.js'></script>
    <script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>
    $script
</head>";

// Final output page string
$output_page = "<html>$head <body>
    <nav class='nav'>
        <ul class='navlist'>
            <div class='logo'>
                <li>
                    <a href='index.html'>
                        <img src='wagonLogo.png' alt='company logo'>
                    </a>
                </li>
                <li class='newTabs' id='companyName'>Rescue Waggin</li>
            </div>
        </ul>
    </nav>

    <ul class='profile'>
        <li>
            <a class='newTabs' href='dashboard.php'>Dashboard</a>
        </li>
    </ul>
    
    <ul class='cart'>
        <li>
            <a class='newTabs' href='shoppingCart.php' id='current'><img src='images/cart.png' width='20'></a>
        </li>
    </ul>
    
    <ul class='tabGroup'>
        <li><a class='tabs' href='aboutUs.html'>OUR STORY</a></li>
        <li><a class='tabs' href='rescues.html'>RECENT RESCUES</a></li>
        <li><a class='tabs' href='adoption.php'>ADOPT A DOG</a></li>
        <li><a class='tabs' href='availableDogs.php'>SEE OUR DOGS</a></li>
        <li><a class='tabs' href='contact.html'>CONTACT US</a></li>
        <li><a class='tabs' href='events.html'>EVENTS</a></li>
        <li><a class='tabs' href='items.php'>DOG PRODUCTS</a></li>
    </ul>

    <button class='hamburger'>
        <div class='menuIcon material-icons'>menu</div>
        <div class='closeIcon material-icons'>close</div>
    </button>

    <h1>Shopping Cart</h1>";

$cartTable = "<table id='cartTable'>
    <tr>
        <th>&nbsp;</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
        <th>Remove</th>
    </tr>";

//run query to display cart table. 
$result = $conn->query($showAllQuery);

$totalOrderPrice = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        
        $itemID = $row['productID'];
        $item = $row['Item']; 
        $quantity = $row['quantity'];
        $price = $row['Price'];
        $image = $row['Image'];
        $totalPrice = $quantity * $price;
        $totalOrderPrice += $totalPrice;
        $price = number_format($price, 2);
        $totalOrderPrice = number_format($totalOrderPrice, 2);
        $totalPrice = number_format($totalPrice, 2);

        $cartTable .= "<tr id='cartRow$itemID'>
            <td><img class='prodImgs' src='$image'/></td>
            <td>$item</td>
            <td>$quantity</td>
            <td class='price'>$price</td>
            <td class='totalPriceCell price'>$totalPrice</td>
            <td><button class='removeItemButton' id='$itemID'>&#128465;</button></td>
        </tr>";
    }
}

$cartTable .= "</table>";

$output_page .= "$cartTable <br/>
    <div id='totalOrderDiv'>Order Total: <span id='totalOrderPriceSpan' class='price'>$totalOrderPrice</span></div>
    <button id='completePurchaseButton'>Checkout</button>
    
    <footer>
        <h4>&copy; 2017 Rescue Waggin'</h4>
        <ul class='nav'>
            <ul class='nav'>
                <li><a href='https://www.gmail.com'><img src='images/gmailLogo.png' style='width:25px;height:20px;'></a></li>
                <li><a href='https://www.instagram.com'><img src='images/instagramLogo.png' style='width:20px;height:20px;'></a></li>
                <li><a href='https://www.facebook.com'><img src='images/facebookLogo.png' style='width:20px;height:20px;'></a></li>
            </ul>
        </ul>
    </footer>
</body>
</html>";

echo $output_page;
    
$conn->close();


?>

</script>