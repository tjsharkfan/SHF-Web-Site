<?php

// eXtreme Styles mod cache. Generated on Mon, 28 Aug 2006 18:28:58 -0700 (time=1156814938)

?> 
<table class="forumline" width="100%" cellspacing="1" cellpadding="4" border="0">
	<tr> 
		<th height="25" class="thHead"><?php echo isset($this->vars['L_PREVIEW']) ? $this->vars['L_PREVIEW'] : $this->lang('L_PREVIEW'); ?></th>
	</tr>
	<tr> 
		<td class="row1"><img src="templates/subSilver/images/icon_minipost.gif" alt="<?php echo isset($this->vars['L_POST']) ? $this->vars['L_POST'] : $this->lang('L_POST'); ?>" /><span class="postdetails"><?php echo isset($this->vars['L_POSTED']) ? $this->vars['L_POSTED'] : $this->lang('L_POSTED'); ?>: <?php echo isset($this->vars['POST_DATE']) ? $this->vars['POST_DATE'] : $this->lang('POST_DATE'); ?> &nbsp;&nbsp;&nbsp; <?php echo isset($this->vars['L_POST_SUBJECT']) ? $this->vars['L_POST_SUBJECT'] : $this->lang('L_POST_SUBJECT'); ?>: <?php echo isset($this->vars['POST_SUBJECT']) ? $this->vars['POST_SUBJECT'] : $this->lang('POST_SUBJECT'); ?></span></td>
	</tr>
	<tr> 
		<td class="row1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<span class="postbody"><?php echo isset($this->vars['MESSAGE']) ? $this->vars['MESSAGE'] : $this->lang('MESSAGE'); ?></span>
					<?php

$postrow_count = ( isset($this->_tpldata['postrow.']) ) ?  sizeof($this->_tpldata['postrow.']) : 0;
for ($postrow_i = 0; $postrow_i < $postrow_count; $postrow_i++)
{
 $postrow_item = &$this->_tpldata['postrow.'][$postrow_i];
 $postrow_item['S_ROW_COUNT'] = $postrow_i;
 $postrow_item['S_NUM_ROWS'] = $postrow_count;

?>
					<?php echo isset($this->vars['ATTACHMENTS']) ? $this->vars['ATTACHMENTS'] : $this->lang('ATTACHMENTS'); ?>
					<?php

} // END postrow

if(isset($postrow_item)) { unset($postrow_item); } 

?>
				</td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="spaceRow" height="1"><img src="templates/subSilver/images/spacer.gif" width="1" height="1" /></td>
	</tr>
</table>

<br clear="all" />
