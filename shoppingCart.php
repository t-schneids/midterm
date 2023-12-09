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
$showAllQuery = "SELECT cart.productID,Item, quantity, Price, Image FROM cart INNER JOIN DogProducts ON cart.productID = DogProducts.productID WHERE userID='$userID'";

function removeItemQuery($itemID){
    global $userID;
    return "DELETE FROM cart WHERE userID = '$userID' AND productID = '$itemID'";
}
 
//If reoveItem is set, run query. s
if (isset($_GET['removeItem'])){
    $itemID = $_GET['removeItem'];
    $query = removeItemQuery($itemID);
    $result = $conn->query($query);
    echo "success";
}

function generateCartRowByID($itemID){
    return "<tr id='cartRow$itemID'></tr>";
}



//Code to build page to display
//head

//Event handling script
$script = "<script>
function getTotalPrice() {
    var totalOrderPrice = 0;
    $('.totalPriceCell').each(function() {
        // Assuming the content within the <td> elements are numeric values
        var cellValue = parseFloat($(this).text()); 

        // Check if cellValue is a valid number
        if (!isNaN(cellValue)) {
            totalOrderPrice += cellValue; // Accumulating the total
        }
    });
    return totalOrderPrice;
}


$(document).ready(function(){
    $('.removeItemButton').click(function(){
        itemID = $(this).attr('id');
        $.ajax({type: 'GET', 
                data: {'removeItem' : itemID}, 
                success: function(response){
                            $('#cartRow' + itemID).css('display', 'none');
                            $('#cartRow' + itemID).remove();
                            $('#totalOrderPriceDiv').html(getTotalPrice());
                        },
                error: function(){alert('error removing item ' + itemID);}
        });
    });
});
</script>";

//Header for output page
$head = "<head><meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link rel='stylesheet' href='general.css'>
<script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>$script

<style type='text/css'>
    .prodImgs{
        max-width : 50px;
        max-height : 50px;
    }
    #cartTable, #totalOrderPriceDiv, td{
        border : 1px solid black;
    }
    body{
        text-align: center;
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
</style></head>";

//final output page string
$output_page = "<html>$head <body>
<nav class='nav'>
    <ul class='navlist'>
        <div class='logo'>
            <li>
                <a href='index.html'>
                    <img src='wagonLogo.png' alt='company logo'>
                </a>
            </li>
            <li class='newTabs' id='companyName'> Rescue Waggin</li>
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
            <a class='newTabs' href='shoppingCart.php'><img src='images/cart.png' width='20'></a>
        </li>
</ul>
<ul class='tabGroup'>
    <li>
        <a class='tabs' href='aboutUs.html'> OUR STORY</a>
    </li>
    <li>
        <a class='tabs' href='rescues.html'> RECENT RESCUES</a>
    </li>
    <li>
        <a class='tabs' href='adoption.php'> ADOPT A DOG</a>
    </li>
    <li>
        <a class='tabs' href='availableDogs.php'> AVAILABLE DOGS</a>
    </li>
    <li>
        <a class='tabs' href='contact.html'> CONTACT US</a>
    </li>
    <li>
        <a class='tabs' href='events.html'> EVENTS </a>
    </li>
    <li>
        <a class='tabs' href='items.php' id='current'> DOG PRODUCTS </a>
    </li>
</ul>

<button class='hamburger'>
    <div class='menuIcon material-icons'> menu</div>
    <div class='closeIcon material-icons'> close</div>
</button>

<h1>Shopping Cart</h1>";

$cartTable = "<table id='cartTable'>";

$result = $conn->query($showAllQuery);

$totalOrderPrice = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        
        $itemID = $row['productID'];
        $item = $row['Item']; 
        $quantity = $row['quantity'];
        $price = $row['Price'];
        $image = $row['Image'];
        $totalprice = $quantity * $price;
        $totalOrderPrice += $totalprice;

        $cartTable .= "<tr id='cartRow$itemID'>";

        $cartTable .= "<td><img class='prodImgs' src='" . $row['Image']. "'/> </td><td> $quantity x </td> <td> $item </td> <td> $price </td> <td class='totalPriceCell'>$totalprice </td> <td> <button class='removeItemButton' id='$itemID'/>&#128465;</button></td> </tr>";
    }
}

$cartTable .= "</table>";

$output_page .= "$cartTable <br/>
<div id='totalOrderPriceDiv'>Order Total: $totalOrderPrice</div>
<button id='completePurchaseButton'>Checkout</button>
<footer>
<h4> &copy; 2017 Rescue Waggin' </h4>
<ul class='nav'>
    <ul class='nav'>
        <li> <a href='https://www.gmail.com'><img src='images/gmailLogo.png' style='width:25px;height:20px;'></a> </li>
        <li> <a href='https://www.instagram.com'><img src='images/instagramLogo.png' style='width:20px;height:20px;'></a> </li>
        <li> <a href='https://www.facebook.com'><img src='images/facebookLogo.png' style='width:20px;height:20px;'></a> </li>
    </ul>
</ul>
</footer>
</body>
</html>";

echo $output_page;
    
$conn->close();
?>
