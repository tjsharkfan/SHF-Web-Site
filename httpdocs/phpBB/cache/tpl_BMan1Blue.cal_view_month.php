<?php

// eXtreme Styles mod cache. Generated on Tue,  9 Aug 2005 21:32:32 -0700 (time=1123648352)

?><?php echo isset($this->vars['CATEGORY_CSS']) ? $this->vars['CATEGORY_CSS'] : $this->lang('CATEGORY_CSS'); ?>

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


var cssTextHover=new Array();

function swc(id, fOn) {
	if (document.all) {
		es=document.all[id];
		for(ies=0, esl=es.length; ies<esl; ies++){
			e=es[ies];
			e.runtimeStyle.cssText=(fOn?cssTextHover[e.className]:"");
		}
	}
}

function setup() {
	if (document.all) {
		ss=document.styleSheets;
		for(iss=0, ssl=ss.length; iss<ssl; iss++) {
			rs=ss[iss].rules;
			for(irs=0, rsl=rs.length; irs<rsl; irs++){
				r=rs[irs];
				s=r.selectorText;
				if (s.match(/a.(cal_\d+):hover/i)) {
					cssTextHover[RegExp.$1]=r.style.cssText;
				}
			}
		}
	}
}

setup();
//-->
</script>
 	    	 	 			    	 

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><?php echo isset($this->vars['PHPBBHEADER']) ? $this->vars['PHPBBHEADER'] : $this->lang('PHPBBHEADER'); ?><span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a> -&gt;
		<a href="<?php echo isset($this->vars['U_CAL_HOME']) ? $this->vars['U_CAL_HOME'] : $this->lang('U_CAL_HOME'); ?>" class="nav"><?php echo isset($this->vars['CALENDAR']) ? $this->vars['CALENDAR'] : $this->lang('CALENDAR'); ?></a></span></td>
		<td align=right class=genmed valign=bottom><span class="nav"><a href="<?php echo isset($this->vars['U_PRINT']) ? $this->vars['U_PRINT'] : $this->lang('U_PRINT'); ?>"><img src="<?php echo isset($this->vars['PRINT_IMG']) ? $this->vars['PRINT_IMG'] : $this->lang('PRINT_IMG'); ?>" border="0" alt="<?php echo isset($this->vars['L_PRINT']) ? $this->vars['L_PRINT'] : $this->lang('L_PRINT'); ?>" /></a> </span></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
       <tr>
		<th height="25" class="thLeft" width="95%">
			<?php echo isset($this->vars['CAL_MONTH']) ? $this->vars['CAL_MONTH'] : $this->lang('CAL_MONTH'); ?> <?php echo isset($this->vars['CAL_YEAR']) ? $this->vars['CAL_YEAR'] : $this->lang('CAL_YEAR'); ?>
		</th>
		<th height="25" class="thRight" width="5%" NOWRAP>
				<a href="<?php echo isset($this->vars['U_YEAR']) ? $this->vars['U_YEAR'] : $this->lang('U_YEAR'); ?>"><img src="<?php echo isset($this->vars['IMG_YEAR']) ? $this->vars['IMG_YEAR'] : $this->lang('IMG_YEAR'); ?>" alt="<?php echo isset($this->vars['L_YEAR_LINK']) ? $this->vars['L_YEAR_LINK'] : $this->lang('L_YEAR_LINK'); ?>" border="0"></a>
		</th>

	</tr>
	<tr>
		<td colspan="2" height="10">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
<?php echo isset($this->vars['BUTTON_PREV']) ? $this->vars['BUTTON_PREV'] : $this->lang('BUTTON_PREV'); ?>
			<td class=gensmall align="center" width="100%">&nbsp;<i><?php echo isset($this->vars['FILTER']) ? $this->vars['FILTER'] : $this->lang('FILTER'); ?></i>&nbsp;</td>
<?php echo isset($this->vars['BUTTON_NEXT']) ? $this->vars['BUTTON_NEXT'] : $this->lang('BUTTON_NEXT'); ?>
			</table>
		</td>
	</tr>
	<tr>
	<td colspan="2">
	<table width=100% cellpadding=1 cellspacing=1 border=0 style="border-collapse: expand; border-color=black;">
	<tr>
	  <td class=cat width=2%><span class=genmed>&nbsp;</span>
          <td class=cat width=14% align=center><b><span class=genmed><?php echo isset($this->vars['DAY_HEAD_1']) ? $this->vars['DAY_HEAD_1'] : $this->lang('DAY_HEAD_1'); ?></span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed><?php echo isset($this->vars['DAY_HEAD_2']) ? $this->vars['DAY_HEAD_2'] : $this->lang('DAY_HEAD_2'); ?></span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed><?php echo isset($this->vars['DAY_HEAD_3']) ? $this->vars['DAY_HEAD_3'] : $this->lang('DAY_HEAD_3'); ?></span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed><?php echo isset($this->vars['DAY_HEAD_4']) ? $this->vars['DAY_HEAD_4'] : $this->lang('DAY_HEAD_4'); ?></span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed><?php echo isset($this->vars['DAY_HEAD_5']) ? $this->vars['DAY_HEAD_5'] : $this->lang('DAY_HEAD_5'); ?></span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed><?php echo isset($this->vars['DAY_HEAD_6']) ? $this->vars['DAY_HEAD_6'] : $this->lang('DAY_HEAD_6'); ?></span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed><?php echo isset($this->vars['DAY_HEAD_7']) ? $this->vars['DAY_HEAD_7'] : $this->lang('DAY_HEAD_7'); ?></span></b></td>
        </tr>
<?php

$week_row_count = ( isset($this->_tpldata['week_row.']) ) ?  sizeof($this->_tpldata['week_row.']) : 0;
for ($week_row_i = 0; $week_row_i < $week_row_count; $week_row_i++)
{
 $week_row_item = &$this->_tpldata['week_row.'][$week_row_i];
 $week_row_item['S_ROW_COUNT'] = $week_row_i;
 $week_row_item['S_NUM_ROWS'] = $week_row_count;

?>
        <tr>
	  <td align="center" class="row3"><a href="<?php echo isset($week_row_item['U_WEEK']) ? $week_row_item['U_WEEK'] : ''; ?>" class="genmed"><i><img src="<?php echo isset($this->vars['IMG_WEEK']) ? $this->vars['IMG_WEEK'] : $this->lang('IMG_WEEK'); ?>" alt="<?php echo isset($this->vars['L_WEEK_LINK']) ? $this->vars['L_WEEK_LINK'] : $this->lang('L_WEEK_LINK'); ?>" border="0"></i></a></td>	
<?php

$last_mon_count = ( isset($week_row_item['last_mon.']) ) ? sizeof($week_row_item['last_mon.']) : 0;
for ($last_mon_i = 0; $last_mon_i < $last_mon_count; $last_mon_i++)
{
 $last_mon_item = &$week_row_item['last_mon.'][$last_mon_i];
 $last_mon_item['S_ROW_COUNT'] = $last_mon_i;
 $last_mon_item['S_NUM_ROWS'] = $last_mon_count;

?>
	  <td valign=top <?php echo isset($last_mon_item['S_CELL']) ? $last_mon_item['S_CELL'] : ''; ?>>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 <?php echo isset($last_mon_item['S_HEAD']) ? $last_mon_item['S_HEAD'] : ''; ?>><a href='<?php echo isset($last_mon_item['U_DAY']) ? $last_mon_item['U_DAY'] : ''; ?>' class=topictitle><?php echo isset($last_mon_item['NUM_DAY']) ? $last_mon_item['NUM_DAY'] : ''; ?></a></td></tr>
	    <tr><td NOWRAP valign=top <?php echo isset($last_mon_item['S_DETAILS']) ? $last_mon_item['S_DETAILS'] : ''; ?>><?php echo isset($last_mon_item['DAY_EVENT_LIST']) ? $last_mon_item['DAY_EVENT_LIST'] : ''; ?></td></tr>
 	    </table>
	  </td>
<?php

} // END last_mon

if(isset($last_mon_item)) { unset($last_mon_item); } 

?>
<?php

$this_mon_count = ( isset($week_row_item['this_mon.']) ) ? sizeof($week_row_item['this_mon.']) : 0;
for ($this_mon_i = 0; $this_mon_i < $this_mon_count; $this_mon_i++)
{
 $this_mon_item = &$week_row_item['this_mon.'][$this_mon_i];
 $this_mon_item['S_ROW_COUNT'] = $this_mon_i;
 $this_mon_item['S_NUM_ROWS'] = $this_mon_count;

?>
	  <td valign=top <?php echo isset($this_mon_item['S_CELL']) ? $this_mon_item['S_CELL'] : ''; ?>>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 <?php echo isset($this_mon_item['S_HEAD']) ? $this_mon_item['S_HEAD'] : ''; ?>><a href='<?php echo isset($this_mon_item['U_DAY']) ? $this_mon_item['U_DAY'] : ''; ?>' class=topictitle><?php echo isset($this_mon_item['NUM_DAY']) ? $this_mon_item['NUM_DAY'] : ''; ?></a></td></tr>
	    <tr><td NOWRAP valign=top <?php echo isset($this_mon_item['S_DETAILS']) ? $this_mon_item['S_DETAILS'] : ''; ?>><?php echo isset($this_mon_item['DAY_EVENT_LIST']) ? $this_mon_item['DAY_EVENT_LIST'] : ''; ?></td></tr>
 	    </table>
	  </td>
<?php

} // END this_mon

if(isset($this_mon_item)) { unset($this_mon_item); } 

?>
<?php

$next_mon_count = ( isset($week_row_item['next_mon.']) ) ? sizeof($week_row_item['next_mon.']) : 0;
for ($next_mon_i = 0; $next_mon_i < $next_mon_count; $next_mon_i++)
{
 $next_mon_item = &$week_row_item['next_mon.'][$next_mon_i];
 $next_mon_item['S_ROW_COUNT'] = $next_mon_i;
 $next_mon_item['S_NUM_ROWS'] = $next_mon_count;

?>
	  <td valign=top <?php echo isset($next_mon_item['S_CELL']) ? $next_mon_item['S_CELL'] : ''; ?>>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 <?php echo isset($next_mon_item['S_HEAD']) ? $next_mon_item['S_HEAD'] : ''; ?>><a href='<?php echo isset($next_mon_item['U_DAY']) ? $next_mon_item['U_DAY'] : ''; ?>' class=topictitle><?php echo isset($next_mon_item['NUM_DAY']) ? $next_mon_item['NUM_DAY'] : ''; ?></a></td></tr>
	    <tr><td NOWRAP valign=top <?php echo isset($next_mon_item['S_DETAILS']) ? $next_mon_item['S_DETAILS'] : ''; ?>><?php echo isset($next_mon_item['DAY_EVENT_LIST']) ? $next_mon_item['DAY_EVENT_LIST'] : ''; ?></td></tr>
 	    </table>
	  </td>
<?php

} // END next_mon

if(isset($next_mon_item)) { unset($next_mon_item); } 

?>
	</tr>
<?php

} // END week_row

if(isset($week_row_item)) { unset($week_row_item); } 

?>
        </table>
        </td>
     </tr>
</table>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
	<form action="<?php echo isset($category_select_item['S_POST_ACTION']) ? $category_select_item['S_POST_ACTION'] : ''; ?>" method="post" name="post">
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
