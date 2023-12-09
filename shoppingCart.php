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

$head = "<head><meta name='viewport' content='width=device-width, initial-scale=1.0'>
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
</style></head>";

$output_page = "<html>$head<body><h1>Shopping Cart</h1>";

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
</body>
</html>";

echo $output_page;
    
$conn->close();
?>
