<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><!-- InstanceBegin template="/Templates/shf.dwt" codeOutsideHTMLIsLocked="false" -->
<head>

	<!-- InstanceBeginEditable name="doctitle" -->
    <title>Membership</title>
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
<?php
//This file contains code that is common to multiple php files related to the online membership application 
//Initialiaze variables
    $mbr_name = $mbr_addr = $mbr_apt = $mbr_pobox = $mbr_city = $mbr_state = $mbr_zip = $mbr_lvl = $mbr_type = $mbr_length = "";

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

    //The  mbr_lvl POST value contains the level type and cost separated by a :.  Split the string to get the values
    $a = explode(":", $_POST["mbr_lvl"]);
    $mbr_lvl = $a[0];
    $mbr_lvl_cost = $a[1];
    ?>

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
            <script>
               function submitform() {
               document.getElementById("submit_mbrshpform").submit();
               }
            </script>
            
            <form method="post" action="membershipconfirmation.php" id="submit_mbrshpform">
            <table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr>
                    <td colspan="3" class="headline" style="width: 100%; text-align: center"><strong>Membership Renewal Confirmation</strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="fontlarge" style="width: 100%; text-align: center">
                      Verify that all of the information entered is correct.<br>
                      Click on Back to make any neccessary corrections.<br>
                      Click on Cancel to quit and return  to the mail SHF page.<br>
                      Select one of the PayPal buttons to complete the membership purchase.
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="fontlarge" style="width: 100%; text-align: left">
                    <div>
		              <label for="mbr_name">Name:</label> <input type="text" name="mbr_name" value="<?php echo $mbr_name; ?>" readonly><br>
		              <label for="mbr_addr">Street Address:</label> <input type="text" name="mbr_addr" value="<?php echo $mbr_addr; ?>" readonly><br>
		              <label for="mbr_apt"> Appartment:</label> <input type="text" name="mbr_apt" value="<?php echo $mbr_apt; ?>" readonly><br>
		              <label for="mbr_pobox"> PO Box:</label> <input type="text" name="mbr_pobox" value="<?php echo $mbr_pobox; ?>" readonly><br>
		              <label for="mbr_city"> City:</label> <input type="text" name="mbr_city" value="<?php echo $mbr_city; ?>" readonly><br>
		              <label for="mbr_state"> State:</label> <input type="text" name="mbr_state" value="<?php echo $mbr_state; ?>" readonly><br>
		              <label for="mbr_zip"> ZIP Code:</label> <input type="text" name="mbr_zip" value="<?php echo $mbr_zip; ?>" readonly></br>
		              <label for="mbr_lvl"> Membership Level:</label> <input type="text" name="mbr_lvl" value="<?php echo $mbr_lvl; ?>" readonly><br>
		              <label for="mbr_lvl_cost"> Membership Cost:</label> <input type="text" name="mbr_lvl_cost" value="$<?php echo $mbr_lvl_cost; ?>" readonly><br>
		              <label for="mbr_type"> Membership Type:</label> <input type="text" name="mbr_type" value="<?php echo $mbr_type; ?>" readonly><br>
		              <label for="mbr_length"> Membership Length:</label> <input type="text" name="mbr_length" value="<?php echo $mbr_length; ?>" readonly><br>
                       <input type="hidden" id="ppl_trx_id" name="ppl_trx_id" value="">
                        <input type="hidden" id="ppl_payer_name" name="ppl_payer_name" value="">
                        <input type="hidden" id="ppl_trx_timestamp" name="ppl_trx_timestamp" value="">
                      </div>
                    </td>
                </tr>
                <tr>
                    <td class="fontlarge" style="width: 10%; text-align: left; vertical-align: top">
                     <input type="button" value="< Back" onclick="history.back()">
                    </td>
                
                    <td class="fontlarge" style="width: 80%; text-align: center">
                    <p>Use the PayPal button to log into your PayPal account and complete the transaction.<br>
                     Use the Debit or Credit Card link to pay by card without a Paypal account.<br>
                     All card transactions are executed by PayPal.</p><br>
                     
                     <!--  Use this for testing   -->
                     <script
                     src="https://www.paypal.com/sdk/js?client-id=Ac3FPScttCiI_CU9X9XPGpcogMg3X_sQqEi3cO36WMfXpCcbxKqekaph_EqZCriOJuZZxnP4xEwZnWci"> 
                     </script>
                    
                    <!--  Use this for live transactions  
                     <script
                     src="https://www.paypal.com/sdk/js?client-id=AcB-dyelnRaEvsJCyFsK0p8Dn6GafeW5lWeq8Sw8lHTOs5ZAp1rPOMD-kJLj55P_-d-8Y6KXVfH6L9Iv"> 
                     </script>
                    -->


                     <div id="paypal-button-container"></div>

                    <script>
                    paypal.Buttons({
                      createOrder: function(data, actions) {
                    // This function sets up the details of the transaction, including the amount and line item details.
                      return actions.order.create({
                        purchase_units: [{
		                      description: 'SHF Membership: <?php echo $mbr_type; ?>; Level: <?php echo $mbr_lvl; ?>',
                          amount: {
                            value: '<?php echo $mbr_lvl_cost; ?>'
                            }
                        }],
                        application_context: {
                          shipping_preference: "NO_SHIPPING"
                        }
                      });
                    },
                    onApprove: function(data, actions) {
                      // This function captures the funds from the transaction.
                      return actions.order.capture().then(function(details) {

                        document.getElementById("ppl_trx_id").value = details.id; 
                        document.getElementById("ppl_payer_name").value = details.payer.name.given_name + " " + details.payer.name.surname; 
                        document.getElementById("ppl_trx_timestamp").value = details.update_time; 
                        document.getElementById("submit_mbrshpform").submit();

                      });
                    }
                    }).render('#paypal-button-container');
                    //This function displays Smart Payment Buttons on your web page.
                   </script>
                </td>
                <td class="fontlarge" style="width: 10%; text-align: right; vertical-align: top">
                     <input type="button" value="Cancel" onclick="location.href='http://www.saratogahistory.com'">
                    </td>
                </tr>
            </table>
            </form>        
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
			d = new Date();
			document.write("Copyright &copy;" + getFullYear(d) + " Saratoga Historical Foundation");
		</script>
        <br /><a href="admin/">Admin</a>
    </div>
</div> 

</body>
<!-- InstanceEnd --></html>
