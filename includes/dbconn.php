 <?php
$servername = "localhost";
$username = "root";
$password = "";

//Create db
$sql = "";
try {
    $pdo = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS dairy";
    // use exec() because no results are returned
    $pdo->query($sql);
    //echo "Database created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

//Create tables
$sql2 = "";
try {
    $conn = new PDO("mysql:host=$servername;dbname=dairy", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // sql to create table
    $t1 = "CREATE TABLE IF NOT EXISTS farmers (
    fmid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    ID VARCHAR(10) NOT NULL,
	phone VARCHAR(15) NOT NULL,
	username VARCHAR(30) NOT NULL,
	password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP
    )";
	
	$t2 = "CREATE TABLE IF NOT EXISTS h_officers (
    hid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    ID VARCHAR(10) NOT NULL,
	phone VARCHAR(15) NOT NULL,
	emp_no VARCHAR(15) NOT NULL,
	username VARCHAR(30) NOT NULL,
	password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP
    )";
	
	$t3 = "CREATE TABLE IF NOT EXISTS cattle (
    cid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fmid INT(15) NOT NULL, /*The farmer*/
    type VARCHAR(50) NOT NULL, /*cow or goat*/
    tag VARCHAR(30) NOT NULL,
    breed VARCHAR(50) NOT NULL,
    /*image VARCHAR(50) NOT NULL,*/
	age INT(15) NOT NULL,
	b_price INT(15) NOT NULL,
    sold VARCHAR(50) NOT NULL, /*yes or no or on sale*/
    reg_date TIMESTAMP
    )";
	
	$t4 = "CREATE TABLE IF NOT EXISTS production (
    pid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fmid INT(15) NOT NULL, /*The farmer*/
	cid INT(15) NOT NULL,/*The cow or goat that produced it*/
    type VARCHAR(50) NOT NULL, /*milk or manure*/
    quantity INT(10) NOT NULL, /*litres of milk or kgs of manure*/
	prod_date VARCHAR(30) NOT NULL, /*Date of production*/
	value INT(15) NOT NULL, /*Current value of that production*/
    tot_value INT(15) NOT NULL, /*Accumulated value of that production for that animal*/
    reg_date TIMESTAMP
    )";

   	$t5 = "CREATE TABLE IF NOT EXISTS employees (
    eid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fmid INT(15) NOT NULL, /*The farmer*/
	idno INT(15) NOT NULL,
	role VARCHAR(50) NOT NULL,
	wage int(15) NOT NULL,
    name VARCHAR(50) NOT NULL,
    address VARCHAR(50) NOT NULL,
	phone VARCHAR(15) NOT NULL,
    reg_date TIMESTAMP
    )";
	
	$t6 = "CREATE TABLE IF NOT EXISTS treatment (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fmid INT(15) NOT NULL, /*The farmer*/
	cid INT(15) NOT NULL, /*The cattle id*/
    disease VARCHAR(50) NOT NULL,
    treat_date VARCHAR(50) NOT NULL,
	charges INT(15) NOT NULL,
    tot_charges INT(15) NOT NULL,
    reg_date TIMESTAMP
    )";

    $t7 = "CREATE TABLE IF NOT EXISTS practices (
    pid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    practice VARCHAR(200) NOT NULL,
    age VARCHAR(50) NOT NULL,
    frequency VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP
    )";

    $t8 = "CREATE TABLE IF NOT EXISTS diseases (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    signs VARCHAR(200) NOT NULL,
    fmid INT(15) NOT NULL, /*The farmer*/
    disease VARCHAR(50) NOT NULL,
    control VARCHAR(50) NOT NULL,
    treatment VARCHAR(50) NOT NULL,
	administration VARCHAR(50) NOT NULL,
    price INT(15) NOT NULL,
    reg_date TIMESTAMP
    )";

    $t9 = "CREATE TABLE IF NOT EXISTS feeds (
    fid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fmid INT(15) NOT NULL, /*The farmer*/
	type VARCHAR(50) NOT NULL, /*fodder/supplements*/
    cattle VARCHAR(50) NOT NULL,/*is it for cows, goats or all?*/
    total int(15) NOT NULL, /*Total cattle */
	quantity int(15) NOT NULL,
	cost int(15) NOT NULL, /*Total cost of the feed, total feeding costs will be calculated using SUM()*/
    per_cattle int(15) NOT NULL, /*The cost per cattle (total cost/cattle) */
    reg_date TIMESTAMP /*Also to serve as record date, we assume the farmer will be recording immediately */
    )";

    $t10 = "CREATE TABLE IF NOT EXISTS prices (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fmid INT(15) NOT NULL, /*The farmer*/
	product VARCHAR(50) NOT NULL, 
    fromDate VARCHAR(50) NOT NULL,
    price int(15) NOT NULL,
    reg_date TIMESTAMP
    )";
    
    
    $t11 = "CREATE TABLE IF NOT EXISTS sales (
    sid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fmid INT(15) NOT NULL, /*The farmer*/
    type VARCHAR(5) NOT NULL, /*the cattle*/
    cid INT(9) NOT NULL, 
	b_price INT(9) NOT NULL, 
    labour INT(9) NOT NULL,
    feeding INT(9) NOT NULL,
    treatment INT(9) NOT NULL,
    production int(15) NOT NULL,
    s_price INT(9) NOT NULL,
    profit INT(9) NOT NULL,
    bot VARCHAR(5) NOT NULL, /*yes or no*/
    reg_date TIMESTAMP
    )";

    // use exec() because no results are returned
    $conn->query($t1);
	$conn->query($t2);
	 $conn->query($t3);
	$conn->query($t4);
    $conn->query($t5);
	$conn->query($t6);
	 $conn->query($t7);
	$conn->query($t8);
    $conn->query($t9);
    $conn->query($t10);
    $conn->query($t11);
    //echo "Tables created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
	
	
$conn->query("use dairy");
?> 