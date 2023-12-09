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

// Prepare and execute SQL query
$query = "SELECT Item, quantity, Price FROM cart INNER JOIN DogProducts ON cart.productID = DogProducts.productID WHERE userID='$userID'";
$result = $conn->query($query);
$output_page = "<html><head></head><body><h1>Shopping Cart</h1><ul>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $item = $row['Item']; 
        $quantity = $row['quantity'];
        $price = $row['Price'];
        $totalprice = $quantity * $price;
        $output_page .= "<li> $quantity x $item @ $price = $totalprice </li>";
    }
}

$output_page .= "<ul>
</body>
</html>";
echo $output_page;
    
$conn->close();
?>
