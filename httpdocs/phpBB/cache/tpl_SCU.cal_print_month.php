<?php

// eXtreme Styles mod cache. Generated on Fri, 30 Oct 2015 12:50:59 -0400 (time=1446223859)

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" -->
<html dir="<?php echo isset($this->vars['S_CONTENT_DIRECTION']) ? $this->vars['S_CONTENT_DIRECTION'] : $this->lang('S_CONTENT_DIRECTION'); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo isset($this->vars['S_CONTENT_ENCODING']) ? $this->vars['S_CONTENT_ENCODING'] : $this->lang('S_CONTENT_ENCODING'); ?>">
<meta http-equiv="Content-Style-Type" content="text/css">
<title><?php echo isset($this->vars['SITENAME']) ? $this->vars['SITENAME'] : $this->lang('SITENAME'); ?> :: <?php echo isset($this->vars['PAGE_TITLE']) ? $this->vars['PAGE_TITLE'] : $this->lang('PAGE_TITLE'); ?></title>
<style type="text/css">
<!--
body {
    font-family: <?php echo isset($this->vars['T_FONTFACE1']) ? $this->vars['T_FONTFACE1'] : $this->lang('T_FONTFACE1'); ?>;
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

<?php echo isset($this->vars['CATEGORY_CSS']) ? $this->vars['CATEGORY_CSS'] : $this->lang('CATEGORY_CSS'); ?>

</head>
<body>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><span class="gen"><strong><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></strong> -&gt;
		<strong><?php echo isset($this->vars['CALENDAR']) ? $this->vars['CALENDAR'] : $this->lang('CALENDAR'); ?></strong></span></td>
		<td align="right"><span class="gensmall">(<?php echo isset($this->vars['PRINTER_VER']) ? $this->vars['PRINTER_VER'] : $this->lang('PRINTER_VER'); ?>)</span></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="white">
       <tr>
	<th height="25" class="thHead">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<td><center><span class=gen><b><?php echo isset($this->vars['CAL_MONTH']) ? $this->vars['CAL_MONTH'] : $this->lang('CAL_MONTH'); ?> <?php echo isset($this->vars['CAL_YEAR']) ? $this->vars['CAL_YEAR'] : $this->lang('CAL_YEAR'); ?> <span class=gensmall><?php echo isset($this->vars['FILTER']) ? $this->vars['FILTER'] : $this->lang('FILTER'); ?></span></b></span></center></td>
		</table>
	</th>
       </tr>
       <tr>
	<td>
	<table width=100% cellpadding=1 cellspacing=1 border=0 style="border-collapse: expand; border-color=black;">
	<tr>
          <td class="forumline" width="14%" align="center"><span class="gen"><strong><?php echo isset($this->vars['DAY_HEAD_1']) ? $this->vars['DAY_HEAD_1'] : $this->lang('DAY_HEAD_1'); ?></span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong><?php echo isset($this->vars['DAY_HEAD_2']) ? $this->vars['DAY_HEAD_2'] : $this->lang('DAY_HEAD_2'); ?></span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong><?php echo isset($this->vars['DAY_HEAD_3']) ? $this->vars['DAY_HEAD_3'] : $this->lang('DAY_HEAD_3'); ?></span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong><?php echo isset($this->vars['DAY_HEAD_4']) ? $this->vars['DAY_HEAD_4'] : $this->lang('DAY_HEAD_4'); ?></span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong><?php echo isset($this->vars['DAY_HEAD_5']) ? $this->vars['DAY_HEAD_5'] : $this->lang('DAY_HEAD_5'); ?></span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong><?php echo isset($this->vars['DAY_HEAD_6']) ? $this->vars['DAY_HEAD_6'] : $this->lang('DAY_HEAD_6'); ?></span></td>
	  <td class="forumline" width="14%" align="center"><span class="gen"><strong><?php echo isset($this->vars['DAY_HEAD_7']) ? $this->vars['DAY_HEAD_7'] : $this->lang('DAY_HEAD_7'); ?></span></td>
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
	    <tr><td height=15 <?php echo isset($this_mon_item['S_HEAD']) ? $this_mon_item['S_HEAD'] : ''; ?>><strong><?php echo isset($this_mon_item['NUM_DAY']) ? $this_mon_item['NUM_DAY'] : ''; ?></strong></td></tr>
	    <tr><td valign=top <?php echo isset($this_mon_item['S_DETAILS']) ? $this_mon_item['S_DETAILS'] : ''; ?>><?php echo isset($this_mon_item['DAY_EVENT_LIST']) ? $this_mon_item['DAY_EVENT_LIST'] : ''; ?></td></tr>
 	    </table>
	  </td>
<?php

} // END this_mon

if(isset($this_mon_item)) { unset($this_mon_item); } 

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
<center>
<a href="javascript:history.back()" class="genmed"><?php echo isset($this->vars['L_BAK2CAL']) ? $this->vars['L_BAK2CAL'] : $this->lang('L_BAK2CAL'); ?></a>
</center>
  <hr />
<div align="center"><?php echo isset($this->vars['S_TIMEZONE']) ? $this->vars['S_TIMEZONE'] : $this->lang('S_TIMEZONE'); ?><br />
 	    	 	 			    	 
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