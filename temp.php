<?php
$servername = "localhost";
$un = "root";
$pw = "";
$db = "restaurant_management";

// CREATE CONNECTION
$conn = new mysqli($servername, $un, $pw);
if($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// CREATE DATABASE
$sql = "CREATE DATABASE " . $db;
if($conn->query($sql) !== TRUE)
{
    echo "Error creating database: " . $conn->error;
}

// CONNECT TO NEW DATABASE
$conn = new mysqli($servername, $un, $pw, $db);
if($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE customer_signup(
    cust_name VARCHAR(30) NOT NULL,
    email VARCHAR(40) NOT NULL,
    pw VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(8) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    adr VARCHAR(40) NOT NULL,
    cuisines VARCHAR(20),
    payment VARCHAR(30) NOT NULL
)";
if($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE book_table(
    cust_name VARCHAR(30) NOT NULL,
    no_of_people INT(3) NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time DATETIME NOT NULL
)";
if($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE query_ques(
    cust_name VARCHAR(30) NOT NULL,
    email VARCHAR(40) NOT NULL,
    title_message VARCHAR(20) NOT NULL,
    query VARCHAR(60) NOT NULL
)";
if($conn->query($sql) !== TRUE)
{
    echo "Error creating table: " . $conn->error;
}

if(isset($_POST["ride_owner_login"]))
{
    $email = $_POST["email"];
    $ride = $_POST["ride"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM customer_signup WHERE email='$email' AND pw='$password'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        header("Location: fork.html");
    }
    else
    {
        $message = "";
        header("Location: signin_customer.html");
    }
}

if(isset($_POST["passenger_login"]))
{
    $email = $_POST["email"];
    $password = $_POST["password"];
}

if(isset($_POST["signup"]))
{
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $password = $_POST["pw"];
    $dob = $_POST["date_of_birth"];
    $gender = $_POST["gender"];
    $phone = $_post["phone"];
    $locality = $_POST["locality"];
    $city = $_POST["city"];
    $state = $_POST["states"];
    $pincode = $_POST["pincode"];
    $cuisine = $_POST["occupation"];
    $payment = $_POST["marital_status"];
    $sql = "SELECT * FROM customer_signup WHERE email='$email'";
    $result = $conn->query($sql);
    if($result->num_rows == 0)
    {
        $adr = $locality . ", " . $city . ", " . $state . ", " . $pincode;
        $sql = "INSERT INTO customer_signup(cust_name, email, pw, date_off_birth, gender, phone, adr, cuisine, payment) VALUES ('$fname', '$email', '$pw', '$dob', 'gender', 'phone', '$adr', '$cuisine', '$payment')";
        if($conn->query($sql) !== TRUE)
        {
            echo "Error creating table: " . $conn->error;
        }
        header("Location: signin_customer.html");
    }
    else
    {
        $message = "USER ALREADY EXISTS.";
    }
}

if($_POST["submit"] === "Book my table!")
{
    $source = $_POST["source"];
    $dest = $_POST["destination"];
    $dor = $_POST["date_of_ride"];
    $tor = $_POST["time_of_ride"];
    $sql = "INSERT INTO book_table VALUES ('$source', '$dest', '$dor', '$tor')";
    if($conn->query($sql) !== TRUE)
    {
        echo "Error creating table: " . $conn->error;
    }
    header("Location: profile.html");
}
?>