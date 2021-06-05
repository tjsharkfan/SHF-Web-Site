<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" -->
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>{SITENAME} :: {PAGE_TITLE}</title>
<style type="text/css">
<!--
body {
    font-family: {T_FONTFACE1};
    font-size: 12px ;
    letter-spacing: 1px;
}

/* This is the border line & background colour round the entire page */
.bodyline	{ background-color: #FFFFFF; border: 1px #98AAB1 solid; }

/* This is the outline round the main forum tables */
.forumline	{ background-color: #FFFFFF; border: 2px #006699 solid; }

/* Quote & Code blocks */
.code, .quote, .php {
    font-size: 11px;
	border: black; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}
.Forum {
    font-weight : bold;
    font-size: 18px;
}
.Topic {
    font-weight : bold;
    font-size: 14px;
}
 	    	 	 			    	 
/* General text */
.gen { font-size : 12px; }
.genmed { font-size : 11px; }
.gensmall { font-size : 10px; }
.gen,.genmed,.gensmall { color : #000000; }

hr.sep	{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px;}

.copyright		{ font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #444444; letter-spacing: -1px;}
-->
</style>

{CATEGORY_CSS}

</head>
<body>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><span class="gen"><strong>{L_INDEX}</strong> -&gt;
		<strong>{CALENDAR}</strong></span></td>
		<td align="right"><span class="gensmall">({PRINTER_VER})</span></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="white">
       <tr>
	<th height="25" class="thHead">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<td><center><span class=gen><b>{CAL_MONTH} {CAL_YEAR} <span class=gensmall>{FILTER}</span></b></span></center></td>
		</table>
	</th>
       </tr>
       <tr>
	<td>
	<table width=100% cellpadding=1 cellspacing=1 border=0 style="border-collapse: expand; border-color=black;">
	<tr>
          <td class="forumline" width="14%" align="center"><span class="gen"><strong>{DAY_HEAD_1}</span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong>{DAY_HEAD_2}</span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong>{DAY_HEAD_3}</span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong>{DAY_HEAD_4}</span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong>{DAY_HEAD_5}</span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong>{DAY_HEAD_6}</span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong>{DAY_HEAD_7}</span></td>
        </tr>
<!-- BEGIN week_row -->
        <tr>
<!-- BEGIN this_mon -->
	  <td valign=top {week_row.this_mon.S_CELL}>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 {week_row.this_mon.S_HEAD}><strong>{week_row.this_mon.NUM_DAY}</strong></td></tr>
	    <tr><td valign=top {week_row.this_mon.S_DETAILS}>{week_row.this_mon.DAY_EVENT_LIST}</td></tr>
 	    </table>
	  </td>
<!-- END this_mon -->
        </tr>
<!-- END week_row -->
        </table>
        </td>
     </tr>
</table>
<!-- BEGIN cat_legend --> 
<table border="0" cellspacing="2" cellpadding="2" align="center" class="bodyline"> 
<tr align="left" valign="top"> 
	<td class="genmed" valign="middle"><b>{cat_legend.CAT_LEGEND}</b></td> 
	<td class="gensmall" valign="middle">
<!-- BEGIN cat_colorcode --> 
<span class="cal_{cat_legend.cat_colorcode.ID}">{cat_legend.cat_colorcode.NAME}</span>{cat_legend.cat_colorcode.DIVIDER}
<!-- END cat_colorcode --> 
	</td> 
</tr>
</table> 
<!-- END cat_legend --> 
<center>
<a href="javascript:history.back()" class="genmed">{L_BAK2CAL}</a>
</center>
  <hr />
<div align="center">{S_TIMEZONE}<br />
 	    	 	 			    	 
  <!--
	Please note that the following copyright notice
	MUST be displayed on each and every page output
	by phpBB. You may alter the font, colour etc. but
	you CANNOT remove it, nor change it so that it be,
	to all intents and purposes, invisible. You may ADD
	your own notice to it should you have altered the
	code but you may not replace it. The hyperlink must
	also remain intact. These conditions are part of the
	licence this software is released under. See the
	LICENCE and README files for more information.

	The phpBB Group : 2001
// -->
 	    	 	 			    	 
<span class="copyright"> Powered by <a href="http://www.phpbb.com/" target="_phpbb" class="copyright">phpBB</a> &amp; <a href="http://www.snailsource.com/" target="_phpbb" class="copyright">Calendar Pro</a> &copy; 2003</span>
</div>
</body>
</html>