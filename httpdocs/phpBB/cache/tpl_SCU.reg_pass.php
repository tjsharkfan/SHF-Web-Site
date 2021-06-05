<?php

// eXtreme Styles mod cache. Generated on Mon, 26 Sep 2005 22:25:49 -0700 (time=1127798749)

?><form action="<?php echo isset($this->vars['S_REG_PASS_ACTION']) ? $this->vars['S_REG_PASS_ACTION'] : $this->lang('S_REG_PASS_ACTION'); ?>" method="post">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left" class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a></td>
	</tr>
  </table>
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thHead"><b>Registration Pass Code</b></th>
	</tr>
	<tr> 
	  <td class="row1" align="center"><span class="gen">
	  	<br />
	  	Registration on this website is restricted to Santa Clara University EMBA students, faculty and staff.<br /><br />
		If you haven't already done so, please contact <a href="mailto:apaulin@scu.edu">Alex
		Paulin</a>, EMBA Coordinator, for the "Registration Pass Code".
	  	<br />
	  	<br />	
		Registration Pass Code:&nbsp;
	  	<input type="password" name="reg_pass" size="25" maxlength="32"/>&nbsp;&nbsp;
	  	<input class="mainoption" type="submit" name="submit" value="Submit" /></span>
	  </td>
	</tr>
  </table>
</form>