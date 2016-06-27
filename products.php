<!DOCTYPE html>
<html lang="en"> 
    <head> 
        <meta charset="utf-8">
        <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="images/map.gif" rel="icon" type="image/x-icon" />
    <script type="text/javascript" src="myscript.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript">

(function($) {
    $(document).ready(function () {
        /*-------------------- EXPANDABLE PANELS ----------------------*/
        var panelspeed = 300; //Panel Opening SPeed
        var totalpanels = 7; //total number of collapsible panels (one per product line)
        var defaultopenpanel = 0; //Starting with all panels closed until user selection
        var accordian = true; //Allow for one panel to be open, will close other ones
        //Change to False to allow several panels open simulateously.
        var panelheight = new Array();
        var currentpanel = defaultopenpanel;
        var iconheight = parseInt($('.icon-close-open').css('height'));
        var highlightopen = true;
 
        //Initialise collapsible panels
        function panelinit() {
                for (var i=1; i<=totalpanels; i++) {
                    panelheight[i] = parseInt($('#cp-'+i).find('.expandable-panel-content').css('height'));
                    $('#cp-'+i).find('.expandable-panel-content').css('margin-top', -panelheight[i]);
                    if (defaultopenpanel == i) {
                        $('#cp-'+i).find('.icon-close-open').css('background-position', '0px -'+iconheight+'px');
                        $('#cp-'+i).find('.expandable-panel-content').css('margin-top', 0);
                    }
                }
        }
 
        $('.expandable-panel-heading').click(function() {
            var obj = $(this).next();
            var objid = parseInt($(this).parent().attr('ID').substr(3,2));
            currentpanel = objid;
            if (accordian == true) {
                resetpanels();
            }
 
            if (parseInt(obj.css('margin-top')) <= (panelheight[objid]*-1)) {
                obj.clearQueue();
                obj.stop();
                obj.prev().find('.icon-close-open').css('background-position', '0px -'+iconheight+'px');
                obj.animate({'margin-top':0}, panelspeed);
                if (highlightopen == true) {
                    $('#cp-'+currentpanel + ' .expandable-panel-heading').addClass('header-active');
                }
            } else {
                obj.clearQueue();
                obj.stop();
                obj.prev().find('.icon-close-open').css('background-position', '0px 0px');
                obj.animate({'margin-top':(panelheight[objid]*-1)}, panelspeed);
                if (highlightopen == true) {
                    $('#cp-'+currentpanel + ' .expandable-panel-heading').removeClass('header-active');
                }
            }
        });
 
        function resetpanels() {
            for (var i=1; i<=totalpanels; i++) {
                if (currentpanel != i) {
                    $('#cp-'+i).find('.icon-close-open').css('background-position', '0px 0px');
                    $('#cp-'+i).find('.expandable-panel-content').animate({'margin-top':-panelheight[i]}, panelspeed);
                    if (highlightopen == true) {
                        $('#cp-'+i + ' .expandable-panel-heading').removeClass('header-active');
                    }
                }
            }
        }
 
        $(window).load(function() {
            panelinit();
        }); //END LOAD
    }); //END READY
})(jQuery);
// SOURCE: http://www.webdevdoor.com/jquery/expandable-collapsible-panels-jquery
    </script>

<style>
h2, p, ol, ul, li {
    margin:0px;
    padding:0px;
    font-size:13px;
    font-family:Arial, Helvetica, sans-serif;
}
 
#container {
    width:90%;
    margin:auto;
    margin-top:100px;
}
 
/* --------- COLLAPSIBLE PANELS ----------*/
.expandable-panel {
    width:100%;
    position:relative;
    min-height:50px;
    overflow:auto;
    margin-bottom: 20px;
}
.expandable-panel-heading {
    width:100%;
    cursor:pointer;
    border-radius: 15px;
    min-height:50px;
    clear:both;
    background-color:#4d79ff;
    position:relative;
}
.expandable-panel-heading:hover {
    color:white;
}
.expandable-panel-heading h2 {
    padding:14px 10px 9px 15px;
    font-size:18px;
    line-height:20px;
}
.expandable-panel-content {
    padding:0 15px 0 15px;
    margin-top:-999px;
}
.expandable-panel-content p {
    padding:4px 0 6px 0;
}
.expandable-panel-content p:first-child  {
    padding-top:10px;
}
.expandable-panel-content p:last-child {
    padding-bottom:15px;
}
.icon-close-open {
    width:20px;
    height:20px;
    position:absolute;
    background-image:url(icon-close-open.png);
    right:15px;
}
.expandable-panel-content img {
    float:right;
    padding-left:12px;
}
.header-active {
    background-color:#D0D7F3;
}
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

<div id="container">
    <div class="expandable-panel" id="cp-1">
        <div class="expandable-panel-heading">
            <h2>Classic Cars<span class="icon-close-open"></span></h2>
         </div>
        <div class="expandable-panel-content">
            <?php
echo "<table style='border: none;'>";
echo "<tr><th>Product Name</th><th>Vendor</th><th>Quantity in Stock</th><th>Buy Price ($)</th><th>MSRP ($)</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width:600px;'>" . parent::current(). "</td>";
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
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT productName, productVendor,quantityInStock, buyPrice, MSRP FROM products WHERE productLine='Classic Cars' ORDER BY productline ASC"); 
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
        </div></div>
 
    <div class="expandable-panel" id="cp-2">
        <div class="expandable-panel-heading">
            <h2>Motorcycles<span class="icon-close-open"></span></h2>
         </div>
        <div class="expandable-panel-content">
      <?php
echo "<table style='border: none;'>";
echo "<tr><th>Product Name</th><th>Vendor</th><th>Quantity in Stock</th><th>Buy Price ($)</th><th>MSRP ($)</th></tr>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT productName, productVendor,quantityInStock, buyPrice, MSRP FROM products WHERE productLine='Motorcycles' ORDER BY productline ASC"); 
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
        </div></div>
 
  <div class="expandable-panel" id="cp-3">
     <div class="expandable-panel-heading">
         <h2>Planes<span class="icon-close-open"></span></h2>
     </div>
     <div class="expandable-panel-content">
         <?php
echo "<table style='border: none;'>";
echo "<tr><th>Product Name</th><th>Vendor</th><th>Quantity in Stock</th><th>Buy Price ($)</th><th>MSRP ($)</th></tr>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT productName, productVendor,quantityInStock, buyPrice, MSRP FROM products WHERE productLine='Planes' ORDER BY productline ASC"); 
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
     </div></div> 
 
<div class="expandable-panel" id="cp-4">
     <div class="expandable-panel-heading">
         <h2>Ships<span class="icon-close-open"></span></h2>
     </div>
     <div class="expandable-panel-content">
         <?php
echo "<table style='border: none;'>";
echo "<tr><th>Product Name</th><th>Vendor</th><th>Quantity in Stock</th><th>Buy Price ($)</th><th>MSRP ($)</th></tr>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT productName, productVendor,quantityInStock, buyPrice, MSRP FROM products WHERE productLine='Ships' ORDER BY productline ASC"); 
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
     </div></div> 

<div class="expandable-panel" id="cp-5">
     <div class="expandable-panel-heading">
         <h2>Trains<span class="icon-close-open"></span></h2>
     </div>
     <div class="expandable-panel-content">
                  <?php
echo "<table style='border: none;'>";
echo "<tr><th>Product Name</th><th>Vendor</th><th>Quantity in Stock</th><th>Buy Price ($)</th><th>MSRP ($)</th></tr>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT productName, productVendor,quantityInStock, buyPrice, MSRP FROM products WHERE productLine='Trains' ORDER BY productline ASC"); 
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
     </div></div> 

<div class="expandable-panel" id="cp-6">
     <div class="expandable-panel-heading">
         <h2>Trucks and Buses<span class="icon-close-open"></span></h2>
     </div>
     <div class="expandable-panel-content">
                  <?php
echo "<table style='border: none;'>";
echo "<tr><th>Product Name</th><th>Vendor</th><th>Quantity in Stock</th><th>Buy Price ($)</th><th>MSRP ($)</th></tr>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT productName, productVendor,quantityInStock, buyPrice, MSRP FROM products WHERE productLine='Trucks and Buses' ORDER BY productline ASC"); 
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
     </div></div> 

<div class="expandable-panel" id="cp-7">
     <div class="expandable-panel-heading">
         <h2>Vintage Cars<span class="icon-close-open"></span></h2>
     </div>
     <div class="expandable-panel-content">
         <?php
echo "<table style='border: none;'>";
echo "<tr><th>Product Name</th><th>Vendor</th><th>Quantity in Stock</th><th>Buy Price ($)</th><th>MSRP ($)</th></tr>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT productName, productVendor,quantityInStock, buyPrice, MSRP FROM products WHERE productLine='Vintage Cars' ORDER BY productline ASC"); 
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
?>     </div></div> 

</div>
<!-- Footer with External Links -->
<?php include('footer.php'); ?>
</body>
</html>
