<!DOCTYPE html>
<html lang="en"> 
    <head> 
        <meta charset="utf-8">
        <title>Customers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="images/map.gif" rel="icon" type="image/x-icon" />
    <script type="text/javascript" src="myscript.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript">

    </script>
<style>
body { 
    background-image: url("images/background.jpg");
    background-size: cover;
    background-color: white;
    background-repeat: no-repeat;
    background-attachment: absolute;
}
#footer {
    width: 5%;
    position:fixed;
    float:left;
    margin: auto;
    bottom: 0;
}
</style>

    </head>
<?php include('header.php'); ?>

<body style="margin:0px; padding:0px;">

  <div class="transbox">
    <div></div>

<?php
echo "<table style='border: none;'>";
echo "<tr><th>Customer</th><th>Country</th><th>Phone</th><th>Address</th><th>City</th><th>State</th><th>Postal Code</th><th>Sales Rep Number</th><th>Credit Limit</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width:600px;border:1px solid black;'>" . parent::current(). "</td>";
    }
    function beginChildren() { 
        echo "<tr>"; 
    } 
    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT customerName, country, phone, addressLine1, city, state, postalCode, salesRepEmployeeNumber, creditLimit FROM customers ORDER BY country ASC"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>
</div>
<br>

<!-- Footer with External Links -->
<?php include('footer.php'); ?>
</body>
</html>