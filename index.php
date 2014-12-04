<?php

include 'include.php';

$invoice_id = time();
$price_in_usd = 50;
$product_url = 'nutbolt.jpg';
$price_in_btc = 0.5;
try {
    $dbconnect = new PDO("mysql:host=" . $mysql_host .  ";dbname=" . $mysql_database, $mysql_username, $mysql_password);
    
    
} catch (PDOException $e) {
    print "Erreur !: Unable to select database. Run setup first. <br/>";
    die();
}


//Add the invoice to the database
$result = $dbconnect->query("replace INTO invoices (invoice_id, price_in_usd, price_in_btc, product_url) values($invoice_id,'$price_in_usd','$price_in_btc','$product_url')");
    
if (!$result) {
    die(__LINE__ . ' Invalid query: ' . $dbconnect->errorInfo());
}

?>

<html>
<head>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $blockchain_root ?>images/leadercoin.ico">
<link rel="stylesheet" type="text/css" href="<?php echo $blockchain_root ?>templates/assets/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $blockchain_root ?>Resources/wallet/pay-now-button-test.js"></script>
    
    <script type="text/javascript">
	$(document).ready(function() {
		$('.stage-paid').on('show', function() {
			//window.location.href = './order_status.php?invoice_id=<?php echo $invoice_id; ?>';
		});
	});
	</script>
    <style>body{ padding-top:80px;}</style>
</head>
    <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Exemple</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
         <li><a href="/">Home</a></li>
         <li><a href="https://github.com/Leader-Coin" target="_blank" class="purchase" title="GitHub and the leadercoin-development"><i class="fa fa-github"></i>&nbsp; GitHub</a></li>
        </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
<table width="400px" cellspacing="8" align="center" cellpadding="8">
  <tr>
    <th> <div class="starter-template">
      
        <div class="blockchain-btn"  data-create-url="create.php?invoice_id=<?=$invoice_id?>"> 
            <div class="blockchain stage-begin">
             <table width="500" border="0" align="center">
  <tr>
    <td colspan="3"><img src="invoiceIMG.png" width="678" height="500" alt=""/></td>
    </tr>
  <tr>
    <td width="88">&nbsp;</td>
    <td width="155">&nbsp;</td>
    <td width="235">&nbsp; <button class="btn btn-success" style="min-width:250px"> PAY WITH LEADERCOINS </button>
</table>

            
                
            </div>
            <div class="blockchain stage-loading" style="text-align:center">
                <img src="<?php echo $blockchain_root ?>Resources/loading.gif">
            </div>
            <div class="blockchain stage-ready" style="text-align:center">
            <table class="table table-striped" width="600" align="center" cellpadding="8" cellspacing="8">
  <tr>
    <td height="80" align="left"><span class="sum">Total: <span class='font12'> <?php echo $price_in_btc ?></span> LDC  <font color="#FF0000" size="+3"> Payment test</font></span></td>
    <td align="right"><img src="leader_coin_cartoon.png" width="64" height="64" alt=""/></td>
  </tr>
</table>

<table  class="table table-striped" width="600" cellspacing="8" cellpadding="8">
  <tr>
    <td width="31%"> <div class="qr-code"><img style="margin:5px" id="qrsend2" src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?=$my_bitcoin_address?>&message=Pay-Demo&amount=<?=$price_in_btc?>" alt=""/></div></td>
    <td width="69%"><table width="100%" cellspacing="8" cellpadding="8">
      <tr>
        <td><span class="intro"><hr>
<small>If you send   any other leadercoin amount , payment system will  ignore it  !</small></span></td>
      </tr>
      <tr>
        <td><span class="intro_send">Send exactly <span class='font12'><?=$price_in_btc?></span> LDC (plus miner fee) to:</span></td>
      </tr>
      <tr>
        <td><table  class="table table-striped"  cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#333"><div class="addr tooltip-top" title="leadercoin Wallet Address is unique identifier which allows users to receive and send leadercoins.">[[address]]</div> <hr> <img src="al_loading.gif" width="43" height="43" alt=""/>  Waiting for payment </td>
            <td></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
               
            </div>
            <div class="blockchain stage-paid">
                Payment Received <b>[[value]] LDC</b>. Thank You.
                <table width="600"  class="table table-striped"  cellspacing="8" cellpadding="8">
  <tr>
    <td width="31%" align="center"><img src="paid.png" width="150" height="149" alt=""/></td>
    <td width="69%"><table   class="table table-striped"  width="100%" cellspacing="8" cellpadding="8">
      <tr>
        <td><span class="result1">Successful Result!</span></td>
      </tr>
      <tr>
        <td><span class="result2">Your payment has been received</span></td>
      </tr>
      <tr>
        <td><span class="btn-res tooltip-top2"><a href="./order_status.php?invoice_id=<?php echo $invoice_id; ?>">View Transaction Details</a></span></td>
      </tr>
    </table></td>
  </tr>
</table>
            </div>
            <div class="blockchain stage-error">
                <font color="red">[[error]]</font>
            </div>
        </div>
    </div></th>
  </tr>
</table>

    
      
  </div>
    </body>
</html>