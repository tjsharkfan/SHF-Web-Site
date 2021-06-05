<link rel="stylesheet" media="screen" href="includes/calpro/dyncal/dynCalendar.css" />
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
b_help = "{L_BBCODE_B_HELP}";
i_help = "{L_BBCODE_I_HELP}";
u_help = "{L_BBCODE_U_HELP}";
q_help = "{L_BBCODE_Q_HELP}";
c_help = "{L_BBCODE_C_HELP}";
l_help = "{L_BBCODE_L_HELP}";
o_help = "{L_BBCODE_O_HELP}";
p_help = "{L_BBCODE_P_HELP}";
w_help = "{L_BBCODE_W_HELP}";
a_help = "{L_BBCODE_A_HELP}";
s_help = "{L_BBCODE_S_HELP}";
f_help = "{L_BBCODE_F_HELP}";

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
imageTag = false;

// Define the date related info
var months = new Array("", "{L_JAN}", "{L_FEB}", "{L_MAR}", "{L_APR}", "{L_MAY}", "{L_JUN}", 
			"{L_JUL}", "{L_AUG}", "{L_SEP}", "{L_OCT}", "{L_NOV}", "{L_DEC}");

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
		formErrors = "{L_EMPTY_SUBJECT}\n";
	}
	if (document.post.message.value.length < 2) {
		formErrors += "{L_EMPTY_DESC}\n";
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
		error = datetype + ": " + months[mm] + " ({L_MAX} 30 {L_DAY})\n";
	}
	else if(mm == 2) {
		if (yyyy % 4 > 0 && dd > 28) {
			error = datetype + ": " + months[2] + " ({L_MAX} 28 {L_DAY})\n";
		}
		else if (dd > 29) {
			error = datetype + ": " + months[2] + " ({L_MAX} 29 {L_DAY})\n";
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
<!-- BEGIN access_check -->
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

<!-- END access_check -->
<!-- BEGIN null_check -->
function change_access() {
}
function reset_access() {
}
<!-- END null_check -->
//-->
</SCRIPT>
<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)">

{ERROR_BOX}

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left">{PHPBBHEADER}<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -&gt;
		<a href="{U_CAL_HOME}" class="nav">{CALENDAR}</a></span></td>
		<td align=right class=genmed valign=bottom></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25"><b>{L_CAL_NEW}</b>{L_CAL_NEW_NOTE}</th>
	</tr>
	<tr>
	    <td class="row1" colspan="2">
	      <table width="100%" border="0" cellpadding="2" cellspacing="0">
		<tr>
		  <td width="50%" valign="top">
<!-- BEGIN date_info -->
		      <table width="100%" border="0" cellpadding="2" cellspacing="1" class="forumline">
			<tr>
			  <td class="row3" colspan="2" align="center"><span class="gen"><b>{date_info.L_CAL_TITLE}</b></span></td>
			</tr>
	                <tr> 
        	          <td width="19%" class="row1"><span class="gen"><b>{date_info.L_CAL_DATE}</b></span></td>
                	  <td class="row2"> <span class="gen"> 
        	            <select name=day size=1 class="post" style="width: 50px" onchange="document.post.day_end.value=document.post.day.value">
                	      {date_info.THIS_DAY}
	                    </select>
        	            <select size=1 name=month class="post" onchange="document.post.month_end.value=document.post.month.value">
                	      {date_info.THIS_MONTH}
	                    </select>
        	            <select name=year size=1 class="post" onchange="document.post.year_end.value=document.post.year.value">
                	      {date_info.THIS_YEAR}
	                    </select>
        	            </span>
			<script language="JavaScript" type="text/javascript">
			<!--
			/**
			* Date set function for start date
			*/
			start_cal = new dynCalendar('start_cal', 'Date_set_Start', {DAY}, {MONTH}, {YEAR}, 'includes/calpro/dyncal/images/');
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
                	  <td width="19%" class="row1"><span class="gen"><b>{date_info.L_CAL_TIME}</b></span></td>
	                  <td class="row2"> <span class="gen">
	                    <select name=hour size=1 style="width: 45px">
                	      {date_info.THIS_HOUR}
        	            </select>:
                	    <select name=minute size=1 class="post" style="width: 50px">
	                      {date_info.THIS_MIN}
        	            </select>
			      {date_info.THIS_AM_PM}
    	                  </span>
			  </td>
        	        </tr>
	                <tr> 
        	          <td width="19%" class="row1"><span class="gen"><b>{date_info.L_CAL_ENDDATE}</b></span></td>
                	  <td class="row2"> <span class="gen"> 
        	            <select name=day_end size=1 class="post" style="width: 50px">
                	      {date_info.END_DAY}
	                    </select>
        	            <select size=1 name=month_end class="post">
                	      {date_info.END_MONTH}
	                    </select>
        	            <select name=year_end size=1 class="post">
                	      {date_info.END_YEAR}
	                    </select>
        	            </span>
			<script language="JavaScript" type="text/javascript">
			<!--
			/**
			* Date set function for start date
			*/
			end_cal = new dynCalendar('end_cal', 'Date_set_End', {END_DAY}, {END_MONTH}, {END_YEAR}, 'includes/calpro/dyncal/images/');
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
                	  <td width="19%" class="row1"><span class="gen"><b>{date_info.L_CAL_ENDTIME}</b></span></td>
	                  <td class="row2"> <span class="gen">
	                    <select name=hour_end size=1 style="width: 45px">
                	      {date_info.END_HOUR}
        	            </select>:
                	    <select name=minute_end size=1 class="post" style="width: 50px">
	                      {date_info.END_MIN}
        	            </select>
			      {date_info.END_AM_PM}
    	                  </span>
			  </td>
        	        </tr>
		      </table>
<!-- END date_info -->
		     </td>
		     <td width="50%" valign="top" class="row1">
<!-- BEGIN repeat_info -->
		      <table width="100%" border="0" cellpadding="2" cellspacing="1" class="forumline">
			<tr>
			  <td class="row3" colspan="2" align="center"><span class="gen"><b>{repeat_info.L_CAL_TITLE_REC}</b></span></td>
			</tr>
                	<tr>
	                  <td width="19%" NOWRAP class="row1"><span class=gen><b>{repeat_info.L_REPEAT}</b></span></td>
        	          <td NOWRAP class="row2"><span class="gen">
	                    <select size=1 name=r_num class="post" style="width: 45px">
        	              {repeat_info.R_NUM}
	                    </select>
        	            <select size=1 name=r_period class="post" style="width: 90px">
	                      {repeat_info.R_PERIOD}
        	            </select>
	                    </span>
			  </td>
	                </tr>
                	<tr>
	                  <td width="19%" NOWRAP class="row1" align="right"><span class=gen><b>{repeat_info.L_OR}</b></span></td>
        	          <td NOWRAP class="row2"><span class="gen">
	                    <select size=1 name=r_nth_num class="post" style="width: 45px">
        	              {repeat_info.NTH_NUM}
	                    </select>
        	            <select size=1 name=r_nth_period class="post" style="width: 90px">
	                      {repeat_info.NTH_PERIOD}
        	            </select>
	                    </span>
			  </td>
	                </tr>
        	        <tr>
                	  <td width="19%" NOWRAP class="row1" align='right'><b><span class=gen>...{repeat_info.L_UNTIL}:
			    </span></b></td>
		                  <td NOWRAP class="row2"><span class="gen">
	                    <select name=stop_day size=1 class="post" style="width: 45px">
        	              {repeat_info.STOP_DAY}
	                    </select>
        	            <select size=1 name=stop_month class="post" style="width: 90px">
	                      {repeat_info.STOP_MONTH}
        	            </select>
	                    <select size=1 name=stop_year class="post">
        	              {repeat_info.STOP_YEAR}
	                    </select>
        	            </span>
			<script language="JavaScript" type="text/javascript">
			<!--
			/**
			* Date set function for Recurring date
			*/
			recur_cal = new dynCalendar('recur_cal', 'Date_set_Recur', {STOP_DAY}, {STOP_MONTH}, {STOP_YEAR}, 'includes/calpro/dyncal/images/');
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
			  <td width="19%" NOWRAP class="row1" align='right'><span class=gen><b>{repeat_info.L_EVENT_NUM}</b></span></td>
			  <td NOWRAP class="row2"><span class=gen><b>{repeat_info.EVENT_INFO} </b></span><span class=genmed><i>{repeat_info.EARLY_ITERATION}</i></span></td>
			</tr>
        	      </table>
<!-- END repeat_info -->
		  </td>
		</tr>
	      </table>
	    </td>
	</tr>
<!-- BEGIN global_info -->
	<tr>
	  <td class="row1" width="22%" align='right'><span class="genmed">{global_info.L_GLOBAL_SUBJECT}</span></td>
	  <td class="row2" width="78%"><span class="genmed">{global_info.GLOBAL_SUBJECT}</span></td>
	</tr>
	<tr>
	  <td class="row1" width="22%" align='right'><span class="genmed">{global_info.L_GLOBAL_DESC}</span></td>
	  <td class="row2" width="78%"><span class="genmed">{global_info.GLOBAL_DESC}</span></td>
	</tr>
<!-- END global_info -->
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span> <span class="genmed"><i>{L_SUBJECT_XTRA}</i></span></td>
	  <td class="row2" width="78%"> <span class="gen">
		<input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" />
		</span> </td>
	</tr>
<!-- BEGIN category_row -->
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{category_row.L_CATEGORY}</b></span></td>
	  <td class="row2" width="78%"> 
		<select size=1 name=category><span class="genmed">
		{category_row.CATEGORY_SELECT}
		</select>
		</span></td>
	</tr>
<!-- END category_row -->
	<tr> 
	  <td class="row1" valign="top"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td><span class="gen"><b>{L_MESSAGE_BODY}</b></span> </td>
		  </tr>
		  <tr> 
			<td valign="middle" align="center"> <br />
			  <table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><b>{L_EMOTICONS}</b></td>
				</tr>
				<!-- BEGIN smilies_row -->
				<tr align="center" valign="middle"> 
				  <!-- BEGIN smilies_col -->
				  <td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
				  <!-- END smilies_col -->
				</tr>
				<!-- END smilies_row -->
				<!-- BEGIN switch_smilies_extra -->
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
				</tr>
				<!-- END switch_smilies_extra -->
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
				  <td><span class="genmed"> &nbsp;{L_FONT_COLOR}: 
					<select name="addbbcode18" onchange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]')" onMouseOver="helpline('s')">
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="{T_FONTCOLOR1}" class="genmed">{L_COLOR_DEFAULT}</option>
					  <option style="color:darkred; background-color: {T_TD_COLOR1}" value="darkred" class="genmed">{L_COLOR_DARK_RED}</option>
					  <option style="color:red; background-color: {T_TD_COLOR1}" value="red" class="genmed">{L_COLOR_RED}</option>
					  <option style="color:orange; background-color: {T_TD_COLOR1}" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
					  <option style="color:brown; background-color: {T_TD_COLOR1}" value="brown" class="genmed">{L_COLOR_BROWN}</option>
					  <option style="color:yellow; background-color: {T_TD_COLOR1}" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
					  <option style="color:green; background-color: {T_TD_COLOR1}" value="green" class="genmed">{L_COLOR_GREEN}</option>
					  <option style="color:olive; background-color: {T_TD_COLOR1}" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
					  <option style="color:cyan; background-color: {T_TD_COLOR1}" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
					  <option style="color:blue; background-color: {T_TD_COLOR1}" value="blue" class="genmed">{L_COLOR_BLUE}</option>
					  <option style="color:darkblue; background-color: {T_TD_COLOR1}" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
					  <option style="color:indigo; background-color: {T_TD_COLOR1}" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
					  <option style="color:violet; background-color: {T_TD_COLOR1}" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
					  <option style="color:white; background-color: {T_TD_COLOR1}" value="white" class="genmed">{L_COLOR_WHITE}</option>
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="black" class="genmed">{L_COLOR_BLACK}</option>
					</select> &nbsp;{L_FONT_SIZE}:<select name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
					  <option value="7" class="genmed">{L_FONT_TINY}</option>
					  <option value="9" class="genmed">{L_FONT_SMALL}</option>
					  <option value="12" selected class="genmed">{L_FONT_NORMAL}</option>
					  <option value="18" class="genmed">{L_FONT_LARGE}</option>
					  <option  value="24" class="genmed">{L_FONT_HUGE}</option>
					</select>
					</span></td>
				  <td nowrap="nowrap" align="right"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onmouseover="helpline('a')">{L_BBCODE_CLOSE_TAGS}</a></span></td>
				</tr>
			  </table>
			</td>
		  </tr>
		  <tr> 
			<td colspan="9"> <span class="gensmall"> 
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="9"><span class="gen"> 
			  <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea>
			</span></td>
		  </tr>
		</table>
		</span></td>
	</tr>
<!-- BEGIN access_choices -->
	<tr>
	  <td class="row1" width="22%"><span class="genmed">{access_choices.L_EVENT_ACCESS}</span></td>
	  <td class="row2" width="78%" align='left'><span class="genmed"><select name="access_level" id="access_level" size="1" class="post" onchange="reset_access()">
		{access_choices.S_EVENT_ACCESS}
		</select></span></td>
	</tr>
<!-- END access_choices -->

<!-- BEGIN group_choices -->
	<tr>
	  <td class="row1" width="22%"><span class="genmed">{group_choices.L_GROUP_CHOICE}</span></td>
	  <td class="row2" width="78%" align='left'><span class="genmed"><select name="group_access[]" id="group_access" size="2" class="post" MULTIPLE onchange="change_access()">
		{group_choices.S_GROUP_SELECT} 
		</select>
		{group_choices.L_GROUP_SELECT_EXPLAIN}</span></td>
	</tr>
<!-- END group_choices -->
	<tr> 
	  <td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS} <input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" /></td>
	</tr>
  </table>
</form>
<center>
<form method=POST action='{U_CAL_HOME}'><input type=submit value="{L_CAL_HOME}" class=mainoption></form>
</center>
