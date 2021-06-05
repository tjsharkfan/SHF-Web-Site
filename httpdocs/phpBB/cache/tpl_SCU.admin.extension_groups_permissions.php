<?php

// eXtreme Styles mod cache. Generated on Mon,  3 Oct 2005 10:09:11 -0700 (time=1128359351)

?>
<h1><?php echo isset($this->vars['L_GROUP_PERMISSIONS_TITLE']) ? $this->vars['L_GROUP_PERMISSIONS_TITLE'] : $this->lang('L_GROUP_PERMISSIONS_TITLE'); ?></h1>

<p><?php echo isset($this->vars['L_GROUP_PERMISSIONS_EXPLAIN']) ? $this->vars['L_GROUP_PERMISSIONS_EXPLAIN'] : $this->lang('L_GROUP_PERMISSIONS_EXPLAIN'); ?></p>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center">
			<form method="post" action="<?php echo isset($this->vars['A_PERM_ACTION']) ? $this->vars['A_PERM_ACTION'] : $this->lang('A_PERM_ACTION'); ?>">
			<table width="90%" class="forumline" cellspacing="1" cellpadding="4" border="0" align="center">
				<tr>
					<th><?php echo isset($this->vars['L_ALLOWED_FORUMS']) ? $this->vars['L_ALLOWED_FORUMS'] : $this->lang('L_ALLOWED_FORUMS'); ?></th>
				</tr>
				<tr>
					<td class="row1" align="center">
						<select style="width:560px" name="entries[]" multiple="multiple" size="5">
						<?php

$allow_option_values_count = ( isset($this->_tpldata['allow_option_values.']) ) ?  sizeof($this->_tpldata['allow_option_values.']) : 0;
for ($allow_option_values_i = 0; $allow_option_values_i < $allow_option_values_count; $allow_option_values_i++)
{
 $allow_option_values_item = &$this->_tpldata['allow_option_values.'][$allow_option_values_i];
 $allow_option_values_item['S_ROW_COUNT'] = $allow_option_values_i;
 $allow_option_values_item['S_NUM_ROWS'] = $allow_option_values_count;

?>
						<option value="<?php echo isset($allow_option_values_item['VALUE']) ? $allow_option_values_item['VALUE'] : ''; ?>"><?php echo isset($allow_option_values_item['OPTION']) ? $allow_option_values_item['OPTION'] : ''; ?></option>
						<?php

} // END allow_option_values

if(isset($allow_option_values_item)) { unset($allow_option_values_item); } 

?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="cat" align="center"> <input class="liteoption" type="submit" name="del_forum" value="<?php echo isset($this->vars['L_REMOVE_SELECTED']) ? $this->vars['L_REMOVE_SELECTED'] : $this->lang('L_REMOVE_SELECTED'); ?>" /> &nbsp; <input class="liteoption" type="submit" name="close_perm" value="<?php echo isset($this->vars['L_CLOSE_WINDOW']) ? $this->vars['L_CLOSE_WINDOW'] : $this->lang('L_CLOSE_WINDOW'); ?>" /><input type="hidden" name="e_mode" value="perm" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<form method="post" action="<?php echo isset($this->vars['A_PERM_ACTION']) ? $this->vars['A_PERM_ACTION'] : $this->lang('A_PERM_ACTION'); ?>">
			<table width="90%" class="forumline" cellspacing="1" cellpadding="4" border="0" align="center">
				<tr>
					<th><?php echo isset($this->vars['L_ADD_FORUMS']) ? $this->vars['L_ADD_FORUMS'] : $this->lang('L_ADD_FORUMS'); ?></th>
				</tr>
				<tr>
					<td class="row1" align="center">
					<select style="width:560px" name="entries[]" multiple="multiple" size="5">
					<?php

$forum_option_values_count = ( isset($this->_tpldata['forum_option_values.']) ) ?  sizeof($this->_tpldata['forum_option_values.']) : 0;
for ($forum_option_values_i = 0; $forum_option_values_i < $forum_option_values_count; $forum_option_values_i++)
{
 $forum_option_values_item = &$this->_tpldata['forum_option_values.'][$forum_option_values_i];
 $forum_option_values_item['S_ROW_COUNT'] = $forum_option_values_i;
 $forum_option_values_item['S_NUM_ROWS'] = $forum_option_values_count;

?>
					<option value="<?php echo isset($forum_option_values_item['VALUE']) ? $forum_option_values_item['VALUE'] : ''; ?>"><?php echo isset($forum_option_values_item['OPTION']) ? $forum_option_values_item['OPTION'] : ''; ?></option>
					<?php

} // END forum_option_values

if(isset($forum_option_values_item)) { unset($forum_option_values_item); } 

?>
					</select>
					</td>
				</tr>
				<tr>
					<td class="cat" align="center"> <input type="submit" name="add_forum" value="<?php echo isset($this->vars['L_ADD_SELECTED']) ? $this->vars['L_ADD_SELECTED'] : $this->lang('L_ADD_SELECTED'); ?>" class="mainoption" />&nbsp; <input type="reset" value="<?php echo isset($this->vars['L_RESET']) ? $this->vars['L_RESET'] : $this->lang('L_RESET'); ?>" class="liteoption" />&nbsp; <input type="hidden" name="e_mode" value="perm" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>

<br />
<div align="center"><span class="copyright"><?php echo isset($this->vars['ATTACH_VERSION']) ? $this->vars['ATTACH_VERSION'] : $this->lang('ATTACH_VERSION'); ?></span></div>

<br clear="all" />
