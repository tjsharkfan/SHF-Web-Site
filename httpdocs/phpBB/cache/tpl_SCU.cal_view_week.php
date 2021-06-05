<?php

// eXtreme Styles mod cache. Generated on Fri, 30 Oct 2015 12:46:20 -0400 (time=1446223580)

?><style type="text/css">
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

<?php echo isset($this->vars['CATEGORY_CSS']) ? $this->vars['CATEGORY_CSS'] : $this->lang('CATEGORY_CSS'); ?>

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
		<td align="left"><?php echo isset($this->vars['PHPBBHEADER']) ? $this->vars['PHPBBHEADER'] : $this->lang('PHPBBHEADER'); ?><span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a> -&gt;
		<a href="<?php echo isset($this->vars['U_CAL_HOME']) ? $this->vars['U_CAL_HOME'] : $this->lang('U_CAL_HOME'); ?>" class="nav"><?php echo isset($this->vars['CALENDAR']) ? $this->vars['CALENDAR'] : $this->lang('CALENDAR'); ?></a></span></td>
		<td align=right class=genmed valign=bottom><span class="nav"></a> </span></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th height="25" class="thLeft" width="95%">
			<?php echo isset($this->vars['L_WEEK_VIEW']) ? $this->vars['L_WEEK_VIEW'] : $this->lang('L_WEEK_VIEW'); ?> 
		</th>
		<th height="25" class="thRight" width="5%" NOWRAP>
				<a href="<?php echo isset($this->vars['U_MONTH']) ? $this->vars['U_MONTH'] : $this->lang('U_MONTH'); ?>"><img src="<?php echo isset($this->vars['IMG_MONTH']) ? $this->vars['IMG_MONTH'] : $this->lang('IMG_MONTH'); ?>" alt="<?php echo isset($this->vars['L_MONTH_LINK']) ? $this->vars['L_MONTH_LINK'] : $this->lang('L_MONTH_LINK'); ?>" border="0"></a>
				<a href="<?php echo isset($this->vars['U_YEAR']) ? $this->vars['U_YEAR'] : $this->lang('U_YEAR'); ?>"><img src="<?php echo isset($this->vars['IMG_YEAR']) ? $this->vars['IMG_YEAR'] : $this->lang('IMG_YEAR'); ?>" alt="<?php echo isset($this->vars['L_YEAR_LINK']) ? $this->vars['L_YEAR_LINK'] : $this->lang('L_YEAR_LINK'); ?>" border="0"></a>
		</th>
	</tr>
	<tr>
		<td height="10" class="thHead" colspan="2" width="100%">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<?php echo isset($this->vars['BUTTON_PREV']) ? $this->vars['BUTTON_PREV'] : $this->lang('BUTTON_PREV'); ?>
			<td class=gensmall align="center" width="100%">&nbsp;<i><?php echo isset($this->vars['FILTER']) ? $this->vars['FILTER'] : $this->lang('FILTER'); ?></i>&nbsp;</td>
			<?php echo isset($this->vars['BUTTON_NEXT']) ? $this->vars['BUTTON_NEXT'] : $this->lang('BUTTON_NEXT'); ?>
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
<?php

$new_row_count = ( isset($this->_tpldata['new_row.']) ) ?  sizeof($this->_tpldata['new_row.']) : 0;
for ($new_row_i = 0; $new_row_i < $new_row_count; $new_row_i++)
{
 $new_row_item = &$this->_tpldata['new_row.'][$new_row_i];
 $new_row_item['S_ROW_COUNT'] = $new_row_i;
 $new_row_item['S_NUM_ROWS'] = $new_row_count;

?>
<?php

$header_row_count = ( isset($new_row_item['header_row.']) ) ? sizeof($new_row_item['header_row.']) : 0;
for ($header_row_i = 0; $header_row_i < $header_row_count; $header_row_i++)
{
 $header_row_item = &$new_row_item['header_row.'][$header_row_i];
 $header_row_item['S_ROW_COUNT'] = $header_row_i;
 $header_row_item['S_NUM_ROWS'] = $header_row_count;

?>
	  <tr>
		<td class="rowpic" colspan="2"><span class="genmed"><b><?php echo isset($header_row_item['DAY']) ? $header_row_item['DAY'] : ''; ?></b></span> <span class="gensmall">[<?php echo isset($new_row_item['DATE']) ? $new_row_item['DATE'] : ''; ?>]</span></td>
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
<?php

} // END header_row

if(isset($header_row_item)) { unset($header_row_item); } 

?>
<?php

$event_row_count = ( isset($new_row_item['event_row.']) ) ? sizeof($new_row_item['event_row.']) : 0;
for ($event_row_i = 0; $event_row_i < $event_row_count; $event_row_i++)
{
 $event_row_item = &$new_row_item['event_row.'][$event_row_i];
 $event_row_item['S_ROW_COUNT'] = $event_row_i;
 $event_row_item['S_NUM_ROWS'] = $event_row_count;

?>
	  <tr>
		<td class="subject" colspan="2"><?php echo isset($event_row_item['BULLET']) ? $event_row_item['BULLET'] : ''; ?><a href='<?php echo isset($event_row_item['U_EVENT']) ? $event_row_item['U_EVENT'] : ''; ?>' title="<?php echo isset($event_row_item['FULL_SUBJECT']) ? $event_row_item['FULL_SUBJECT'] : ''; ?>" <?php echo isset($event_row_item['COL_CAT']) ? $event_row_item['COL_CAT'] : ''; ?>><?php echo isset($event_row_item['SUBJECT']) ? $event_row_item['SUBJECT'] : ''; ?></a></td>
<!--		<td class="gensmall" NOWRAP align="right"><i><?php echo isset($event_row_item['TIMES']) ? $event_row_item['TIMES'] : ''; ?></i></td>	-->	
<?php

$start_blank_count = ( isset($event_row_item['start_blank.']) ) ? sizeof($event_row_item['start_blank.']) : 0;
for ($start_blank_i = 0; $start_blank_i < $start_blank_count; $start_blank_i++)
{
 $start_blank_item = &$event_row_item['start_blank.'][$start_blank_i];
 $start_blank_item['S_ROW_COUNT'] = $start_blank_i;
 $start_blank_item['S_NUM_ROWS'] = $start_blank_count;

?>
		<td colspan="<?php echo isset($start_blank_item['COLSPAN']) ? $start_blank_item['COLSPAN'] : ''; ?>" class="gensmall" align="right"><i><?php echo isset($start_blank_item['DATE']) ? $start_blank_item['DATE'] : ''; ?></i>&nbsp;</td>
<?php

} // END start_blank

if(isset($start_blank_item)) { unset($start_blank_item); } 

?>
<?php

$event_record_count = ( isset($event_row_item['event_record.']) ) ? sizeof($event_row_item['event_record.']) : 0;
for ($event_record_i = 0; $event_record_i < $event_record_count; $event_record_i++)
{
 $event_record_item = &$event_row_item['event_record.'][$event_record_i];
 $event_record_item['S_ROW_COUNT'] = $event_record_i;
 $event_record_item['S_NUM_ROWS'] = $event_record_count;

?>
		<td colspan="<?php echo isset($event_record_item['COLSPAN']) ? $event_record_item['COLSPAN'] : ''; ?>" class="<?php echo isset($event_record_item['SPAN_CLASS']) ? $event_record_item['SPAN_CLASS'] : ''; ?>" align="center">&nbsp;<i><?php echo isset($event_record_item['DATE']) ? $event_record_item['DATE'] : ''; ?></i></td>
<?php

} // END event_record

if(isset($event_record_item)) { unset($event_record_item); } 

?>
<?php

$end_blank_count = ( isset($event_row_item['end_blank.']) ) ? sizeof($event_row_item['end_blank.']) : 0;
for ($end_blank_i = 0; $end_blank_i < $end_blank_count; $end_blank_i++)
{
 $end_blank_item = &$event_row_item['end_blank.'][$end_blank_i];
 $end_blank_item['S_ROW_COUNT'] = $end_blank_i;
 $end_blank_item['S_NUM_ROWS'] = $end_blank_count;

?>
		<td colspan="<?php echo isset($end_blank_item['COLSPAN']) ? $end_blank_item['COLSPAN'] : ''; ?>" class="gensmall" align="left">&nbsp;<i><?php echo isset($end_blank_item['DATE']) ? $end_blank_item['DATE'] : ''; ?></i></td>
<?php

} // END end_blank

if(isset($end_blank_item)) { unset($end_blank_item); } 

?>
	  </tr>
<?php

} // END event_row

if(isset($event_row_item)) { unset($event_row_item); } 

?>
<?php

$empty_day_row_count = ( isset($new_row_item['empty_day_row.']) ) ? sizeof($new_row_item['empty_day_row.']) : 0;
for ($empty_day_row_i = 0; $empty_day_row_i < $empty_day_row_count; $empty_day_row_i++)
{
 $empty_day_row_item = &$new_row_item['empty_day_row.'][$empty_day_row_i];
 $empty_day_row_item['S_ROW_COUNT'] = $empty_day_row_i;
 $empty_day_row_item['S_NUM_ROWS'] = $empty_day_row_count;

?>
	  <tr>
		<td class="genmed" colspan="2">&nbsp;</td>
		<td colspan="48" class="genmed" align="center"><i><?php echo isset($this->vars['NO_EVENTS']) ? $this->vars['NO_EVENTS'] : $this->lang('NO_EVENTS'); ?></i></td>
	  </tr>
<?php

} // END empty_day_row

if(isset($empty_day_row_item)) { unset($empty_day_row_item); } 

?>
<?php

$day_spacer_count = ( isset($new_row_item['day_spacer.']) ) ? sizeof($new_row_item['day_spacer.']) : 0;
for ($day_spacer_i = 0; $day_spacer_i < $day_spacer_count; $day_spacer_i++)
{
 $day_spacer_item = &$new_row_item['day_spacer.'][$day_spacer_i];
 $day_spacer_item['S_ROW_COUNT'] = $day_spacer_i;
 $day_spacer_item['S_NUM_ROWS'] = $day_spacer_count;

?>
	  <tr>
		<td colspan="50" class="genmed" align="center"><hr width="100%" size="1"></td>
	  </tr>
<?php

} // END day_spacer

if(isset($day_spacer_item)) { unset($day_spacer_item); } 

?>
<?php

} // END new_row

if(isset($new_row_item)) { unset($new_row_item); } 

?>
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
	<form action="<?php echo isset($this->vars['S_POST_ACTION']) ? $this->vars['S_POST_ACTION'] : $this->lang('S_POST_ACTION'); ?>" method="post" name="post">
	<td width=50% align='left'><span class=gensmall><?php echo isset($this->vars['L_MONTH_JUMP']) ? $this->vars['L_MONTH_JUMP'] : $this->lang('L_MONTH_JUMP'); ?></span><br>
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

<?php

$cat_legend_count = ( isset($this->_tpldata['cat_legend.']) ) ?  sizeof($this->_tpldata['cat_legend.']) : 0;
for ($cat_legend_i = 0; $cat_legend_i < $cat_legend_count; $cat_legend_i++)
{
 $cat_legend_item = &$this->_tpldata['cat_legend.'][$cat_legend_i];
 $cat_legend_item['S_ROW_COUNT'] = $cat_legend_i;
 $cat_legend_item['S_NUM_ROWS'] = $cat_legend_count;

?> 
<table border="0" cellspacing="2" cellpadding="2" align="center" class="bodyline"> 
<tr align="left" valign="top"> 
	<td class="genmed" valign="middle"><b><?php echo isset($cat_legend_item['CAT_LEGEND']) ? $cat_legend_item['CAT_LEGEND'] : ''; ?></b></td> 
	<td class="gensmall" valign="middle">
<?php

$cat_colorcode_count = ( isset($cat_legend_item['cat_colorcode.']) ) ? sizeof($cat_legend_item['cat_colorcode.']) : 0;
for ($cat_colorcode_i = 0; $cat_colorcode_i < $cat_colorcode_count; $cat_colorcode_i++)
{
 $cat_colorcode_item = &$cat_legend_item['cat_colorcode.'][$cat_colorcode_i];
 $cat_colorcode_item['S_ROW_COUNT'] = $cat_colorcode_i;
 $cat_colorcode_item['S_NUM_ROWS'] = $cat_colorcode_count;

?> 
<span class="cal_<?php echo isset($cat_colorcode_item['ID']) ? $cat_colorcode_item['ID'] : ''; ?>"><?php echo isset($cat_colorcode_item['NAME']) ? $cat_colorcode_item['NAME'] : ''; ?></span><?php echo isset($cat_colorcode_item['DIVIDER']) ? $cat_colorcode_item['DIVIDER'] : ''; ?>
<?php

} // END cat_colorcode

if(isset($cat_colorcode_item)) { unset($cat_colorcode_item); } 

?> 
	</td> 
</tr>
</table> 
<?php

} // END cat_legend

if(isset($cat_legend_item)) { unset($cat_legend_item); } 

?> 
 
</center>
