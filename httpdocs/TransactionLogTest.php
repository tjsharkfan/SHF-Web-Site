<!-- TransactiontLog.php -->
<?php
//Initialiaze variables
$trxType = "Donation";
$mbr_name = $mbr_addr = $mbr_apt = $mbr_pobox = $mbr_city = $mbr_state = $mbr_zip = $amount = $mbr_lvl = $mbr_type = $mbr_length = "";
$ppl_trx_id = $ppl_payer_name = $ppl_trx_timestamp = "";
$mbr_name = "Tom Soukup";
$mbr_addr = "Address";
$mbr_apt = "apartment";
$mbr_pobox = "P.O. Box";
$mbr_city = "City";
$mbr_state = "State";
$mbr_zip = "Zip Code";
$amount = "Amount";
$mbr_lvl = "Membership Level";
$mbr_type = "Membership Type";
$mbr_length = "Membership Length";
$ppl_trx_id = "Transaction ID";
$ppl_payer_name = "Payer Name";
$ppl_trx_timestamp = Date("m/d/Y H:i:s");

include 'PaypalTransactionLog.php';
$result = logPayPalTransaction($trxType,$mbr_name,$mbr_addr, $mbr_apt, $mbr_pobox, $mbr_city, $mbr_state, $mbr_zip, $amount, $mbr_lvl, $mbr_type, $mbr_length, $ppl_trx_id, $ppl_payer_name, $ppl_trx_timestamp);
?> 

<!DOCTYPE html>
<html>
<head> 
</head>
<body>
whoami: <?php echo `whoami`; ?><br>
$trxType: <?php echo $trxType; ?><br>
$ppl_trx_timestamp  <?php echo $ppl_trx_timestamp ; ?><br>
Function Call Result: <?php echo $result; ?><br>
dir: <?php echo $dir; ?><br>
dir path: <?php echo $cwd . "/" . $dir; ?><br>
Logfile: <?php echo $logFile; ?><br>
logFilePath: <?php echo $logFilePath; ?><br>
headers: <?php echo $headers; ?><br>
x: <?php echo $x; ?><br>
mkdir_res: <?php echo $mkdir_res; ?><br>
cwd: <?php echo $cwd; ?><br>
fileError: <?php echo $fileError; ?><br>
</body>
</html>