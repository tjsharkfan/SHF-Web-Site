<?php

// eXtreme Styles mod cache. Generated on Fri, 30 Oct 2015 12:56:22 -0400 (time=1446224182)

?><style type="text/css">
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
  if (type=='category') myurl = '<?php echo isset($this->vars['U_JUMP_CAT']) ? $this->vars['U_JUMP_CAT'] : $this->lang('U_JUMP_CAT'); ?>';
  else if (type=='month') myurl = '<?php echo isset($this->vars['U_JUMP_MONTH']) ? $this->vars['U_JUMP_MONTH'] : $this->lang('U_JUMP_MONTH'); ?>';
  else myurl = '<?php echo isset($this->vars['U_JUMP_YEAR']) ? $this->vars['U_JUMP_YEAR'] : $this->lang('U_JUMP_YEAR'); ?>';
  myurl += selObj.options[selObj.selectedIndex].value; 
  eval(targ+".location='"+myurl+"'");
  if (restore) selObj.selectedIndex=0;
} 
//-->
</script>

<table border="0" cellspacing="5" cellpadding="5" class="forumline" width="100%">
	<tr>
		<th colspan="4" class="thHead"><?php echo isset($this->vars['N_YEAR']) ? $this->vars['N_YEAR'] : $this->lang('N_YEAR'); ?></th>
	</tr>
	<tr>
		<td height="10" width="100%" colspan="4">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
<?php echo isset($this->vars['BUTTON_PREV']) ? $this->vars['BUTTON_PREV'] : $this->lang('BUTTON_PREV'); ?>
			<td class=gensmall align="center" width="100%">&nbsp;<i><?php echo isset($this->vars['FILTER']) ? $this->vars['FILTER'] : $this->lang('FILTER'); ?></i>&nbsp;</td>
<?php echo isset($this->vars['BUTTON_NEXT']) ? $this->vars['BUTTON_NEXT'] : $this->lang('BUTTON_NEXT'); ?>
			</table>
		</td>
	</tr>
<?php

$quarter_count = ( isset($this->_tpldata['quarter.']) ) ?  sizeof($this->_tpldata['quarter.']) : 0;
for ($quarter_i = 0; $quarter_i < $quarter_count; $quarter_i++)
{
 $quarter_item = &$this->_tpldata['quarter.'][$quarter_i];
 $quarter_item['S_ROW_COUNT'] = $quarter_i;
 $quarter_item['S_NUM_ROWS'] = $quarter_count;

?>
	<tr>
<?php

$month_count = ( isset($quarter_item['month.']) ) ? sizeof($quarter_item['month.']) : 0;
for ($month_i = 0; $month_i < $month_count; $month_i++)
{
 $month_item = &$quarter_item['month.'][$month_i];
 $month_item['S_ROW_COUNT'] = $month_i;
 $month_item['S_NUM_ROWS'] = $month_count;

?>
		<td width="25%" valign="top" align="center">
		<table width="190" border="0" cellpadding="0" cellspacing="0" class="forumline">
			<tr align="center">
				<td colspan="8" class="rowpic"><strong><a href="<?php echo isset($month_item['U_MONTH']) ? $month_item['U_MONTH'] : ''; ?>" class="genmed"><?php echo isset($month_item['L_MONTH']) ? $month_item['L_MONTH'] : ''; ?> <?php echo isset($month_item['N_YEAR']) ? $month_item['N_YEAR'] : ''; ?></a></strong></td>
			</tr>
<?php

$month_header_count = ( isset($month_item['month_header.']) ) ? sizeof($month_item['month_header.']) : 0;
for ($month_header_i = 0; $month_header_i < $month_header_count; $month_header_i++)
{
 $month_header_item = &$month_item['month_header.'][$month_header_i];
 $month_header_item['S_ROW_COUNT'] = $month_header_i;
 $month_header_item['S_NUM_ROWS'] = $month_header_count;

?>
			<tr>
				<td width="15" class="head_tiny">&nbsp;</td>
				<td width="25" nowrap="nowrap" class="head_tiny"><?php echo isset($month_header_item['L_DAY_1']) ? $month_header_item['L_DAY_1'] : ''; ?></td>
				<td width="25" nowrap="nowrap" class="head_tiny"><?php echo isset($month_header_item['L_DAY_2']) ? $month_header_item['L_DAY_2'] : ''; ?></td>
				<td width="25" nowrap="nowrap" class="head_tiny"><?php echo isset($month_header_item['L_DAY_3']) ? $month_header_item['L_DAY_3'] : ''; ?></td>
				<td width="25" nowrap="nowrap" class="head_tiny"><?php echo isset($month_header_item['L_DAY_4']) ? $month_header_item['L_DAY_4'] : ''; ?></td>
				<td width="25" nowrap="nowrap" class="head_tiny"><?php echo isset($month_header_item['L_DAY_5']) ? $month_header_item['L_DAY_5'] : ''; ?></td>
				<td width="25" nowrap="nowrap" class="head_tiny"><?php echo isset($month_header_item['L_DAY_6']) ? $month_header_item['L_DAY_6'] : ''; ?></td>
				<td width="25" nowrap="nowrap" class="head_tiny"><?php echo isset($month_header_item['L_DAY_7']) ? $month_header_item['L_DAY_7'] : ''; ?></td>
			</tr>
<?php

} // END month_header

if(isset($month_header_item)) { unset($month_header_item); } 

?>
<?php

$week_count = ( isset($month_item['week.']) ) ? sizeof($month_item['week.']) : 0;
for ($week_i = 0; $week_i < $week_count; $week_i++)
{
 $week_item = &$month_item['week.'][$week_i];
 $week_item['S_ROW_COUNT'] = $week_i;
 $week_item['S_NUM_ROWS'] = $week_count;

?>
			<tr>
				<td class="rowpic"><a href="<?php echo isset($week_item['U_WEEK']) ? $week_item['U_WEEK'] : ''; ?>" class="gensmall"><strong>W</strong></a></td>
<?php

$empty_start_count = ( isset($week_item['empty_start.']) ) ? sizeof($week_item['empty_start.']) : 0;
for ($empty_start_i = 0; $empty_start_i < $empty_start_count; $empty_start_i++)
{
 $empty_start_item = &$week_item['empty_start.'][$empty_start_i];
 $empty_start_item['S_ROW_COUNT'] = $empty_start_i;
 $empty_start_item['S_NUM_ROWS'] = $empty_start_count;

?>
				<td class="day" colspan="<?php echo isset($empty_start_item['SPAN']) ? $empty_start_item['SPAN'] : ''; ?>">&nbsp;</td>
<?php

} // END empty_start

if(isset($empty_start_item)) { unset($empty_start_item); } 

?>
<?php

$day_count = ( isset($week_item['day.']) ) ? sizeof($week_item['day.']) : 0;
for ($day_i = 0; $day_i < $day_count; $day_i++)
{
 $day_item = &$week_item['day.'][$day_i];
 $day_item['S_ROW_COUNT'] = $day_i;
 $day_item['S_NUM_ROWS'] = $day_count;

?>
				<td class="<?php echo isset($day_item['C_DAY']) ? $day_item['C_DAY'] : ''; ?>"><?php echo isset($day_item['N_DAY']) ? $day_item['N_DAY'] : ''; ?></td>
<?php

} // END day

if(isset($day_item)) { unset($day_item); } 

?>
<?php

$empty_end_count = ( isset($week_item['empty_end.']) ) ? sizeof($week_item['empty_end.']) : 0;
for ($empty_end_i = 0; $empty_end_i < $empty_end_count; $empty_end_i++)
{
 $empty_end_item = &$week_item['empty_end.'][$empty_end_i];
 $empty_end_item['S_ROW_COUNT'] = $empty_end_i;
 $empty_end_item['S_NUM_ROWS'] = $empty_end_count;

?>
				<td class="day" colspan="<?php echo isset($empty_end_item['SPAN']) ? $empty_end_item['SPAN'] : ''; ?>">&nbsp;</td>
<?php

} // END empty_end

if(isset($empty_end_item)) { unset($empty_end_item); } 

?>
			</tr>
<?php

} // END week

if(isset($week_item)) { unset($week_item); } 

?>
		</table>
		</td>
<?php

} // END month

if(isset($month_item)) { unset($month_item); } 

?>
	</tr>
<?php

} // END quarter

if(isset($quarter_item)) { unset($quarter_item); } 

?>
</table>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
	<form action="<?php echo isset($this->vars['S_POST_ACTION']) ? $this->vars['S_POST_ACTION'] : $this->lang('S_POST_ACTION'); ?>" method="post" name="post">
	<td width=50% align='left'><span class=gensmall><?php echo isset($this->vars['L_YEAR_START']) ? $this->vars['L_YEAR_START'] : $this->lang('L_YEAR_START'); ?></span><br>
	<!-- <SELECT name='month' onChange="MM_jumpMenu('parent',this,1,'month')"> -->
	<!-- <SELECT name='year' onChange="MM_jumpMenu('parent',this,1,'year')"> -->
	<!-- You can use the code above to create instant jumpboxes if you prefer -->
	<SELECT name='month'>
	<?php echo isset($this->vars['S_MONTH']) ? $this->vars['S_MONTH'] : $this->lang('S_MONTH'); ?>
 	</SELECT><SELECT name='year'> -->
	<?php echo isset($this->vars['S_YEAR']) ? $this->vars['S_YEAR'] : $this->lang('S_YEAR'); ?>
 	</SELECT><input type="submit" class="liteoption" value="<?php echo isset($this->vars['L_GO']) ? $this->vars['L_GO'] : $this->lang('L_GO'); ?>" name="submit2"></td></form>
	<?php echo isset($this->vars['BUTTON_ADD']) ? $this->vars['BUTTON_ADD'] : $this->lang('BUTTON_ADD'); ?><?php echo isset($this->vars['BUTTON_VALIDATE']) ? $this->vars['BUTTON_VALIDATE'] : $this->lang('BUTTON_VALIDATE'); ?>
<?php

$no_categories_count = ( isset($this->_tpldata['no_categories.']) ) ?  sizeof($this->_tpldata['no_categories.']) : 0;
for ($no_categories_i = 0; $no_categories_i < $no_categories_count; $no_categories_i++)
{
 $no_categories_item = &$this->_tpldata['no_categories.'][$no_categories_i];
 $no_categories_item['S_ROW_COUNT'] = $no_categories_i;
 $no_categories_item['S_NUM_ROWS'] = $no_categories_count;

?>
	<td width=50% align='right'>&nbsp;</td>
<?php

} // END no_categories

if(isset($no_categories_item)) { unset($no_categories_item); } 

?>
<?php

$category_select_count = ( isset($this->_tpldata['category_select.']) ) ?  sizeof($this->_tpldata['category_select.']) : 0;
for ($category_select_i = 0; $category_select_i < $category_select_count; $category_select_i++)
{
 $category_select_item = &$this->_tpldata['category_select.'][$category_select_i];
 $category_select_item['S_ROW_COUNT'] = $category_select_i;
 $category_select_item['S_NUM_ROWS'] = $category_select_count;

?>
	<form action="<?php echo isset($category_select_item['S_POST_ACTION']) ? $category_select_item['S_POST_ACTION'] : ''; ?>" method="post" name="post">
	<td width=50% align='right'><span class=gensmall><?php echo isset($category_select_item['L_FILTER_CATS']) ? $category_select_item['L_FILTER_CATS'] : ''; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
	<SELECT name='category' onChange="MM_jumpMenu('parent',this,1,'category')">
	<?php echo isset($category_select_item['S_CATEGORY']) ? $category_select_item['S_CATEGORY'] : ''; ?>
 	</SELECT><input type="submit" class="liteoption" value="<?php echo isset($this->vars['L_GO']) ? $this->vars['L_GO'] : $this->lang('L_GO'); ?>" name="submit2"></td></form>
<?php

} // END category_select

if(isset($category_select_item)) { unset($category_select_item); } 

?>
   </tr>
</table>
</center>