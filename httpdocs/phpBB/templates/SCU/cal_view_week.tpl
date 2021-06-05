<style type="text/css">
<!--
td.am_tiny {
	font-size: 8px;
	text-align: center;
	background-color: #CCCCCC;
	color: #000000;
	width: 20;
}

td.pm_tiny {
	font-size: 8px;
	text-align: center;
	background-color: #666666;
	color: #FFFFFF;
	width: 20;
}

td.mid_tiny {
	font-size: 8px;
	text-align: center;
	background-color: #999999;
	color: #FFFFFF;
	width: 20;
}

.eventspan {
	background-color: #0099FF;
	font-size : 9px;
	border: 1px solid #333333;
}
.recurspan {
	background-color: #00FF66;
	font-size : 9px;
	border: 1px solid #333333;
}
.multispan {
	background-color: #FF6600;
	font-size : 9px;
	border: 1px solid #333333;
}
.subject {
	font-size : 11px;
	overflow: hidden;
}

-->
</style>

{CATEGORY_CSS}

<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore,type){ //v3.0
  if (type=='category') myurl = '{U_JUMP_CAT}';
  else if (type=='month') myurl = '{U_JUMP_MONTH}';
  else myurl = '{U_JUMP_YEAR}';
  myurl += selObj.options[selObj.selectedIndex].value; 
  eval(targ+".location='"+myurl+"'");
  if (restore) selObj.selectedIndex=0;
}

/*
var cssTextHover, cssTextLink;  
function swc(id,fon) {
   if (document.all) {
     var d=document.all[id];  
     for(var i=0;i<d.length;i++){
	// go through everything of id "cal_id###" 
        d[i].style.cssText=(fon?cssTextHover:cssTextLink);  
     //set the style accordingly
     }  
   }
}  

function setup() { 
   if (document.all) {
     dd=document.styleSheets;  
     for(var j=0; j<dd.length; j++) { 
	var ss=document.styleSheets[j].rules; 
	     for(var i=0;i<ss.length;i++){ 
	     var rr=ss[i]; 
	     strSelector=rr.selectorText; 
	     if(strSelector=="A:hover") cssTextHover=rr.style.cssText; 
	     else if (strSelector=="A:link") cssTextLink=rr.style.cssText; 
	} 
     } 
   }
 }
setup();
*/

//-->
</script>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left">{PHPBBHEADER}<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -&gt;
		<a href="{U_CAL_HOME}" class="nav">{CALENDAR}</a></span></td>
		<td align=right class=genmed valign=bottom><span class="nav"></a> </span></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th height="25" class="thLeft" width="95%">
			{L_WEEK_VIEW} 
		</th>
		<th height="25" class="thRight" width="5%" NOWRAP>
				<a href="{U_MONTH}"><img src="{IMG_MONTH}" alt="{L_MONTH_LINK}" border="0"></a>
				<a href="{U_YEAR}"><img src="{IMG_YEAR}" alt="{L_YEAR_LINK}" border="0"></a>
		</th>
	</tr>
	<tr>
		<td height="10" class="thHead" colspan="2" width="100%">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			{BUTTON_PREV}
			<td class=gensmall align="center" width="100%">&nbsp;<i>{FILTER}</i>&nbsp;</td>
			{BUTTON_NEXT}
			</tr>
			</table>
		</td>
	</tr>
	<tr>
	<td colspan="2" width="100%">
	<table width="750" border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td width="250" NOWRAP><strong>&nbsp;</strong></td>
<!--		<td width="100"><strong>&nbsp;</strong></td> -->
		<td colspan="10" class="genmed">&nbsp;</td>
		<td colspan="30" class="genmed">&nbsp;</td>
		<td colspan="8" class="genmed">&nbsp;</td>
	  </tr>
<!-- BEGIN new_row -->
<!-- BEGIN header_row -->
	  <tr>
		<td class="rowpic" colspan="2"><span class="genmed"><b>{new_row.header_row.DAY}</b></span> <span class="gensmall">[{new_row.DATE}]</span></td>
		<td colspan="1" class="am_tiny">&nbsp;</td>
		<td colspan="2" class="am_tiny">1</td>
		<td colspan="2" class="am_tiny">2</td>
		<td colspan="2" class="am_tiny">3</td>
		<td colspan="2" class="am_tiny">4</td>
		<td colspan="2" class="am_tiny">5</td>
		<td colspan="2" class="am_tiny">6</td>
		<td colspan="2" class="am_tiny">7</td>
		<td colspan="2" class="am_tiny">8</td>
		<td colspan="2" class="am_tiny">9</td>
		<td colspan="2" class="am_tiny">10</td>
		<td colspan="2" class="am_tiny">11</td>
		<td colspan="2" class="mid_tiny">12</td>
		<td colspan="2" class="pm_tiny">1</td>
		<td colspan="2" class="pm_tiny">2</td>
		<td colspan="2" class="pm_tiny">3</td>
		<td colspan="2" class="pm_tiny">4</td>
		<td colspan="2" class="pm_tiny">5</td>
		<td colspan="2" class="pm_tiny">6</td>
		<td colspan="2" class="pm_tiny">7</td>
		<td colspan="2" class="pm_tiny">8</td>
		<td colspan="2" class="pm_tiny">9</td>
		<td colspan="2" class="pm_tiny">10</td>
		<td colspan="2" class="pm_tiny">11</td>
		<td colspan="1" class="pm_tiny">&nbsp;</td>
	  </tr>
<!-- END header_row -->
<!-- BEGIN event_row -->
	  <tr>
		<td class="subject" colspan="2">{new_row.event_row.BULLET}<a href='{new_row.event_row.U_EVENT}' title="{new_row.event_row.FULL_SUBJECT}" {new_row.event_row.COL_CAT}>{new_row.event_row.SUBJECT}</a></td>
<!--		<td class="gensmall" NOWRAP align="right"><i>{new_row.event_row.TIMES}</i></td>	-->	
<!-- BEGIN start_blank -->
		<td colspan="{new_row.event_row.start_blank.COLSPAN}" class="gensmall" align="right"><i>{new_row.event_row.start_blank.DATE}</i>&nbsp;</td>
<!-- END start_blank -->
<!-- BEGIN event_record -->
		<td colspan="{new_row.event_row.event_record.COLSPAN}" class="{new_row.event_row.event_record.SPAN_CLASS}" align="center">&nbsp;<i>{new_row.event_row.event_record.DATE}</i></td>
<!-- END event_record -->
<!-- BEGIN end_blank -->
		<td colspan="{new_row.event_row.end_blank.COLSPAN}" class="gensmall" align="left">&nbsp;<i>{new_row.event_row.end_blank.DATE}</i></td>
<!-- END end_blank -->
	  </tr>
<!-- END event_row -->
<!-- BEGIN empty_day_row -->
	  <tr>
		<td class="genmed" colspan="2">&nbsp;</td>
		<td colspan="48" class="genmed" align="center"><i>{NO_EVENTS}</i></td>
	  </tr>
<!-- END empty_day_row -->
<!-- BEGIN day_spacer -->
	  <tr>
		<td colspan="50" class="genmed" align="center"><hr width="100%" size="1"></td>
	  </tr>
<!-- END day_spacer -->
<!-- END new_row -->
	  <tr>
		<td colspan="50" class="genmed" align="center">&nbsp;</td>
	  </tr>
	</table>
        </td>
	</tr>
</table>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
	<form action="{S_POST_ACTION}" method="post" name="post">
	<td width=50% align='left'><span class=gensmall>{L_MONTH_JUMP}</span><br>
	<!-- <SELECT name='month' onChange="MM_jumpMenu('parent',this,1,'month')"> -->
	<!-- <SELECT name='year' onChange="MM_jumpMenu('parent',this,1,'year')"> -->
	<!-- You can use the code above to create instant jumpboxes if you prefer -->
	<SELECT name='month'>
	{S_MONTH}
 	</SELECT><SELECT name='year'> -->
	{S_YEAR}
 	</SELECT><input type="submit" class="liteoption" value="{L_GO}" name="submit2"></td></form>
	{BUTTON_ADD}{BUTTON_VALIDATE}
<!-- BEGIN no_categories -->
	<td width=50% align='right'>&nbsp;</td>
<!-- END no_categories -->
<!-- BEGIN category_select -->
	<form action="{category_select.S_POST_ACTION}" method="post" name="post">
	<td width=50% align='right'><span class=gensmall>{category_select.L_FILTER_CATS}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
	<SELECT name='category' onChange="MM_jumpMenu('parent',this,1,'category')">
	{category_select.S_CATEGORY}
 	</SELECT><input type="submit" class="liteoption" value="{L_GO}" name="submit2"></td></form>
<!-- END category_select -->
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
 
</center>
