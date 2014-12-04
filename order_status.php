<?php

include 'include.php';

$invoice_id = intval($_GET['invoice_id']);
$product_url = '';
$price_in_usd = 0;
$price_in_btc = 0;
$amount_paid_btc = 0;
$amount_pending_btc = 0;
try {
    $dbconnect = new PDO("mysql:host=" . $mysql_host .  ";dbname=" . $mysql_database, $mysql_username, $mysql_password);
    
    
} catch (PDOException $e) {
    print "Erreur !: Unable to select database. Run setup first. <br/>";
    die();
}
//find the invoice form the database
$result = $dbconnect->query("select price_in_usd, product_url, price_in_btc from invoices where invoice_id = $invoice_id");
        
if (!$result) {
    die(__LINE__ . ' Invalid query: ' . mysql_error());
}

foreach($result as $row){ 
	$product_url = $row['product_url'];  
	$price_in_usd = $row['price_in_usd'];
	$price_in_btc = $row['price_in_btc'];  
}

//find the pending amount paid
$result = $dbconnect->query("select value from pending_invoice_payments where invoice_id = $invoice_id");
         
foreach($result as $row){ 
	 $amount_pending_btc += $row['value'];   
}

//find the confirmed amount paid
$result = $dbconnect->query("select value from invoice_payments where invoice_id = $invoice_id");
         
foreach($result as $row){ 
	$amount_paid_btc += $row['value']; 
}

?>

<html>
<head>
</head>
<body>
<img src="invoice.png">

<h2>Invoice <?php echo $invoice_id ?> </h2>
<p>
Amount Due : <?php echo $price_in_usd ?> USD (<?php echo $price_in_btc ?> LDC) 
</p>

<p>
Amount Pending : <?php echo $amount_pending_btc ?> LDC
</p>

<p>
Amount Confirmed : <?php echo $amount_paid_btc ?> LDC
</p>
<?php if ($amount_paid_btc  == 0 && $amount_pending_btc == 0) { ?> 
Payment not received.
<?php } else if ($amount_paid_btc < $price_in_btc) { ?> 
<p>
Waiting for Payment Confirmation: <a href="order_status.php?invoice_id=<?php echo $invoice_id ?>">Refresh</a>
</p>
<?php } else { ?>
<p>
Thank You for your purchase
</p>
<img src="nutbolt.jpg">
<?php } ?>

</body>
</html>