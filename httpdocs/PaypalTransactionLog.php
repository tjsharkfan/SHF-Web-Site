<!-- MembershipRequestLog.php -->

<?php
function logPayPalTransaction($trxType, $name, $addr, $apt, $pobox, $city, $state, $zip, $amount, $mbr_lvl, $mbr_type, $mbr_length, $ppl_trx_id, $ppl_payer_name, $ppl_trx_timestamp) {

  //This code will log a membership request to a text file in the membership folder on the web server.
  //
  // Set the folder and file names
  $dir = "transactions";
  $logFile = "PaypalTransactionLog.csv";
  $logFilePath = $dir . "/" . $logFile;
  //Column headers for the log file
  $headers = "Transaction Type,Name,Address,Apartment,P.O. Box,City,State,Zip Code,Amount,Member Level,Member Type,Membership Length,Transaction ID,Payer Name,Transaction Date";

  $x = "Directory exists";
  $cwd = getcwd();
 //First, ensure that the folder exists
  if (!mkdir($cwd . "/" . $dir, 0755, true)) {
    $x = "Creating directory";
  }
  /* */
  $fileError = "";
  //Check that the file exists and create it if not
  if (!file_exists($logFilePath)) {
	  if ($file = fopen($logFilePath, 'a')) {
		  $res = fwrite($file, $headers);
		  if ($res === false) {
			  $fileError = "Cannot write header string";
		  }
		  fclose($file);
	  } else {
		  $fileError = "Cannot open file: " . $logFilePath;
	  }
  }
  if ($fileError != "") {
    return $fileError;
  }

  //Create csv formated string from the transaction data
  $strTransaction = $trxType . ",";
  $strTransaction .= $name . ",";
  $strTransaction .= $addr . ",";
  $strTransaction .= $apt . ",";
  $strTransaction .= $pobox . ",";
  $strTransaction .= $city . ",";
  $strTransaction .= $state . ",";
  $strTransaction .= $zip . ",";
  $strTransaction .= $amount . ",";
  $strTransaction .= $mbr_lvl . ",";
  $strTransaction .= $mbr_type . ",";
  $strTransaction .= $mbr_length . ",";
  $strTransaction .= $ppl_trx_id . ",";
  $strTransaction .= $ppl_payer_name . ",";
  $strTransaction .= $ppl_trx_timestamp;

  //Write the transaction to the file
  if ($file = fopen($logFilePath, 'a')) {
    $res = fwrite($file, "\n");  //Write a newline
    $res = fwrite($file, $strTransaction);
    if ($res === false) {
      $fileError = "Cannot write transaction data";
    }
    fclose($file);
  } else {
    $fileError = "Cannot open file: " . $logFilePath;
    return $fileError;
  }
}
?>
