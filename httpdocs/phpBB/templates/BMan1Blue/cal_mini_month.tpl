<!-- <link rel="stylesheet" href="templates/subSilver/subSilver.css" type="text/css"> -->
<style type="text/css">
<!--
.head_tiny,.head_blank {
	font-size: 9px;
	text-align: center;
}

td.row1	{ background-color: #EFEFEF; }
td.row2	{ background-color: #DEE3E7; }
td.row3	{ background-color: #D1D7DC; }

td.rowpic {
		background-color: #FFFFFF;
		background-image: url(templates/subSilver/images/cellpic2.jpg);
		background-repeat: repeat-y;
}

font,th,td,p { font-family: Verdana, Arial, Helvetica, sans-serif }
a:link,a:active,a:visited { color : #006699; }
a:hover		{ text-decoration: underline; color : #DD6900; }
hr	{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px;}


/* This is the border line & background colour round the entire page */
.bodyline	{ background-color: #FFFFFF; border: 1px #98AAB1 solid; }

/* This is the outline round the main forum tables */
.forumline	{ background-color: #FFFFFF; border: 2px #006699 solid; }

/* General text */
.gen { font-size : 12px; }
.genmed { font-size : 11px; }
.gensmall { font-size : 10px; }
.gen,.genmed,.gensmall { color : #000000; }
a.gen,a.genmed,a.gensmall { color: #006699; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: #DD6900; text-decoration: underline; }


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
<!-- BEGIN set -->
<table border="0"  border="0" cellpadding="0" cellspacing="2">
	<tr>
<!-- BEGIN month -->
	<td width="390" valign="top">
		<table width="190" border="0" cellpadding="0" cellspacing="0" class="forumline">
			<tr align="center">
				<td colspan="8" class="rowpic"><strong><a href="{URL_ROOT}{set.month.U_MONTH}" class="genmed" target="_self">{set.month.L_MONTH} {set.month.N_YEAR}</a></strong></td>
			</tr>
<!-- BEGIN month_header -->
			<tr>
				<td width="15" class="head_tiny">&nbsp;</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{set.month.month_header.L_DAY_1}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{set.month.month_header.L_DAY_2}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{set.month.month_header.L_DAY_3}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{set.month.month_header.L_DAY_4}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{set.month.month_header.L_DAY_5}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{set.month.month_header.L_DAY_6}</td>
				<td width="25" nowrap="nowrap" class="head_tiny">{set.month.month_header.L_DAY_7}</td>
			</tr>
<!-- END month_header -->
<!-- BEGIN week -->
			<tr>
				<td class="rowpic"><a href="{URL_ROOT}{set.month.week.U_WEEK}" class="gensmall" target="_self"><strong>W</strong></a></td>
<!-- BEGIN empty_start -->
				<td class="day" colspan="{set.month.week.empty_start.SPAN}">&nbsp;</td>
<!-- END empty_start -->
<!-- BEGIN day -->
				<td class="{set.month.week.day.C_DAY}">{set.month.week.day.N_DAY}</td>
<!-- END day -->
<!-- BEGIN empty_end -->
				<td class="day" colspan="{set.month.week.empty_end.SPAN}">&nbsp;</td>
<!-- END empty_end -->
			</tr>
<!-- END week -->
		</table>
	</td>
<!-- END month -->
	</tr>
</table>
<!-- END set -->
