<?php
    //Initialiaze variables
    $mbr_name = $mbr_addr = $mbr_apt = $mbr_pobox = $mbr_city = $mbr_state = $mbr_zip = $mbr_lvl = $mbr_type = $mbr_length = "";
    $ppl_trx_id = $ppl_payer_name = $ppl_trx_timestamp = "";

    //Collect POST data
    $mbr_name = $_POST["mbr_name"];
    $mbr_addr = $_POST["mbr_addr"];
    $mbr_apt = $_POST["mbr_apt"];
    $mbr_pobox = $_POST["mbr_pobox"];
    $mbr_city = $_POST["mbr_city"];
    $mbr_state = $_POST["mbr_state"];
    $mbr_zip = $_POST["mbr_zip"];
    $mbr_type = $_POST["mbr_type"];
    $mbr_length = $_POST["mbr_length"];
    $ppl_trx_id = $_POST["ppl_trx_id"];
    $ppl_payer_name = $_POST["ppl_payer_name"];
    $l10nDate = new DateTime($_POST["ppl_trx_timestamp"], new DateTimeZone('UTC'));
    $l10nDate->setTimeZone(new DateTimeZone('America/Los_Angeles'));
    $ppl_trx_timestamp = $l10nDate->format('Y-m-d H:i:s');
    $mbr_lvl = $_POST["mbr_lvl"];
    $mbr_lvl_cost = $_POST["mbr_lvl_cost"];   

    /* 
    //Send email notification to SHF treasurer 
        $to = "tjsharkfan@gmail.com";
    
        $email_field = "thomas.j.soukup@gmail.com";
        if ($mbr_type == "new") {$subject = "New SHF membership";} else {$subject = "SHF membership Renewal";}  
        $headers = "From: $email_field\r\n";
        $headers .= "Reply-To: $email_field\r\n";
        $headers .= "Return-Path: $email_field\r\n";
        //$headers .= "BCC: Thomas.J.Soukup@gmail.com\r\n";
    
        $body = "Online SHF membership submission details:\r\n";
        $body .= "\tName: " . $mbr_name . "\r\n";
        $body .= "\tAddress: " . $mbr_addr . "\r\n";
        $body .= "\tApartment: " . $mbr_apt . "\r\n";
        $body .= "\tP.O. Box: " . $mbr_pobox . "\r\n";
        $body .= "\tCity: " . $mbr_city . "\r\n";
        $body .= "\tState: " . $mbr_state . "\r\n";
        $body .= "\tZip Code: " . $mbr_zip . "\r\n";
        $body .= "\tMembership Level: " . $mbr_lvl . "\r\n";
        $body .= "\tMembership Cost: " . $mbr_lvl_cost . "\r\n";
        $body .= "\tMembership Type: " . $mbr_type . "\r\n";
        $body .= "\tMembership Lenght: " . $mbr_length . "\r\n";
        $body .= "\r\n";
        $body .= "\tPayPal Transaction ID: " . $ppl_trx_id . "\r\n";
        $body .= "\tPayPal Transaction Date: " . $$ppl_trx_timestamp;				
        //$result = mail($to, $subject, $body, $headers);		  
    */
    //This code will log a membership request to a text file in the transaction folder on the web server.
    include 'PaypalTransactionLog.php';
    $result = logPayPalTransaction("Membership",$mbr_name,$mbr_addr, $mbr_apt, $mbr_pobox, $mbr_city, $mbr_state, $mbr_zip, $mbr_lvl_cost, "$mbr_lvl", "$mbr_type", "$mbr_length", $ppl_trx_id, $ppl_payer_name, $ppl_trx_timestamp);    

 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><!-- InstanceBegin template="/Templates/shf.dwt" codeOutsideHTMLIsLocked="false" -->
<head>

	<!-- InstanceBeginEditable name="doctitle" -->
    <title>Membership Confirmation</title>
    <meta name="description" content="Saratoga Historical Foundation and Museum - located in Saratoga, California" />
	
    <!-- for Mail Chimp -->
    <link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #mc_embed_signup{
			background:#e2e2e2; 
			clear:left; 
			font:12px Verdana,Arial,sans-serif; 
			padding:20px 0px 0px 0px; }
        /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    </style>
	<!-- InstanceEndEditable -->
    
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="author" content="Tom Soukup" />
    <meta http-equiv="imagetoolbar" CONTENT="no"> <!-- disable IE image toolbar from showing up on moused-over images -->
    <link rel="shortcut icon" type="image/x-icon" href="/shf_Assets/favicon.ico">
    <link href="css/shf.css" rel="stylesheet" type="text/css" />
    <link href="css/quickmenu.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="javascript/quickmenu.js"></script>
    <script type="text/javascript" src="javascript/utilities.js"></script>

</head>
<body>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="tableborder">
      <tr>
        <td bgcolor="#336666"><img src="shf_Assets/banner7.jpg" width="800" height="150" vspace="0"></td>
      </tr>
      <tr bgcolor="#336666">
            
            <td>
                        <!--  ****** Horizontal Menu Structure & Links ***** -->
            <ul class="qmmc" id="qm0" name="qm0">
            
                <li><a href="./index.htm">Home</a></li>
                <li><a class="qmparent" href="javascript:void(0);">About Us</a>            
                    <ul>                
                    <li><a href="overview.htm">Overview</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="newsletter.htm">Newsletter</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <!-- <li><a href="../events.htm">Events</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li> -->
                    <li><a href="new_membership.htm">Membership & Donations</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="location_and_hours.htm">Location & Hours</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="volunteers.htm">Volunteer Opportunities</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="board_of_directors.htm">Board of Directors</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="board_of_directors.htm">Contact</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="inthenews/">In the News</a></li>
                    </ul></li>
            
                <li><a class="qmparent" href="javascript:void(0);">Saratoga History</a>
                    <ul>            
                    <li><a href="misc documents/2010-Saratoga-Historical-Walking-Tour.pdf" target="_blank">Historical Walking Tour</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="misc documents/2010-Saratoga-Historical-Bike-Ride.pdf" target="_blank">Historical Bike Tour</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="misc documents/Park Garden Tour 2010 final.pdf" target="_blank">Garden Tour</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/called_saratoga.htm">They Called it Saratoga</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/PIrailroad.htm">Peninsular Interurban RR</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>                
                    <li><a href="History/abijah_mccall.htm">Abijah McCall</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/sarah_brown.htm">Sarah Brown</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/florence_cunningham.htm">Florence Cunningham</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/isabella_blaney.htm">Bella Blaney</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/cob.htm">Chamber of Commerce</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/WWI.htm">World War I</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/WWII.htm">World War II</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/KoreanWar.htm">Korean War</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/japanese_gardens.htm">Japanese Gardens</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/peeper.htm">Peeper</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/winehistory.htm">Wine History</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/kevin_moran.htm">Kevin Moran</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/foothillclub.htm">Foothill Club</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/saratoga-women.htm">Women's History</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/mensclub.htm">Saratoga Men's Club</a></li>
                    <li><span class="qmdivider qmdividerx" ></span></li>
                    <li><a href="History/bibliography.htm">Bibliography</a></li>
                    </ul></li>
            
                <li style="width:215px;"><a href="educational/programs.htm">Educational Programs</a></li>
                
                <li style="width:138px;"></li>
            
    
            <li class="qmclear">&nbsp;</li></ul>
            
            <!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click (options: 'all' * 'all-always-open' * 'main' * 'lev2'), Right to Left, Horizontal Subs, Flush Left, Flush Top) -->
            <script type="text/javascript">qm_create(0,false,0,500,false,false,false,false,false);</script>
            <!--  ****** End Structure & Links ***** -->
            </td>
      </tr>
      
      <tr>
            <td><!-- InstanceBeginEditable name="EditRegion" -->
            <table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr><td colspan="2" style="text-align: left; vertical-align: top">
                </td></tr>
                <tr>
                    <td width="100%" class="headline" style="text-align:center"><strong>Saratoga Historical Foundation Membership Confirmation</strong></td>
                </tr>
                <tr>
                <td>
                <p>Thank you for <?php if ($mbr_type == "renew") {echo "renewing ";}?>your Saratoga Historical Foundation membership.  You'll soon be receiving notices of upcoming events.</p>
                </td>
                </tr>
                <td>
                <p>The details of your membership are as follows:</p>
                <table>
                <tr><td>Member Name: </td><td><?php echo $mbr_name?></td>
                <tr><td>Address: </td><td><?php echo $mbr_addr?></td></tr>
                </tr><?php if ($mbr_apt != "") {echo "<tr><td>Apartment: </td><td>{$mbr_apt}</td></tr>";}?>
                </tr><?php if ($mbr_pobox != "") {echo "<tr><td>P.O. Box: </td><td>{$mbr_pobox}</td></tr>";}?>
                <tr><td>City: </td><td><?php echo $mbr_city?></td></tr>
                <tr><td>State: </td><td><?php echo $mbr_state?></td></tr>
                <tr><td>Zip Code: </td><td><?php echo $mbr_zip?></td></tr>
                <tr><td>Membership Level: </td><td><?php echo $mbr_lvl?></td></tr>
                <tr><td>Membership Cost: </td><td><?php echo $mbr_lvl_cost?></td></tr>
                </table>
                <br>
                <table>
                <tr><td colspan="2">Paypal transaction information</td></tr>
                <tr><td>Payer: </td><td><?php echo $ppl_payer_name?></td></tr>
                <tr><td>PayPal Transaction ID: </td><td><?php echo $ppl_trx_id?></td></tr>
                <tr><td>Transaction Date: </td><td><?php echo $ppl_trx_timestamp?></td></table>
            </table>  
            <style type="text/css">
               @media print {
                  #printbtn {
                     display :  none;
                     }
                  #adminLink {
                     display :  none;
                     }
                    }
            </style>
            <center><button id="printbtn" onclick="javascript:window.print()">Print this page.</button></center>
	        <!-- InstanceEndEditable --></td>
    </tr>
    <tr>

        </tr>
      
      <tr bgcolor="#336666">  
            <td class="fontfooter white" align="center" height="30">Saratoga Historical Foundation&nbsp;&nbsp;<strong>&middot;</strong>&nbsp;&nbsp;20450 Saratoga-Los Gatos Road, Saratoga, CA 95070-5935&nbsp;&nbsp;<strong>&middot;</strong>&nbsp;&nbsp;#408.867.4311</td>
      </tr>
    </table>  

	<!-- <div align="center" class="fontsmall">&copy Saratoga Historical Foundation 2014<br /><a href="../admin/">Admin</a></div> -->
    <div align="center" class="fontsmall">
   	  	<script language=JavaScript>
			<!--
			d = new Date();
			document.write("Copyright &copy;" + getFullYear(d) + " Saratoga Historical Foundation");
			// -->
		</script>
        <div id="adminLink"><br /><a href="admin/">Admin</a></div>
    </div>
</div>
</body>
<!-- InstanceEnd --></html>
