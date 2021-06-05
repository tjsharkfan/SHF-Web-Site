<?php

// eXtreme Styles mod cache. Generated on Fri, 30 Oct 2015 12:45:43 -0400 (time=1446223543)

?><table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><?php echo isset($this->vars['PHPBBHEADER']) ? $this->vars['PHPBBHEADER'] : $this->lang('PHPBBHEADER'); ?><span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a> -&gt;
		<a href="<?php echo isset($this->vars['U_CAL_HOME']) ? $this->vars['U_CAL_HOME'] : $this->lang('U_CAL_HOME'); ?>" class="nav"><?php echo isset($this->vars['CALENDAR']) ? $this->vars['CALENDAR'] : $this->lang('CALENDAR'); ?></a></span></td>
		<td align=right class=genmed valign=bottom></td>
	</tr>
</table>
 	    	 	 			    	 
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
        <tr> 
          <th height=25 class="thHead"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr><?php echo isset($this->vars['BUTTON_PREV']) ? $this->vars['BUTTON_PREV'] : $this->lang('BUTTON_PREV'); ?>
                <td nowrap>
		 <center>
		   <table cellpadding=0 border=0 cellspacing=0>
			<tr>
			<td><span class=gen><b><font color=#FFA34F><?php echo isset($this->vars['CAL_DAY']) ? $this->vars['CAL_DAY'] : $this->lang('CAL_DAY'); ?></font></b>&nbsp;</span></td>
			<td class=row1 align=center><span class=gen><?php echo isset($this->vars['CAL_MONTH']) ? $this->vars['CAL_MONTH'] : $this->lang('CAL_MONTH'); ?></span></td>
			<td><span class=gen>&nbsp;<b><font color=#FFA34F><?php echo isset($this->vars['CAL_YEAR']) ? $this->vars['CAL_YEAR'] : $this->lang('CAL_YEAR'); ?></font></b></span></td>
			</tr>
		   </table>
		   </center> 
		</td>
<?php echo isset($this->vars['BUTTON_NEXT']) ? $this->vars['BUTTON_NEXT'] : $this->lang('BUTTON_NEXT'); ?>
	      </tr>
            </table></th>
        </tr>
        <tr> 
          <td class=row2>
	     <table cellpadding=2 cellspacing=0 border=0 width=100% >
              <tr> 
                <td width=55% class=catHead NOWRAP><span class=genmed><b><?php echo isset($this->vars['SUBJECT']) ? $this->vars['SUBJECT'] : $this->lang('SUBJECT'); ?></b></span><span class=gensmall><?php echo isset($this->vars['CATEGORY']) ? $this->vars['CATEGORY'] : $this->lang('CATEGORY'); ?></span></td>
                <td width=15% class=catHead NOWRAP align="center"><span class=genmed><b><?php echo isset($this->vars['DATE']) ? $this->vars['DATE'] : $this->lang('DATE'); ?></b></span> <span class=gensmall>(<?php echo isset($this->vars['TIME']) ? $this->vars['TIME'] : $this->lang('TIME'); ?>)</span></td>
                <td width=15% class=catHead NOWRAP align="center"><span class=genmed><b><?php echo isset($this->vars['END_DATE']) ? $this->vars['END_DATE'] : $this->lang('END_DATE'); ?></b> <span class=gensmall>(<?php echo isset($this->vars['TIME']) ? $this->vars['TIME'] : $this->lang('TIME'); ?>)</span></td>
                <td width=15% class=catHead NOWRAP colspan="2" align="center"><span class=genmed><b><?php echo isset($this->vars['AUTHOR']) ? $this->vars['AUTHOR'] : $this->lang('AUTHOR'); ?></b></span></td>
              </tr>
	<?php

$no_events_count = ( isset($this->_tpldata['no_events.']) ) ?  sizeof($this->_tpldata['no_events.']) : 0;
for ($no_events_i = 0; $no_events_i < $no_events_count; $no_events_i++)
{
 $no_events_item = &$this->_tpldata['no_events.'][$no_events_i];
 $no_events_item['S_ROW_COUNT'] = $no_events_i;
 $no_events_item['S_NUM_ROWS'] = $no_events_count;

?>
	      <tr>
		<td colspan='4'><span class=gen><BR><?php echo isset($no_events_item['NO_EVENTS']) ? $no_events_item['NO_EVENTS'] : ''; ?></span></td>
	      </tr>
	<?php

} // END no_events

if(isset($no_events_item)) { unset($no_events_item); } 

?>
	<?php

$event_row_count = ( isset($this->_tpldata['event_row.']) ) ?  sizeof($this->_tpldata['event_row.']) : 0;
for ($event_row_i = 0; $event_row_i < $event_row_count; $event_row_i++)
{
 $event_row_item = &$this->_tpldata['event_row.'][$event_row_i];
 $event_row_item['S_ROW_COUNT'] = $event_row_i;
 $event_row_item['S_NUM_ROWS'] = $event_row_count;

?>
              <tr> 
                <td class=row2 height=25><span class=genmed><B><?php echo isset($event_row_item['SUBJECT']) ? $event_row_item['SUBJECT'] : ''; ?></B></span><span class=gensmall><?php echo isset($event_row_item['CATEGORY']) ? $event_row_item['CATEGORY'] : ''; ?></span></td>
                <td class=row2 NOWRAP align="center"><span class=genmed><strong>&nbsp;<?php echo isset($event_row_item['DATE']) ? $event_row_item['DATE'] : ''; ?>&nbsp;</strong></span> <span class=gensmall><?php echo isset($event_row_item['TIME']) ? $event_row_item['TIME'] : ''; ?></span></td>
                <td class=row2 NOWRAP align="center"><span class=genmed><strong>&nbsp;<?php echo isset($event_row_item['END_DATE']) ? $event_row_item['END_DATE'] : ''; ?>&nbsp;</strong></span> <span class=gensmall><?php echo isset($event_row_item['END_TIME']) ? $event_row_item['END_TIME'] : ''; ?></span></td>
                <td class=row2 NOWRAP rowspan="2" width="140" valign="top" align="center"><span class=genmed><br /><strong><?php echo isset($event_row_item['AUTHOR']) ? $event_row_item['AUTHOR'] : ''; ?></strong><br /><?php echo isset($event_row_item['POSTER_ONLINE']) ? $event_row_item['POSTER_ONLINE'] : ''; ?></span></td>
                <td class=row2 NOWRAP rowspan="2" width="60" valign="top"><?php echo isset($event_row_item['PROFILE_IMG']) ? $event_row_item['PROFILE_IMG'] : ''; ?><br /><?php echo isset($event_row_item['PM_IMG']) ? $event_row_item['PM_IMG'] : ''; ?><br /><?php echo isset($event_row_item['EMAIL_IMG']) ? $event_row_item['EMAIL_IMG'] : ''; ?><br /><?php echo isset($event_row_item['WWW_IMG']) ? $event_row_item['WWW_IMG'] : ''; ?></td>
              </tr>
              <tr> 
                <td class=row1 colspan=3><span class=genmed><?php echo isset($event_row_item['DESC']) ? $event_row_item['DESC'] : ''; ?><br />&nbsp;</td>
              </tr>
              <tr>
 		<td class=row2 align=left><?php echo isset($event_row_item['BUTTON_MOD']) ? $event_row_item['BUTTON_MOD'] : ''; ?> <?php echo isset($event_row_item['BUTTON_DEL']) ? $event_row_item['BUTTON_DEL'] : ''; ?></td>
 		<td class=row2 colspan=4 align=right><?php echo isset($event_row_item['AIM_IMG']) ? $event_row_item['AIM_IMG'] : ''; ?> <?php echo isset($event_row_item['YIM_IMG']) ? $event_row_item['YIM_IMG'] : ''; ?> <?php echo isset($event_row_item['MSN_IMG']) ? $event_row_item['MSN_IMG'] : ''; ?> <?php echo isset($event_row_item['ICQ_IMG']) ? $event_row_item['ICQ_IMG'] : ''; ?></td>
              </tr>
              <tr> 
                <td colspan=5 class="spaceRow" colspan="2" height="1"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
              </tr>
	<?php

} // END event_row

if(isset($event_row_item)) { unset($event_row_item); } 

?>
            </table>
	   </td>
	</tr>
</table>
<center>
<BR>&nbsp;
<BR> 	    	 	 			    	 
<table border="0" cellspacing="0" cellpadding="0">
   <tr>
<?php echo isset($this->vars['BUTTON_HOME']) ? $this->vars['BUTTON_HOME'] : $this->lang('BUTTON_HOME'); ?>
   </tr>
   <tr>
	<td>
	<table>
	   <tr> 
<?php echo isset($this->vars['BUTTON_ADD']) ? $this->vars['BUTTON_ADD'] : $this->lang('BUTTON_ADD'); ?>
<?php echo isset($this->vars['BUTTON_VAL']) ? $this->vars['BUTTON_VAL'] : $this->lang('BUTTON_VAL'); ?>
	   </tr>
	</table>
	</td>
    </tr>
</table>
</center> 