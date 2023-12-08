<?php 
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: login.php");
    exit();
}

// Retrieve user's email from the session
$email = $_SESSION['user'];


// Establish connection info
$server = "localhost"; 
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
?>
    <html>
    <head></head>
    <body>
        <h1>Dashboard</h1>
        <h2>Welcome, <?php echo htmlspecialchars($userID . '  ' .  $firstName . ' ' . $lastName); ?></h2>
    </body>
    </html>

<?php
    $conn->close();
?>
