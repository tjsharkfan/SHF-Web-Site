<?php

// eXtreme Styles mod cache. Generated on Wed, 26 Oct 2005 16:00:15 -0700 (time=1130367615)

?><a class="maintitle" href="<?php echo isset($this->vars['U_VIEW_TOPIC']) ? $this->vars['U_VIEW_TOPIC'] : $this->lang('U_VIEW_TOPIC'); ?>"><font color=black><?php echo isset($this->vars['TOPIC_TITLE']) ? $this->vars['TOPIC_TITLE'] : $this->lang('TOPIC_TITLE'); ?></font></a>
&nbsp;&nbsp;&nbsp;
<a title="<?php echo isset($this->vars['L_PRINT_DESC']) ? $this->vars['L_PRINT_DESC'] : $this->lang('L_PRINT_DESC'); ?>" href="javascript:self.print()"><img alt="<?php echo isset($this->vars['L_PRINT_DESC']) ? $this->vars['L_PRINT_DESC'] : $this->lang('L_PRINT_DESC'); ?>" src="http://www.scuemba.com/phpBB_shadow/templates/SCU/images/icon_print.gif" border="0" /></a>
<br clear=all>

<table border=0 align=right>
	<tr>
		<td class="gen" nowrap>
			<form action="<?php echo isset($this->vars['U_VIEW_TOPIC']) ? $this->vars['U_VIEW_TOPIC'] : $this->lang('U_VIEW_TOPIC'); ?>" method="get">
			<?php echo isset($this->vars['L_SELECT_MESSAGES_FROM']) ? $this->vars['L_SELECT_MESSAGES_FROM'] : $this->lang('L_SELECT_MESSAGES_FROM'); ?>
		</td>
		<td class="gen">				
			#<input class="post" type="text" maxlength="5" size="5" name="start_rel" value="<?php echo isset($this->vars['START_REL']) ? $this->vars['START_REL'] : $this->lang('START_REL'); ?>">
		</td>
		<td class="gen">
			<?php echo isset($this->vars['L_SELECT_THROUGH']) ? $this->vars['L_SELECT_THROUGH'] : $this->lang('L_SELECT_THROUGH'); ?>
		</td> 
		<td class="gen" nowrap title="<?php echo isset($this->vars['L_BOX2_DESC']) ? $this->vars['L_BOX2_DESC'] : $this->lang('L_BOX2_DESC'); ?>">
			#<input class="post" type="text" maxlength="5" size="5" name="finish_rel" value="<?php echo isset($this->vars['FINISH_REL']) ? $this->vars['FINISH_REL'] : $this->lang('FINISH_REL'); ?>">
		</td>	
		<td class="gen">
			<input type="hidden" name="t" value="<?php echo isset($this->vars['TOPIC_ID']) ? $this->vars['TOPIC_ID'] : $this->lang('TOPIC_ID'); ?>">
			<input type="hidden" name="printertopic" value="1">
			<input type="submit" name="submit" value="<?php echo isset($this->vars['L_SHOW']) ? $this->vars['L_SHOW'] : $this->lang('L_SHOW'); ?>" class="mainoption">
		</td>	
		<td class="gen" >
			<a target=_blank title="see the faq section for more help" href="<?php echo isset($this->vars['U_FAQ']) ? $this->vars['U_FAQ'] : $this->lang('U_FAQ'); ?>"><?php echo isset($this->vars['L_FAQ']) ? $this->vars['L_FAQ'] : $this->lang('L_FAQ'); ?></a>
		</td>
	</tr>	
</table>

<span class="nav"><?php echo isset($this->vars['PAGINATION']) ? $this->vars['PAGINATION'] : $this->lang('PAGINATION'); ?></span><br />
<span class="nav"><font color=black><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><font color=black><?php echo isset($this->vars['SITENAME']) ? $this->vars['SITENAME'] : $this->lang('SITENAME'); ?></font></a>
	  -> <a href="<?php echo isset($this->vars['U_VIEW_FORUM']) ? $this->vars['U_VIEW_FORUM'] : $this->lang('U_VIEW_FORUM'); ?>" class="nav"><font color=black><?php echo isset($this->vars['FORUM_NAME']) ? $this->vars['FORUM_NAME'] : $this->lang('FORUM_NAME'); ?></font></a></font></span>


	<?php echo isset($this->vars['POLL_DISPLAY']) ? $this->vars['POLL_DISPLAY'] : $this->lang('POLL_DISPLAY'); ?> 

	<?php

$postrow_count = ( isset($this->_tpldata['postrow.']) ) ?  sizeof($this->_tpldata['postrow.']) : 0;
for ($postrow_i = 0; $postrow_i < $postrow_count; $postrow_i++)
{
 $postrow_item = &$this->_tpldata['postrow.'][$postrow_i];
 $postrow_item['S_ROW_COUNT'] = $postrow_i;
 $postrow_item['S_NUM_ROWS'] = $postrow_count;

?>
	<center><hr width=80%></center>
<span class="name"><a name="<?php echo isset($postrow_item['U_POST_ID']) ? $postrow_item['U_POST_ID'] : ''; ?>"></a></span><span class="postdetails">#<?php echo isset($postrow_item['POST_NUMBER']) ? $postrow_item['POST_NUMBER'] : ''; ?>:&nbsp;<font color=black><b><?php echo isset($postrow_item['POST_SUBJECT']) ? $postrow_item['POST_SUBJECT'] : ''; ?></b> <?php echo isset($this->vars['L_AUTHOR']) ? $this->vars['L_AUTHOR'] : $this->lang('L_AUTHOR'); ?>:&nbsp;<b><?php echo isset($postrow_item['POSTER_NAME']) ? $postrow_item['POSTER_NAME'] : ''; ?></b>,&nbsp;</font></span><span class="postdetails"><font color=black><?php echo isset($postrow_item['POSTER_FROM']) ? $postrow_item['POSTER_FROM'] : ''; ?></font></span>
<a href="<?php echo isset($postrow_item['U_MINI_POST']) ? $postrow_item['U_MINI_POST'] : ''; ?>"><img src="<?php echo isset($postrow_item['MINI_POST_IMG']) ? $postrow_item['MINI_POST_IMG'] : ''; ?>" width="12" height="9" alt="<?php echo isset($postrow_item['L_MINI_POST_ALT']) ? $postrow_item['L_MINI_POST_ALT'] : ''; ?>" title="<?php echo isset($postrow_item['L_MINI_POST_ALT']) ? $postrow_item['L_MINI_POST_ALT'] : ''; ?>" border="0" /></a><span class="postdetails"><font color=black><?php echo isset($this->vars['L_POSTED']) ? $this->vars['L_POSTED'] : $this->lang('L_POSTED'); ?>: <?php echo isset($postrow_item['POST_DATE']) ? $postrow_item['POST_DATE'] : ''; ?></font><span class="gen"><br>
	<span class="gensmall">&nbsp;&nbsp;&nbsp;&nbsp;&#151;</span><br>

<span class="postbody"><?php echo isset($postrow_item['MESSAGE']) ? $postrow_item['MESSAGE'] : ''; ?></span><span class="gensmall"><?php echo isset($postrow_item['EDITED_MESSAGE']) ? $postrow_item['EDITED_MESSAGE'] : ''; ?><?php echo isset($postrow_item['ATTACHMENTS']) ? $postrow_item['ATTACHMENTS'] : ''; ?></span></td>
	<?php

} // END postrow

if(isset($postrow_item)) { unset($postrow_item); } 

?>
	<span class="gensmall"><center><hr width=48%><hr width=16%><hr width=4%></center><span>
<span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><font color=black><?php echo isset($this->vars['SITENAME']) ? $this->vars['SITENAME'] : $this->lang('SITENAME'); ?></font></a> 
	  -> <a href="<?php echo isset($this->vars['U_VIEW_FORUM']) ? $this->vars['U_VIEW_FORUM'] : $this->lang('U_VIEW_FORUM'); ?>" class="nav"><font color=black><?php echo isset($this->vars['FORUM_NAME']) ? $this->vars['FORUM_NAME'] : $this->lang('FORUM_NAME'); ?></font></a></span>
<p align=right><br><span class="gensmall"><?php echo isset($this->vars['S_TIMEZONE']) ? $this->vars['S_TIMEZONE'] : $this->lang('S_TIMEZONE'); ?></span></p><span class="nav"><?php echo isset($this->vars['PAGINATION']) ? $this->vars['PAGINATION'] : $this->lang('PAGINATION'); ?></span>
<center><span class="nav"><?php echo isset($this->vars['PAGE_NUMBER']) ? $this->vars['PAGE_NUMBER'] : $this->lang('PAGE_NUMBER'); ?></span></center>
</form>