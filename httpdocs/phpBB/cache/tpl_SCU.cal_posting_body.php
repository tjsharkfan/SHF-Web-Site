<?php

// eXtreme Styles mod cache. Generated on Fri, 19 Aug 2005 11:20:50 -0700 (time=1124475650)

?><link rel="stylesheet" media="screen" href="includes/calpro/dyncal/dynCalendar.css" />
<script language="javascript" type="text/javascript" src="includes/calpro/dyncal/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="includes/calpro/dyncal/dynCalendar.js"></script>

<script language="JavaScript" type="text/javascript">
<!--
/**
* Date set function for start date
*/
function Date_set_Start(date, month, year)
{
/*
	if (String(month).length == 1) {
		month = '0' + month;
	}
    
	if (String(date).length == 1) {
		date = '0' + date;
	}
*/
	document.forms['post'].day.value = parseInt(date);
	document.forms['post'].month.value = parseInt(month);
	document.forms['post'].year.value = year;
}

function Date_set_End(date, month, year)
{
	document.forms['post'].day_end.value = parseInt(date);
	document.forms['post'].month_end.value = parseInt(month);
	document.forms['post'].year_end.value = year;
}

function Date_set_Recur(date, month, year)
{
	document.forms['post'].stop_day.value = parseInt(date);
	document.forms['post'].stop_month.value = parseInt(month);
	document.forms['post'].stop_year.value = year;
}


//-->
</script>

<script language="JavaScript" type="text/javascript">
<!--
// bbCode control by
// subBlue design
// www.subBlue.com

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav  = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

// Helpline messages
b_help = "<?php echo isset($this->vars['L_BBCODE_B_HELP']) ? $this->vars['L_BBCODE_B_HELP'] : $this->lang('L_BBCODE_B_HELP'); ?>";
i_help = "<?php echo isset($this->vars['L_BBCODE_I_HELP']) ? $this->vars['L_BBCODE_I_HELP'] : $this->lang('L_BBCODE_I_HELP'); ?>";
u_help = "<?php echo isset($this->vars['L_BBCODE_U_HELP']) ? $this->vars['L_BBCODE_U_HELP'] : $this->lang('L_BBCODE_U_HELP'); ?>";
q_help = "<?php echo isset($this->vars['L_BBCODE_Q_HELP']) ? $this->vars['L_BBCODE_Q_HELP'] : $this->lang('L_BBCODE_Q_HELP'); ?>";
c_help = "<?php echo isset($this->vars['L_BBCODE_C_HELP']) ? $this->vars['L_BBCODE_C_HELP'] : $this->lang('L_BBCODE_C_HELP'); ?>";
l_help = "<?php echo isset($this->vars['L_BBCODE_L_HELP']) ? $this->vars['L_BBCODE_L_HELP'] : $this->lang('L_BBCODE_L_HELP'); ?>";
o_help = "<?php echo isset($this->vars['L_BBCODE_O_HELP']) ? $this->vars['L_BBCODE_O_HELP'] : $this->lang('L_BBCODE_O_HELP'); ?>";
p_help = "<?php echo isset($this->vars['L_BBCODE_P_HELP']) ? $this->vars['L_BBCODE_P_HELP'] : $this->lang('L_BBCODE_P_HELP'); ?>";
w_help = "<?php echo isset($this->vars['L_BBCODE_W_HELP']) ? $this->vars['L_BBCODE_W_HELP'] : $this->lang('L_BBCODE_W_HELP'); ?>";
a_help = "<?php echo isset($this->vars['L_BBCODE_A_HELP']) ? $this->vars['L_BBCODE_A_HELP'] : $this->lang('L_BBCODE_A_HELP'); ?>";
s_help = "<?php echo isset($this->vars['L_BBCODE_S_HELP']) ? $this->vars['L_BBCODE_S_HELP'] : $this->lang('L_BBCODE_S_HELP'); ?>";
f_help = "<?php echo isset($this->vars['L_BBCODE_F_HELP']) ? $this->vars['L_BBCODE_F_HELP'] : $this->lang('L_BBCODE_F_HELP'); ?>";

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
imageTag = false;

// Define the date related info
var months = new Array("", "<?php echo isset($this->vars['L_JAN']) ? $this->vars['L_JAN'] : $this->lang('L_JAN'); ?>", "<?php echo isset($this->vars['L_FEB']) ? $this->vars['L_FEB'] : $this->lang('L_FEB'); ?>", "<?php echo isset($this->vars['L_MAR']) ? $this->vars['L_MAR'] : $this->lang('L_MAR'); ?>", "<?php echo isset($this->vars['L_APR']) ? $this->vars['L_APR'] : $this->lang('L_APR'); ?>", "<?php echo isset($this->vars['L_MAY']) ? $this->vars['L_MAY'] : $this->lang('L_MAY'); ?>", "<?php echo isset($this->vars['L_JUN']) ? $this->vars['L_JUN'] : $this->lang('L_JUN'); ?>", 
			"<?php echo isset($this->vars['L_JUL']) ? $this->vars['L_JUL'] : $this->lang('L_JUL'); ?>", "<?php echo isset($this->vars['L_AUG']) ? $this->vars['L_AUG'] : $this->lang('L_AUG'); ?>", "<?php echo isset($this->vars['L_SEP']) ? $this->vars['L_SEP'] : $this->lang('L_SEP'); ?>", "<?php echo isset($this->vars['L_OCT']) ? $this->vars['L_OCT'] : $this->lang('L_OCT'); ?>", "<?php echo isset($this->vars['L_NOV']) ? $this->vars['L_NOV'] : $this->lang('L_NOV'); ?>", "<?php echo isset($this->vars['L_DEC']) ? $this->vars['L_DEC'] : $this->lang('L_DEC'); ?>");

// Shows the help messages in the helpline window
function helpline(help) {
	document.post.helpbox.value = eval(help + "_help");
}


// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}


function checkForm() {

	formErrors = '';

	if (document.post.subject.value.length < 2) {
		formErrors = "<?php echo isset($this->vars['L_EMPTY_SUBJECT']) ? $this->vars['L_EMPTY_SUBJECT'] : $this->lang('L_EMPTY_SUBJECT'); ?>\n";
	}
	if (document.post.message.value.length < 2) {
		formErrors += "<?php echo isset($this->vars['L_EMPTY_DESC']) ? $this->vars['L_EMPTY_DESC'] : $this->lang('L_EMPTY_DESC'); ?>\n";
	}
	monthcheck = document.post.month.options[document.post.month.selectedIndex].value;
	daycheck = document.post.day.options[document.post.day.selectedIndex].value;
	yearcheck = document.post.year.options[document.post.year.selectedIndex].value;
	formErrors += checkDate(monthcheck, daycheck, yearcheck, 'Start Date');

	if (document.post.endmonth) {
		monthcheck = document.post.endmonth.options[document.post.endmonth.selectedIndex].value;
		daycheck = document.post.endday.options[document.post.endday.selectedIndex].value;
		yearcheck = document.post.endday.options[document.post.endyear.selectedIndex].value;
		if ((monthcheck != '') && (daycheck != '') && (yearcheck != '')) {
			formErrors += checkDate(monthcheck, daycheck, yearcheck, 'End Date');		
		}
	}

	if (formErrors) {
		alert(formErrors);
		return false;
	} else {
		bbstyle(-1);
		//formObj.preview.disabled = true;
		//formObj.submit.disabled = true;
		return true;
	}
}

function checkDate(mm, dd, yyyy, datetype) {
	if((mm == 4 || mm == 6 || mm == 9 || mm == 11) && dd > 30) {
		error = datetype + ": " + months[mm] + " (<?php echo isset($this->vars['L_MAX']) ? $this->vars['L_MAX'] : $this->lang('L_MAX'); ?> 30 <?php echo isset($this->vars['L_DAY']) ? $this->vars['L_DAY'] : $this->lang('L_DAY'); ?>)\n";
	}
	else if(mm == 2) {
		if (yyyy % 4 > 0 && dd > 28) {
			error = datetype + ": " + months[2] + " (<?php echo isset($this->vars['L_MAX']) ? $this->vars['L_MAX'] : $this->lang('L_MAX'); ?> 28 <?php echo isset($this->vars['L_DAY']) ? $this->vars['L_DAY'] : $this->lang('L_DAY'); ?>)\n";
		}
		else if (dd > 29) {
			error = datetype + ": " + months[2] + " (<?php echo isset($this->vars['L_MAX']) ? $this->vars['L_MAX'] : $this->lang('L_MAX'); ?> 29 <?php echo isset($this->vars['L_DAY']) ? $this->vars['L_DAY'] : $this->lang('L_DAY'); ?>)\n";
		}
		else {
			error = '';
		}
	}
	else {
		error = '';
	}
	return error;
}




function emoticon(text) {
	var txtarea = document.post.message;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.post.message;

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
}


function bbstyle(bbnumber) {
	var txtarea = document.post.message;

	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			buttext = eval('document.post.addbbcode' + butnumber + '.value');
			eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false; // All tags are closed including image tags :D
		txtarea.focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection
		if (theSelection) {
			// Add tags around selection
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			txtarea.focus();
			theSelection = '';
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}
	
	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
				buttext = eval('document.post.addbbcode' + butnumber + '.value');
				eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			txtarea.focus();
			return;
	} else { // Open tags
	
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			txtarea.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			document.post.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag = false;
		}
		
		// Open tag
		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		eval('document.post.addbbcode'+bbnumber+'.value += "*"');
		txtarea.focus();
		return;
	}
	storeCaret(txtarea);
}

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2) 
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
//-->
</script>
<SCRIPT language="JavaScript">
<!--
<?php

$access_check_count = ( isset($this->_tpldata['access_check.']) ) ?  sizeof($this->_tpldata['access_check.']) : 0;
for ($access_check_i = 0; $access_check_i < $access_check_count; $access_check_i++)
{
 $access_check_item = &$this->_tpldata['access_check.'][$access_check_i];
 $access_check_item['S_ROW_COUNT'] = $access_check_i;
 $access_check_item['S_NUM_ROWS'] = $access_check_count;

?>
// MOD Calendar Pro 2.0.25 DEV
function change_access() {
	if(document.forms[0].access_level.length == 3) {
		level = 2;
	}
	else {
		level = 1;
	}
	document.forms[0].access_level.selectedIndex=level;
}

function reset_access() {
	if(document.forms[0].access_level.length == 3) {
		check = 2;
	}
	else {
		check = 1;
	}
	if(document.forms[0].access_level.options[check].selected != 1) {
		for($i=0; $i<document.forms[0].group_access.options.length; $i++) {
			document.forms[0].group_access.options[$i].selected = 0;
		}
	}
}

<?php

} // END access_check

if(isset($access_check_item)) { unset($access_check_item); } 

?>
<?php

$null_check_count = ( isset($this->_tpldata['null_check.']) ) ?  sizeof($this->_tpldata['null_check.']) : 0;
for ($null_check_i = 0; $null_check_i < $null_check_count; $null_check_i++)
{
 $null_check_item = &$this->_tpldata['null_check.'][$null_check_i];
 $null_check_item['S_ROW_COUNT'] = $null_check_i;
 $null_check_item['S_NUM_ROWS'] = $null_check_count;

?>
function change_access() {
}
function reset_access() {
}
<?php

} // END null_check

if(isset($null_check_item)) { unset($null_check_item); } 

?>
//-->
</SCRIPT>
<form action="<?php echo isset($this->vars['S_POST_ACTION']) ? $this->vars['S_POST_ACTION'] : $this->lang('S_POST_ACTION'); ?>" method="post" name="post" onsubmit="return checkForm(this)">

<?php echo isset($this->vars['ERROR_BOX']) ? $this->vars['ERROR_BOX'] : $this->lang('ERROR_BOX'); ?>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><?php echo isset($this->vars['PHPBBHEADER']) ? $this->vars['PHPBBHEADER'] : $this->lang('PHPBBHEADER'); ?><span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a> -&gt;
		<a href="<?php echo isset($this->vars['U_CAL_HOME']) ? $this->vars['U_CAL_HOME'] : $this->lang('U_CAL_HOME'); ?>" class="nav"><?php echo isset($this->vars['CALENDAR']) ? $this->vars['CALENDAR'] : $this->lang('CALENDAR'); ?></a></span></td>
		<td align=right class=genmed valign=bottom></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25"><b><?php echo isset($this->vars['L_CAL_NEW']) ? $this->vars['L_CAL_NEW'] : $this->lang('L_CAL_NEW'); ?></b><?php echo isset($this->vars['L_CAL_NEW_NOTE']) ? $this->vars['L_CAL_NEW_NOTE'] : $this->lang('L_CAL_NEW_NOTE'); ?></th>
	</tr>
	<tr>
	    <td class="row1" colspan="2">
	      <table width="100%" border="0" cellpadding="2" cellspacing="0">
		<tr>
		  <td width="50%" valign="top">
<?php

$date_info_count = ( isset($this->_tpldata['date_info.']) ) ?  sizeof($this->_tpldata['date_info.']) : 0;
for ($date_info_i = 0; $date_info_i < $date_info_count; $date_info_i++)
{
 $date_info_item = &$this->_tpldata['date_info.'][$date_info_i];
 $date_info_item['S_ROW_COUNT'] = $date_info_i;
 $date_info_item['S_NUM_ROWS'] = $date_info_count;

?>
		      <table width="100%" border="0" cellpadding="2" cellspacing="1" class="forumline">
			<tr>
			  <td class="row3" colspan="2" align="center"><span class="gen"><b><?php echo isset($date_info_item['L_CAL_TITLE']) ? $date_info_item['L_CAL_TITLE'] : ''; ?></b></span></td>
			</tr>
	                <tr> 
        	          <td width="19%" class="row1"><span class="gen"><b><?php echo isset($date_info_item['L_CAL_DATE']) ? $date_info_item['L_CAL_DATE'] : ''; ?></b></span></td>
                	  <td class="row2"> <span class="gen"> 
        	            <select name=day size=1 class="post" style="width: 50px" onchange="document.post.day_end.value=document.post.day.value">
                	      <?php echo isset($date_info_item['THIS_DAY']) ? $date_info_item['THIS_DAY'] : ''; ?>
	                    </select>
        	            <select size=1 name=month class="post" onchange="document.post.month_end.value=document.post.month.value">
                	      <?php echo isset($date_info_item['THIS_MONTH']) ? $date_info_item['THIS_MONTH'] : ''; ?>
	                    </select>
        	            <select name=year size=1 class="post" onchange="document.post.year_end.value=document.post.year.value">
                	      <?php echo isset($date_info_item['THIS_YEAR']) ? $date_info_item['THIS_YEAR'] : ''; ?>
	                    </select>
        	            </span>
			<script language="JavaScript" type="text/javascript">
			<!--
			/**
			* Date set function for start date
			*/
			start_cal = new dynCalendar('start_cal', 'Date_set_Start', <?php echo isset($this->vars['DAY']) ? $this->vars['DAY'] : $this->lang('DAY'); ?>, <?php echo isset($this->vars['MONTH']) ? $this->vars['MONTH'] : $this->lang('MONTH'); ?>, <?php echo isset($this->vars['YEAR']) ? $this->vars['YEAR'] : $this->lang('YEAR'); ?>, 'includes/calpro/dyncal/images/');
			start_cal.setMonthCombo(true);
			start_cal.setYearCombo(true);
			start_cal.setImagesPath('includes/calpro/dyncal/images/');
			start_cal.setOffsetX(5);
			start_cal.setOffsetY(-100);
			//-->
			</script>
			  </td>
	        	</tr>
        	        <tr> 
                	  <td width="19%" class="row1"><span class="gen"><b><?php echo isset($date_info_item['L_CAL_TIME']) ? $date_info_item['L_CAL_TIME'] : ''; ?></b></span></td>
	                  <td class="row2"> <span class="gen">
	                    <select name=hour size=1 style="width: 45px">
                	      <?php echo isset($date_info_item['THIS_HOUR']) ? $date_info_item['THIS_HOUR'] : ''; ?>
        	            </select>:
                	    <select name=minute size=1 class="post" style="width: 50px">
	                      <?php echo isset($date_info_item['THIS_MIN']) ? $date_info_item['THIS_MIN'] : ''; ?>
        	            </select>
			      <?php echo isset($date_info_item['THIS_AM_PM']) ? $date_info_item['THIS_AM_PM'] : ''; ?>
    	                  </span>
			  </td>
        	        </tr>
	                <tr> 
        	          <td width="19%" class="row1"><span class="gen"><b><?php echo isset($date_info_item['L_CAL_ENDDATE']) ? $date_info_item['L_CAL_ENDDATE'] : ''; ?></b></span></td>
                	  <td class="row2"> <span class="gen"> 
        	            <select name=day_end size=1 class="post" style="width: 50px">
                	      <?php echo isset($date_info_item['END_DAY']) ? $date_info_item['END_DAY'] : ''; ?>
	                    </select>
        	            <select size=1 name=month_end class="post">
                	      <?php echo isset($date_info_item['END_MONTH']) ? $date_info_item['END_MONTH'] : ''; ?>
	                    </select>
        	            <select name=year_end size=1 class="post">
                	      <?php echo isset($date_info_item['END_YEAR']) ? $date_info_item['END_YEAR'] : ''; ?>
	                    </select>
        	            </span>
			<script language="JavaScript" type="text/javascript">
			<!--
			/**
			* Date set function for start date
			*/
			end_cal = new dynCalendar('end_cal', 'Date_set_End', <?php echo isset($this->vars['END_DAY']) ? $this->vars['END_DAY'] : $this->lang('END_DAY'); ?>, <?php echo isset($this->vars['END_MONTH']) ? $this->vars['END_MONTH'] : $this->lang('END_MONTH'); ?>, <?php echo isset($this->vars['END_YEAR']) ? $this->vars['END_YEAR'] : $this->lang('END_YEAR'); ?>, 'includes/calpro/dyncal/images/');
			end_cal.setMonthCombo(true);
			end_cal.setYearCombo(true);
			end_cal.setImagesPath('includes/calpro/dyncal/images/');
			end_cal.setOffsetX(5);
			end_cal.setOffsetY(-100);
			//-->
			</script>
			  </td>
	        	</tr>
        	        <tr> 
                	  <td width="19%" class="row1"><span class="gen"><b><?php echo isset($date_info_item['L_CAL_ENDTIME']) ? $date_info_item['L_CAL_ENDTIME'] : ''; ?></b></span></td>
	                  <td class="row2"> <span class="gen">
	                    <select name=hour_end size=1 style="width: 45px">
                	      <?php echo isset($date_info_item['END_HOUR']) ? $date_info_item['END_HOUR'] : ''; ?>
        	            </select>:
                	    <select name=minute_end size=1 class="post" style="width: 50px">
	                      <?php echo isset($date_info_item['END_MIN']) ? $date_info_item['END_MIN'] : ''; ?>
        	            </select>
			      <?php echo isset($date_info_item['END_AM_PM']) ? $date_info_item['END_AM_PM'] : ''; ?>
    	                  </span>
			  </td>
        	        </tr>
		      </table>
<?php

} // END date_info

if(isset($date_info_item)) { unset($date_info_item); } 

?>
		     </td>
		     <td width="50%" valign="top" class="row1">
<?php

$repeat_info_count = ( isset($this->_tpldata['repeat_info.']) ) ?  sizeof($this->_tpldata['repeat_info.']) : 0;
for ($repeat_info_i = 0; $repeat_info_i < $repeat_info_count; $repeat_info_i++)
{
 $repeat_info_item = &$this->_tpldata['repeat_info.'][$repeat_info_i];
 $repeat_info_item['S_ROW_COUNT'] = $repeat_info_i;
 $repeat_info_item['S_NUM_ROWS'] = $repeat_info_count;

?>
		      <table width="100%" border="0" cellpadding="2" cellspacing="1" class="forumline">
			<tr>
			  <td class="row3" colspan="2" align="center"><span class="gen"><b><?php echo isset($repeat_info_item['L_CAL_TITLE_REC']) ? $repeat_info_item['L_CAL_TITLE_REC'] : ''; ?></b></span></td>
			</tr>
                	<tr>
	                  <td width="19%" NOWRAP class="row1"><span class=gen><b><?php echo isset($repeat_info_item['L_REPEAT']) ? $repeat_info_item['L_REPEAT'] : ''; ?></b></span></td>
        	          <td NOWRAP class="row2"><span class="gen">
	                    <select size=1 name=r_num class="post" style="width: 45px">
        	              <?php echo isset($repeat_info_item['R_NUM']) ? $repeat_info_item['R_NUM'] : ''; ?>
	                    </select>
        	            <select size=1 name=r_period class="post" style="width: 90px">
	                      <?php echo isset($repeat_info_item['R_PERIOD']) ? $repeat_info_item['R_PERIOD'] : ''; ?>
        	            </select>
	                    </span>
			  </td>
	                </tr>
                	<tr>
	                  <td width="19%" NOWRAP class="row1" align="right"><span class=gen><b><?php echo isset($repeat_info_item['L_OR']) ? $repeat_info_item['L_OR'] : ''; ?></b></span></td>
        	          <td NOWRAP class="row2"><span class="gen">
	                    <select size=1 name=r_nth_num class="post" style="width: 45px">
        	              <?php echo isset($repeat_info_item['NTH_NUM']) ? $repeat_info_item['NTH_NUM'] : ''; ?>
	                    </select>
        	            <select size=1 name=r_nth_period class="post" style="width: 90px">
	                      <?php echo isset($repeat_info_item['NTH_PERIOD']) ? $repeat_info_item['NTH_PERIOD'] : ''; ?>
        	            </select>
	                    </span>
			  </td>
	                </tr>
        	        <tr>
                	  <td width="19%" NOWRAP class="row1" align='right'><b><span class=gen>...<?php echo isset($repeat_info_item['L_UNTIL']) ? $repeat_info_item['L_UNTIL'] : ''; ?>:
			    </span></b></td>
		                  <td NOWRAP class="row2"><span class="gen">
	                    <select name=stop_day size=1 class="post" style="width: 45px">
        	              <?php echo isset($repeat_info_item['STOP_DAY']) ? $repeat_info_item['STOP_DAY'] : ''; ?>
	                    </select>
        	            <select size=1 name=stop_month class="post" style="width: 90px">
	                      <?php echo isset($repeat_info_item['STOP_MONTH']) ? $repeat_info_item['STOP_MONTH'] : ''; ?>
        	            </select>
	                    <select size=1 name=stop_year class="post">
        	              <?php echo isset($repeat_info_item['STOP_YEAR']) ? $repeat_info_item['STOP_YEAR'] : ''; ?>
	                    </select>
        	            </span>
			<script language="JavaScript" type="text/javascript">
			<!--
			/**
			* Date set function for Recurring date
			*/
			recur_cal = new dynCalendar('recur_cal', 'Date_set_Recur', <?php echo isset($this->vars['STOP_DAY']) ? $this->vars['STOP_DAY'] : $this->lang('STOP_DAY'); ?>, <?php echo isset($this->vars['STOP_MONTH']) ? $this->vars['STOP_MONTH'] : $this->lang('STOP_MONTH'); ?>, <?php echo isset($this->vars['STOP_YEAR']) ? $this->vars['STOP_YEAR'] : $this->lang('STOP_YEAR'); ?>, 'includes/calpro/dyncal/images/');
			recur_cal.setMonthCombo(true);
			recur_cal.setYearCombo(true);
			recur_cal.setOffsetX(-180);
			recur_cal.setOffsetY(30);
			recur_cal.setImagesPath('includes/calpro/dyncal/images/');
			//-->
			</script>
			  </td>
	                </tr>
			<tr>
			  <td width="19%" NOWRAP class="row1" align='right'><span class=gen><b><?php echo isset($repeat_info_item['L_EVENT_NUM']) ? $repeat_info_item['L_EVENT_NUM'] : ''; ?></b></span></td>
			  <td NOWRAP class="row2"><span class=gen><b><?php echo isset($repeat_info_item['EVENT_INFO']) ? $repeat_info_item['EVENT_INFO'] : ''; ?> </b></span><span class=genmed><i><?php echo isset($repeat_info_item['EARLY_ITERATION']) ? $repeat_info_item['EARLY_ITERATION'] : ''; ?></i></span></td>
			</tr>
        	      </table>
<?php

} // END repeat_info

if(isset($repeat_info_item)) { unset($repeat_info_item); } 

?>
		  </td>
		</tr>
	      </table>
	    </td>
	</tr>
<?php

$global_info_count = ( isset($this->_tpldata['global_info.']) ) ?  sizeof($this->_tpldata['global_info.']) : 0;
for ($global_info_i = 0; $global_info_i < $global_info_count; $global_info_i++)
{
 $global_info_item = &$this->_tpldata['global_info.'][$global_info_i];
 $global_info_item['S_ROW_COUNT'] = $global_info_i;
 $global_info_item['S_NUM_ROWS'] = $global_info_count;

?>
	<tr>
	  <td class="row1" width="22%" align='right'><span class="genmed"><?php echo isset($global_info_item['L_GLOBAL_SUBJECT']) ? $global_info_item['L_GLOBAL_SUBJECT'] : ''; ?></span></td>
	  <td class="row2" width="78%"><span class="genmed"><?php echo isset($global_info_item['GLOBAL_SUBJECT']) ? $global_info_item['GLOBAL_SUBJECT'] : ''; ?></span></td>
	</tr>
	<tr>
	  <td class="row1" width="22%" align='right'><span class="genmed"><?php echo isset($global_info_item['L_GLOBAL_DESC']) ? $global_info_item['L_GLOBAL_DESC'] : ''; ?></span></td>
	  <td class="row2" width="78%"><span class="genmed"><?php echo isset($global_info_item['GLOBAL_DESC']) ? $global_info_item['GLOBAL_DESC'] : ''; ?></span></td>
	</tr>
<?php

} // END global_info

if(isset($global_info_item)) { unset($global_info_item); } 

?>
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b><?php echo isset($this->vars['L_SUBJECT']) ? $this->vars['L_SUBJECT'] : $this->lang('L_SUBJECT'); ?></b></span> <span class="genmed"><i><?php echo isset($this->vars['L_SUBJECT_XTRA']) ? $this->vars['L_SUBJECT_XTRA'] : $this->lang('L_SUBJECT_XTRA'); ?></i></span></td>
	  <td class="row2" width="78%"> <span class="gen">
		<input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="<?php echo isset($this->vars['SUBJECT']) ? $this->vars['SUBJECT'] : $this->lang('SUBJECT'); ?>" />
		</span> </td>
	</tr>
<?php

$category_row_count = ( isset($this->_tpldata['category_row.']) ) ?  sizeof($this->_tpldata['category_row.']) : 0;
for ($category_row_i = 0; $category_row_i < $category_row_count; $category_row_i++)
{
 $category_row_item = &$this->_tpldata['category_row.'][$category_row_i];
 $category_row_item['S_ROW_COUNT'] = $category_row_i;
 $category_row_item['S_NUM_ROWS'] = $category_row_count;

?>
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b><?php echo isset($category_row_item['L_CATEGORY']) ? $category_row_item['L_CATEGORY'] : ''; ?></b></span></td>
	  <td class="row2" width="78%"> 
		<select size=1 name=category><span class="genmed">
		<?php echo isset($category_row_item['CATEGORY_SELECT']) ? $category_row_item['CATEGORY_SELECT'] : ''; ?>
		</select>
		</span></td>
	</tr>
<?php

} // END category_row

if(isset($category_row_item)) { unset($category_row_item); } 

?>
	<tr> 
	  <td class="row1" valign="top"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td><span class="gen"><b><?php echo isset($this->vars['L_MESSAGE_BODY']) ? $this->vars['L_MESSAGE_BODY'] : $this->lang('L_MESSAGE_BODY'); ?></b></span> </td>
		  </tr>
		  <tr> 
			<td valign="middle" align="center"> <br />
			  <table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center"> 
				  <td colspan="<?php echo isset($this->vars['S_SMILIES_COLSPAN']) ? $this->vars['S_SMILIES_COLSPAN'] : $this->lang('S_SMILIES_COLSPAN'); ?>" class="gensmall"><b><?php echo isset($this->vars['L_EMOTICONS']) ? $this->vars['L_EMOTICONS'] : $this->lang('L_EMOTICONS'); ?></b></td>
				</tr>
				<?php

$smilies_row_count = ( isset($this->_tpldata['smilies_row.']) ) ?  sizeof($this->_tpldata['smilies_row.']) : 0;
for ($smilies_row_i = 0; $smilies_row_i < $smilies_row_count; $smilies_row_i++)
{
 $smilies_row_item = &$this->_tpldata['smilies_row.'][$smilies_row_i];
 $smilies_row_item['S_ROW_COUNT'] = $smilies_row_i;
 $smilies_row_item['S_NUM_ROWS'] = $smilies_row_count;

?>
				<tr align="center" valign="middle"> 
				  <?php

$smilies_col_count = ( isset($smilies_row_item['smilies_col.']) ) ? sizeof($smilies_row_item['smilies_col.']) : 0;
for ($smilies_col_i = 0; $smilies_col_i < $smilies_col_count; $smilies_col_i++)
{
 $smilies_col_item = &$smilies_row_item['smilies_col.'][$smilies_col_i];
 $smilies_col_item['S_ROW_COUNT'] = $smilies_col_i;
 $smilies_col_item['S_NUM_ROWS'] = $smilies_col_count;

?>
				  <td><a href="javascript:emoticon('<?php echo isset($smilies_col_item['SMILEY_CODE']) ? $smilies_col_item['SMILEY_CODE'] : ''; ?>')"><img src="<?php echo isset($smilies_col_item['SMILEY_IMG']) ? $smilies_col_item['SMILEY_IMG'] : ''; ?>" border="0" alt="<?php echo isset($smilies_col_item['SMILEY_DESC']) ? $smilies_col_item['SMILEY_DESC'] : ''; ?>" title="<?php echo isset($smilies_col_item['SMILEY_DESC']) ? $smilies_col_item['SMILEY_DESC'] : ''; ?>" /></a></td>
				  <?php

} // END smilies_col

if(isset($smilies_col_item)) { unset($smilies_col_item); } 

?>
				</tr>
				<?php

} // END smilies_row

if(isset($smilies_row_item)) { unset($smilies_row_item); } 

?>
				<?php

$switch_smilies_extra_count = ( isset($this->_tpldata['switch_smilies_extra.']) ) ?  sizeof($this->_tpldata['switch_smilies_extra.']) : 0;
for ($switch_smilies_extra_i = 0; $switch_smilies_extra_i < $switch_smilies_extra_count; $switch_smilies_extra_i++)
{
 $switch_smilies_extra_item = &$this->_tpldata['switch_smilies_extra.'][$switch_smilies_extra_i];
 $switch_smilies_extra_item['S_ROW_COUNT'] = $switch_smilies_extra_i;
 $switch_smilies_extra_item['S_NUM_ROWS'] = $switch_smilies_extra_count;

?>
				<tr align="center"> 
				  <td colspan="<?php echo isset($this->vars['S_SMILIES_COLSPAN']) ? $this->vars['S_SMILIES_COLSPAN'] : $this->lang('S_SMILIES_COLSPAN'); ?>"><span  class="nav"><a href="<?php echo isset($this->vars['U_MORE_SMILIES']) ? $this->vars['U_MORE_SMILIES'] : $this->lang('U_MORE_SMILIES'); ?>" onclick="window.open('<?php echo isset($this->vars['U_MORE_SMILIES']) ? $this->vars['U_MORE_SMILIES'] : $this->lang('U_MORE_SMILIES'); ?>', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies" class="nav"><?php echo isset($this->vars['L_MORE_SMILIES']) ? $this->vars['L_MORE_SMILIES'] : $this->lang('L_MORE_SMILIES'); ?></a></span></td>
				</tr>
				<?php

} // END switch_smilies_extra

if(isset($switch_smilies_extra_item)) { unset($switch_smilies_extra_item); } 

?>
			  </table>
			</td>
		  </tr>
		</table>
	  </td>
	  <td class="row2" valign="top"><span class="gen"> <span class="genmed"> </span> 
		<table width="450" border="0" cellspacing="0" cellpadding="2">
		  <tr align="center" valign="middle"> 
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onclick="bbstyle(0)" onmouseover="helpline('b')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onclick="bbstyle(2)" onmouseover="helpline('i')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onclick="bbstyle(4)" onmouseover="helpline('u')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onclick="bbstyle(6)" onmouseover="helpline('q')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onclick="bbstyle(8)" onmouseover="helpline('c')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onclick="bbstyle(10)" onmouseover="helpline('l')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onclick="bbstyle(12)" onmouseover="helpline('o')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onmouseover="helpline('p')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onclick="bbstyle(16)" onmouseover="helpline('w')" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="9"> 
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 
				  <td><span class="genmed"> &nbsp;<?php echo isset($this->vars['L_FONT_COLOR']) ? $this->vars['L_FONT_COLOR'] : $this->lang('L_FONT_COLOR'); ?>: 
					<select name="addbbcode18" onchange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]')" onMouseOver="helpline('s')">
					  <option style="color:black; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="<?php echo isset($this->vars['T_FONTCOLOR1']) ? $this->vars['T_FONTCOLOR1'] : $this->lang('T_FONTCOLOR1'); ?>" class="genmed"><?php echo isset($this->vars['L_COLOR_DEFAULT']) ? $this->vars['L_COLOR_DEFAULT'] : $this->lang('L_COLOR_DEFAULT'); ?></option>
					  <option style="color:darkred; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="darkred" class="genmed"><?php echo isset($this->vars['L_COLOR_DARK_RED']) ? $this->vars['L_COLOR_DARK_RED'] : $this->lang('L_COLOR_DARK_RED'); ?></option>
					  <option style="color:red; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="red" class="genmed"><?php echo isset($this->vars['L_COLOR_RED']) ? $this->vars['L_COLOR_RED'] : $this->lang('L_COLOR_RED'); ?></option>
					  <option style="color:orange; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="orange" class="genmed"><?php echo isset($this->vars['L_COLOR_ORANGE']) ? $this->vars['L_COLOR_ORANGE'] : $this->lang('L_COLOR_ORANGE'); ?></option>
					  <option style="color:brown; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="brown" class="genmed"><?php echo isset($this->vars['L_COLOR_BROWN']) ? $this->vars['L_COLOR_BROWN'] : $this->lang('L_COLOR_BROWN'); ?></option>
					  <option style="color:yellow; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="yellow" class="genmed"><?php echo isset($this->vars['L_COLOR_YELLOW']) ? $this->vars['L_COLOR_YELLOW'] : $this->lang('L_COLOR_YELLOW'); ?></option>
					  <option style="color:green; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="green" class="genmed"><?php echo isset($this->vars['L_COLOR_GREEN']) ? $this->vars['L_COLOR_GREEN'] : $this->lang('L_COLOR_GREEN'); ?></option>
					  <option style="color:olive; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="olive" class="genmed"><?php echo isset($this->vars['L_COLOR_OLIVE']) ? $this->vars['L_COLOR_OLIVE'] : $this->lang('L_COLOR_OLIVE'); ?></option>
					  <option style="color:cyan; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="cyan" class="genmed"><?php echo isset($this->vars['L_COLOR_CYAN']) ? $this->vars['L_COLOR_CYAN'] : $this->lang('L_COLOR_CYAN'); ?></option>
					  <option style="color:blue; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="blue" class="genmed"><?php echo isset($this->vars['L_COLOR_BLUE']) ? $this->vars['L_COLOR_BLUE'] : $this->lang('L_COLOR_BLUE'); ?></option>
					  <option style="color:darkblue; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="darkblue" class="genmed"><?php echo isset($this->vars['L_COLOR_DARK_BLUE']) ? $this->vars['L_COLOR_DARK_BLUE'] : $this->lang('L_COLOR_DARK_BLUE'); ?></option>
					  <option style="color:indigo; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="indigo" class="genmed"><?php echo isset($this->vars['L_COLOR_INDIGO']) ? $this->vars['L_COLOR_INDIGO'] : $this->lang('L_COLOR_INDIGO'); ?></option>
					  <option style="color:violet; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="violet" class="genmed"><?php echo isset($this->vars['L_COLOR_VIOLET']) ? $this->vars['L_COLOR_VIOLET'] : $this->lang('L_COLOR_VIOLET'); ?></option>
					  <option style="color:white; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="white" class="genmed"><?php echo isset($this->vars['L_COLOR_WHITE']) ? $this->vars['L_COLOR_WHITE'] : $this->lang('L_COLOR_WHITE'); ?></option>
					  <option style="color:black; background-color: <?php echo isset($this->vars['T_TD_COLOR1']) ? $this->vars['T_TD_COLOR1'] : $this->lang('T_TD_COLOR1'); ?>" value="black" class="genmed"><?php echo isset($this->vars['L_COLOR_BLACK']) ? $this->vars['L_COLOR_BLACK'] : $this->lang('L_COLOR_BLACK'); ?></option>
					</select> &nbsp;<?php echo isset($this->vars['L_FONT_SIZE']) ? $this->vars['L_FONT_SIZE'] : $this->lang('L_FONT_SIZE'); ?>:<select name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
					  <option value="7" class="genmed"><?php echo isset($this->vars['L_FONT_TINY']) ? $this->vars['L_FONT_TINY'] : $this->lang('L_FONT_TINY'); ?></option>
					  <option value="9" class="genmed"><?php echo isset($this->vars['L_FONT_SMALL']) ? $this->vars['L_FONT_SMALL'] : $this->lang('L_FONT_SMALL'); ?></option>
					  <option value="12" selected class="genmed"><?php echo isset($this->vars['L_FONT_NORMAL']) ? $this->vars['L_FONT_NORMAL'] : $this->lang('L_FONT_NORMAL'); ?></option>
					  <option value="18" class="genmed"><?php echo isset($this->vars['L_FONT_LARGE']) ? $this->vars['L_FONT_LARGE'] : $this->lang('L_FONT_LARGE'); ?></option>
					  <option  value="24" class="genmed"><?php echo isset($this->vars['L_FONT_HUGE']) ? $this->vars['L_FONT_HUGE'] : $this->lang('L_FONT_HUGE'); ?></option>
					</select>
					</span></td>
				  <td nowrap="nowrap" align="right"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onmouseover="helpline('a')"><?php echo isset($this->vars['L_BBCODE_CLOSE_TAGS']) ? $this->vars['L_BBCODE_CLOSE_TAGS'] : $this->lang('L_BBCODE_CLOSE_TAGS'); ?></a></span></td>
				</tr>
			  </table>
			</td>
		  </tr>
		  <tr> 
			<td colspan="9"> <span class="gensmall"> 
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="<?php echo isset($this->vars['L_STYLES_TIP']) ? $this->vars['L_STYLES_TIP'] : $this->lang('L_STYLES_TIP'); ?>" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="9"><span class="gen"> 
			  <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"><?php echo isset($this->vars['MESSAGE']) ? $this->vars['MESSAGE'] : $this->lang('MESSAGE'); ?></textarea>
			</span></td>
		  </tr>
		</table>
		</span></td>
	</tr>
<?php

$access_choices_count = ( isset($this->_tpldata['access_choices.']) ) ?  sizeof($this->_tpldata['access_choices.']) : 0;
for ($access_choices_i = 0; $access_choices_i < $access_choices_count; $access_choices_i++)
{
 $access_choices_item = &$this->_tpldata['access_choices.'][$access_choices_i];
 $access_choices_item['S_ROW_COUNT'] = $access_choices_i;
 $access_choices_item['S_NUM_ROWS'] = $access_choices_count;

?>
	<tr>
	  <td class="row1" width="22%"><span class="genmed"><?php echo isset($access_choices_item['L_EVENT_ACCESS']) ? $access_choices_item['L_EVENT_ACCESS'] : ''; ?></span></td>
	  <td class="row2" width="78%" align='left'><span class="genmed"><select name="access_level" id="access_level" size="1" class="post" onchange="reset_access()">
		<?php echo isset($access_choices_item['S_EVENT_ACCESS']) ? $access_choices_item['S_EVENT_ACCESS'] : ''; ?>
		</select></span></td>
	</tr>
<?php

} // END access_choices

if(isset($access_choices_item)) { unset($access_choices_item); } 

?>

<?php

$group_choices_count = ( isset($this->_tpldata['group_choices.']) ) ?  sizeof($this->_tpldata['group_choices.']) : 0;
for ($group_choices_i = 0; $group_choices_i < $group_choices_count; $group_choices_i++)
{
 $group_choices_item = &$this->_tpldata['group_choices.'][$group_choices_i];
 $group_choices_item['S_ROW_COUNT'] = $group_choices_i;
 $group_choices_item['S_NUM_ROWS'] = $group_choices_count;

?>
	<tr>
	  <td class="row1" width="22%"><span class="genmed"><?php echo isset($group_choices_item['L_GROUP_CHOICE']) ? $group_choices_item['L_GROUP_CHOICE'] : ''; ?></span></td>
	  <td class="row2" width="78%" align='left'><span class="genmed"><select name="group_access[]" id="group_access" size="2" class="post" MULTIPLE onchange="change_access()">
		<?php echo isset($group_choices_item['S_GROUP_SELECT']) ? $group_choices_item['S_GROUP_SELECT'] : ''; ?> 
		</select>
		<?php echo isset($group_choices_item['L_GROUP_SELECT_EXPLAIN']) ? $group_choices_item['L_GROUP_SELECT_EXPLAIN'] : ''; ?></span></td>
	</tr>
<?php

} // END group_choices

if(isset($group_choices_item)) { unset($group_choices_item); } 

?>
	<tr> 
	  <td class="catBottom" colspan="2" align="center" height="28"> <?php echo isset($this->vars['S_HIDDEN_FORM_FIELDS']) ? $this->vars['S_HIDDEN_FORM_FIELDS'] : $this->lang('S_HIDDEN_FORM_FIELDS'); ?> <input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="<?php echo isset($this->vars['L_SUBMIT']) ? $this->vars['L_SUBMIT'] : $this->lang('L_SUBMIT'); ?>" /></td>
	</tr>
  </table>
</form>
<center>
<form method=POST action='<?php echo isset($this->vars['U_CAL_HOME']) ? $this->vars['U_CAL_HOME'] : $this->lang('U_CAL_HOME'); ?>'><input type=submit value="<?php echo isset($this->vars['L_CAL_HOME']) ? $this->vars['L_CAL_HOME'] : $this->lang('L_CAL_HOME'); ?>" class=mainoption></form>
</center>
