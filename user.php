<?php
ini_set("DISPLAY_ERRORS", 1);
// Database connection details
$servername = "localhost";
$username = "u105620976_voyageDB";
$password = "voyageAdmin@123";
$dbname = "u105620976_voyage";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if action is specified
    if(isset($_POST["action"])) {
        $action = $_POST["action"];                
        // Perform CRUD operations based on action
        switch($action) {
            case "create":
                if (preg_match("/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/i", $_POST["email"])) {
                    echo "<script>alert('Err! Invalid Email.');window.location.href='./';</script>";
                }
                if(preg_match("/[0-9]{10}/", $_POST["contact"])) {
                    echo "<script>alert('Err! Invalid contact');window.location.href='./';</script>";
                }
                if(preg_match("/[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}/", $_POST["departureDate"]) || 
                    preg_match("/[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}/", $_POST["returnDate"])) {
                    echo "<script>alert('Err! Invalid departure or return date.');window.location.href='./';</script>";
                }
                if(preg_match("/[a-zA_Z]+/", $_POST["name"])) {
                    echo "<script>alert('Err! Name shouldn't be blank.');window.location.href='./';</script>";
                }
                $query="INSERT INTO user (name, email, contact, source, destination, departureDate, returnDate)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssssss",$name, $email, $contact, $source, $destination, $departureDate, $returnDate);               
                $name = $_POST["name"];
                $email = $_POST["email"];
                $contact = $_POST["contact"];
                $source = $_POST["source"];
                $destination = $_POST["destination"];
                $departureDate = $_POST["departureDate"];
                $returnDate = $_POST["returnDate"];
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Thank you! We will soon contact you.');window.location.href='./';</script>";
                } else {
                    echo "Failed to insert row.";
                }
                $stmt->close();
                break;
            case "read":
                // Example of reading records
                // Perform your read operation here, e.g., SELECT * FROM table_name
                // Fetch data and return
                break;
            case "update":
                // Example of updating a record
                if(isset($_POST["id"]) && isset($_POST["data"])) {
                    $id = $_POST["id"];
                    $data = $_POST["data"];
                    // Perform your update operation here, e.g., UPDATE table_name SET column1=value1, column2=value2, ... WHERE id=$id
                }
                break;
            case "delete":
                // Example of deleting a record
                if(isset($_POST["id"])) {
                    $id = $_POST["id"];
                    // Perform your delete operation here, e.g., DELETE FROM table_name WHERE id=$id
                }
                break;
            default:
                // Invalid action
                echo "Invalid action!";
        }
    } else {
        // No action specified
        echo "No action specified!";
    }
}

// Close connection
$conn->close();
?>
