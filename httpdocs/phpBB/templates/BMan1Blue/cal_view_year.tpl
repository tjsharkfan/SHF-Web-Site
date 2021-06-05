<style type="text/css">
<!--
.head_tiny,.head_blank {
	font-size: 9px;
	text-align: center;
}
td.head_tiny {
	background-color: #CCCCCC;
	color: #000000;
}

td.head_blank {
	background-color: #666666;
	color: #FFFFFF;
}

.day,.pub,.grp,.prv,.mix {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
	text-align: right;
	padding: 2px;
}

td.day {
	border: 1px solid #000000;
}
a.day			{
	text-decoration: none;
	color : #FFFFFF;
	font-weight: normal;
}
a.day:hover		{
	text-decoration: underline;
	font-weight: bold;
	color: #FF9900;
}

td.pub {
	border: 1px solid #DDDDDD;
	background-color: #6699FF;
}
td.grp {
	border: 1px solid #DDDDDD;
	background-color: #FF6699;
}
td.prv {
	border: 1px solid #DDDDDD;
	background-color: #CC66FF;
}
td.mix {
	border: 1px solid #DDDDDD;
	background-color: #EE7700;
}
-->
</style>

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
//-->
</script>

<table border="0" cellspacing="5" cellpadding="5" class="forumline" width="100%">
	<tr>
		<th colspan="4" class="thHead">{N_YEAR}</th>
	</tr>
	<tr>
		<td height="10" width="100%" colspan="4">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
{BUTTON_PREV}
			<td class=gensmall align="center" width="100%">&nbsp;<i>{FILTER}</i>&nbsp;</td>
{BUTTON_NEXT}
			</table>
		</td>
	</tr>
<!-- BEGIN quarter -->
	<tr>
<!-- BEGIN month -->
		<td width="25%" valign="top" align="center">
		<table width="190" border="0" cellpadding="0" cellspacing="0" class="forumline">
			<tr align="center">
				<td colspan="8" class="rowpic"><strong><a href="{quarter.month.U_MONTH}" class="genmed">{quarter.month.L_MONTH} {quarter.month.N_YEAR}</a></strong></td>
			</tr>
<!-- BEGIN month_header -->
			<tr>
				<td width="15" class="head_tiny">&nbsp;</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{quarter.month.month_header.L_DAY_1}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{quarter.month.month_header.L_DAY_2}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{quarter.month.month_header.L_DAY_3}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{quarter.month.month_header.L_DAY_4}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{quarter.month.month_header.L_DAY_5}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{quarter.month.month_header.L_DAY_6}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{quarter.month.month_header.L_DAY_7}</td>
			</tr>
<!-- END month_header -->
<!-- BEGIN week -->
			<tr>
				<td class="rowpic"><a href="{quarter.month.week.U_WEEK}" class="gensmall"><strong>W</strong></a></td>
<!-- BEGIN empty_start -->
				<td class="day" colspan="{quarter.month.week.empty_start.SPAN}">&nbsp;</td>
<!-- END empty_start -->
<!-- BEGIN day -->
				<td class="{quarter.month.week.day.C_DAY}">{quarter.month.week.day.N_DAY}</td>
<!-- END day -->
<!-- BEGIN empty_end -->
				<td class="day" colspan="{quarter.month.week.empty_end.SPAN}">&nbsp;</td>
<!-- END empty_end -->
			</tr>
<!-- END week -->
		</table>
		</td>
<!-- END month -->
	</tr>
<!-- END quarter -->
</table>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
	<form action="{S_POST_ACTION}" method="post" name="post">
	<td width=50% align='left'><span class=gensmall>{L_YEAR_START}</span><br>
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
</center>