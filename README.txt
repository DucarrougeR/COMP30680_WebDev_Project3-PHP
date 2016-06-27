===========================================================================================================================
a) implementing	the	page	index.php.

The page displays all the different Product Lines along with their respective description

===========================================================================================================================
b) implementing	the	page	products.php.

When the page is loaded, it displays each individual product line.
When user clicks on a particular product line, the detailed information associated withthat product line
 
===========================================================================================================================
c) implementing	the	page	customers.php.

===========================================================================================================================
d) implementing	the	page	orders.php.

1st Table to display all the required datafield information for orders with status "IN PROCESS" using the following query:
		SELECT DISTINCT orders.orderNumber, orders.orderDate, orders.status,  products.productCode, productLine, productName, comments 
        FROM Orders 
        INNER JOIN Orderdetails ON Orders.orderNumber=Orderdetails.orderNumber 
        INNER JOIN Products ON Orderdetails.productCode=Products.productCode 
        WHERE orders.status = 'In Process' 
        ORDER BY orderNumber ;"	

2nd Table to display all the required datafield information for orders with statuts "CANCELLED" with the following query:
		SELECT orders.orderNumber, orders.orderDate, orders.status,  products.productCode, productLine, productName, comments 
        FROM Orders 
        INNER JOIN Orderdetails ON Orders.orderNumber=Orderdetails.orderNumber 
        INNER JOIN Products ON Orderdetails.productCode=Products.productCode 
        WHERE orders.status = 'Cancelled' 
        ORDER BY orderNumber ;

3rd Table to display all the following datafield for 20 recent orders according to the following queries:
		SELECT DISTINCT orders.orderNumber, orders.orderDate, orders.status,  products.productCode, productLine, productName, comments 
        FROM Orders 
        INNER JOIN Orderdetails ON Orders.orderNumber=Orderdetails.orderNumber 
        INNER JOIN Products ON Orderdetails.productCode=Products.productCode 
        ORDER BY orderNumber DESC LIMIT 20;

===========================================================================================================================
e) implementing	appropriate	and	effective	error	handling.

Upon connection with database, implemented line of code to allow for correct character encoding for French, German and
other languages containing specific characters.

===========================================================================================================================
f) creating	a	navigation bar	and	footer	in	separate	files	and	including	them	in	all	pages.

Navigation bar (called 'header.php') as well as the footer (called 'footer.php') are both independent php files.
They are both used on each individual pages (index.php, products.php, customers.php, orders.php) as required.
Navigation bar offers internal links to navigate between various web page.
Footer offers external links to various social website (Github, facebook, linkedin...)
Got the footer to have a position fixed (always at bottom of page) and on the bottom left side of page to
allow for constant display while not affecting the information tables.

===========================================================================================================================
g) making	good	use of	HTML and CSS	to create a	clean	and	consistent overall	design.

HTML and CSS are formatting the various tables for the database information to display on the web page in a consistent fashion
Each page's data table is formatted according to the same styling for a clean result.

