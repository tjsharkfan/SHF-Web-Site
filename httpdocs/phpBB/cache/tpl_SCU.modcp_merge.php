<?php

// eXtreme Styles mod cache. Generated on Mon, 24 Oct 2005 22:53:00 -0700 (time=1130219580)

?>
<form action="<?php echo isset($this->vars['S_MODCP_ACTION']) ? $this->vars['S_MODCP_ACTION'] : $this->lang('S_MODCP_ACTION'); ?>" method="post">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left" class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a></td>
	</tr>
  </table>
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thHead"><b><?php echo isset($this->vars['MESSAGE_TITLE']) ? $this->vars['MESSAGE_TITLE'] : $this->lang('MESSAGE_TITLE'); ?></b></th>
	</tr>
	<tr> 
	  <td class="row1"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center"><span class="gen"><?php echo isset($this->vars['L_MERGE_TOPIC']) ? $this->vars['L_MERGE_TOPIC'] : $this->lang('L_MERGE_TOPIC'); ?> &nbsp; <?php echo isset($this->vars['S_TOPIC_SELECT']) ? $this->vars['S_TOPIC_SELECT'] : $this->lang('S_TOPIC_SELECT'); ?><br /><br />
			  <?php echo isset($this->vars['MESSAGE_TEXT']) ? $this->vars['MESSAGE_TEXT'] : $this->lang('MESSAGE_TEXT'); ?></span><br />
			  <br />
			  <?php echo isset($this->vars['S_HIDDEN_FIELDS']) ? $this->vars['S_HIDDEN_FIELDS'] : $this->lang('S_HIDDEN_FIELDS'); ?> 
			  <input class="mainoption" type="submit" name="confirm" value="<?php echo isset($this->vars['L_YES']) ? $this->vars['L_YES'] : $this->lang('L_YES'); ?>" />
			  &nbsp;&nbsp; 
			  <input class="liteoption" type="submit" name="cancel" value="<?php echo isset($this->vars['L_NO']) ? $this->vars['L_NO'] : $this->lang('L_NO'); ?>" />
			</td>
		  </tr>
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
</form>
