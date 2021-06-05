<?php

// eXtreme Styles mod cache. Generated on Fri, 30 Oct 2015 07:45:01 -0400 (time=1446205501)

?> 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a></span></td>
  </tr>
</table>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr> 
	<th class="thHead" colspan="2" height="25" nowrap="nowrap"><?php echo isset($this->vars['L_VIEWING_PROFILE']) ? $this->vars['L_VIEWING_PROFILE'] : $this->lang('L_VIEWING_PROFILE'); ?></th>
  </tr>
  <tr> 
	<td class="catLeft" width="40%" height="28" align="center"><b><span class="gen"><?php echo isset($this->vars['L_AVATAR']) ? $this->vars['L_AVATAR'] : $this->lang('L_AVATAR'); ?></span></b></td>
	<td class="catRight" width="60%"><b><span class="gen"><?php echo isset($this->vars['L_ABOUT_USER']) ? $this->vars['L_ABOUT_USER'] : $this->lang('L_ABOUT_USER'); ?></span></b></td>
  </tr>
  <tr> 
	<td class="row1" height="6" valign="top" align="center"><?php echo isset($this->vars['AVATAR_IMG']) ? $this->vars['AVATAR_IMG'] : $this->lang('AVATAR_IMG'); ?><br /><span class="postdetails"><?php echo isset($this->vars['POSTER_RANK']) ? $this->vars['POSTER_RANK'] : $this->lang('POSTER_RANK'); ?></span></td>
	<td class="row1" rowspan="3" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_JOINED']) ? $this->vars['L_JOINED'] : $this->lang('L_JOINED'); ?>:&nbsp;</span></td>
		  <td width="100%"><b><span class="gen"><?php echo isset($this->vars['JOINED']) ? $this->vars['JOINED'] : $this->lang('JOINED'); ?></span></b></td>
		</tr>
		<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_TOTAL_POSTS']) ? $this->vars['L_TOTAL_POSTS'] : $this->lang('L_TOTAL_POSTS'); ?>:&nbsp;</span></td>
		  <td valign="top"><b><span class="gen"><?php echo isset($this->vars['POSTS']) ? $this->vars['POSTS'] : $this->lang('POSTS'); ?></span></b><br /><span class="genmed">[<?php echo isset($this->vars['POST_PERCENT_STATS']) ? $this->vars['POST_PERCENT_STATS'] : $this->lang('POST_PERCENT_STATS'); ?> / <?php echo isset($this->vars['POST_DAY_STATS']) ? $this->vars['POST_DAY_STATS'] : $this->lang('POST_DAY_STATS'); ?>]</span> <br /><span class="genmed"><a href="<?php echo isset($this->vars['U_SEARCH_USER']) ? $this->vars['U_SEARCH_USER'] : $this->lang('U_SEARCH_USER'); ?>" class="genmed"><?php echo isset($this->vars['L_SEARCH_USER_POSTS']) ? $this->vars['L_SEARCH_USER_POSTS'] : $this->lang('L_SEARCH_USER_POSTS'); ?></a></span></td>
		</tr>
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_LOCATION']) ? $this->vars['L_LOCATION'] : $this->lang('L_LOCATION'); ?>:&nbsp;</span></td>
		  <td><b><span class="gen"><?php echo isset($this->vars['LOCATION']) ? $this->vars['LOCATION'] : $this->lang('LOCATION'); ?></span></b></td>
		</tr>
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_WEBSITE']) ? $this->vars['L_WEBSITE'] : $this->lang('L_WEBSITE'); ?>:&nbsp;</span></td>
		  <td><span class="gen"><b><?php echo isset($this->vars['WWW']) ? $this->vars['WWW'] : $this->lang('WWW'); ?></b></span></td>
		</tr>
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_OCCUPATION']) ? $this->vars['L_OCCUPATION'] : $this->lang('L_OCCUPATION'); ?>:&nbsp;</span></td>
		  <td><b><span class="gen"><?php echo isset($this->vars['OCCUPATION']) ? $this->vars['OCCUPATION'] : $this->lang('OCCUPATION'); ?></span></b></td>
		</tr>
		<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_INTERESTS']) ? $this->vars['L_INTERESTS'] : $this->lang('L_INTERESTS'); ?>:</span></td>
		  <td> <b><span class="gen"><?php echo isset($this->vars['INTERESTS']) ? $this->vars['INTERESTS'] : $this->lang('INTERESTS'); ?></span></b></td>
		</tr>
<?php

$switch_upload_limits_count = ( isset($this->_tpldata['switch_upload_limits.']) ) ?  sizeof($this->_tpldata['switch_upload_limits.']) : 0;
for ($switch_upload_limits_i = 0; $switch_upload_limits_i < $switch_upload_limits_count; $switch_upload_limits_i++)
{
 $switch_upload_limits_item = &$this->_tpldata['switch_upload_limits.'][$switch_upload_limits_i];
 $switch_upload_limits_item['S_ROW_COUNT'] = $switch_upload_limits_i;
 $switch_upload_limits_item['S_NUM_ROWS'] = $switch_upload_limits_count;

?>
		<tr> 
			<td valign="top" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_UPLOAD_QUOTA']) ? $this->vars['L_UPLOAD_QUOTA'] : $this->lang('L_UPLOAD_QUOTA'); ?>:</span></td>
			<td> 
				<table width="175" cellspacing="1" cellpadding="2" border="0" class="bodyline">
				<tr> 
					<td colspan="3" width="100%" class="row2">
						<table cellspacing="0" cellpadding="1" border="0">
						<tr> 
							<td bgcolor="<?php echo isset($this->vars['T_TD_COLOR2']) ? $this->vars['T_TD_COLOR2'] : $this->lang('T_TD_COLOR2'); ?>"><img src="templates/subSilver/images/spacer.gif" width="<?php echo isset($this->vars['UPLOAD_LIMIT_IMG_WIDTH']) ? $this->vars['UPLOAD_LIMIT_IMG_WIDTH'] : $this->lang('UPLOAD_LIMIT_IMG_WIDTH'); ?>" height="8" alt="<?php echo isset($this->vars['UPLOAD_LIMIT_PERCENT']) ? $this->vars['UPLOAD_LIMIT_PERCENT'] : $this->lang('UPLOAD_LIMIT_PERCENT'); ?>" /></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr> 
					<td width="33%" class="row1"><span class="gensmall">0%</span></td>
					<td width="34%" align="center" class="row1"><span class="gensmall">50%</span></td>
					<td width="33%" align="right" class="row1"><span class="gensmall">100%</span></td>
				</tr>
				</table>
				<b><span class="genmed">[<?php echo isset($this->vars['UPLOADED']) ? $this->vars['UPLOADED'] : $this->lang('UPLOADED'); ?> / <?php echo isset($this->vars['QUOTA']) ? $this->vars['QUOTA'] : $this->lang('QUOTA'); ?> / <?php echo isset($this->vars['PERCENT_FULL']) ? $this->vars['PERCENT_FULL'] : $this->lang('PERCENT_FULL'); ?>]</span> </b><br />
				<span class="genmed"><a href="<?php echo isset($this->vars['U_UACP']) ? $this->vars['U_UACP'] : $this->lang('U_UACP'); ?>" class="genmed"><?php echo isset($this->vars['L_UACP']) ? $this->vars['L_UACP'] : $this->lang('L_UACP'); ?></a></span></td>
			</td>
		</tr>
<?php

} // END switch_upload_limits

if(isset($switch_upload_limits_item)) { unset($switch_upload_limits_item); } 

?>
	  </table>
	</td>
  </tr>
  <tr> 
	<td class="catLeft" align="center" height="28"><b><span class="gen"><?php echo isset($this->vars['L_CONTACT']) ? $this->vars['L_CONTACT'] : $this->lang('L_CONTACT'); ?> <?php echo isset($this->vars['USERNAME']) ? $this->vars['USERNAME'] : $this->lang('USERNAME'); ?> </span></b></td>
  </tr>
  <tr> 
	<td class="row1" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen"><?php echo isset($this->vars['L_EMAIL_ADDRESS']) ? $this->vars['L_EMAIL_ADDRESS'] : $this->lang('L_EMAIL_ADDRESS'); ?>:</span></td>
		  <td class="row1" valign="middle" width="100%"><b><span class="gen"><?php echo isset($this->vars['EMAIL_IMG']) ? $this->vars['EMAIL_IMG'] : $this->lang('EMAIL_IMG'); ?></span></b></td>
		</tr>
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen"><?php echo isset($this->vars['L_PM']) ? $this->vars['L_PM'] : $this->lang('L_PM'); ?>:</span></td>
		  <td class="row1" valign="middle"><b><span class="gen"><?php echo isset($this->vars['PM_IMG']) ? $this->vars['PM_IMG'] : $this->lang('PM_IMG'); ?></span></b></td>
		</tr>
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen"><?php echo isset($this->vars['L_MESSENGER']) ? $this->vars['L_MESSENGER'] : $this->lang('L_MESSENGER'); ?>:</span></td>
		  <td class="row1" valign="middle"><span class="gen"><?php echo isset($this->vars['MSN']) ? $this->vars['MSN'] : $this->lang('MSN'); ?></span></td>
		</tr>
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen"><?php echo isset($this->vars['L_YAHOO']) ? $this->vars['L_YAHOO'] : $this->lang('L_YAHOO'); ?>:</span></td>
		  <td class="row1" valign="middle"><span class="gen"><?php echo isset($this->vars['YIM_IMG']) ? $this->vars['YIM_IMG'] : $this->lang('YIM_IMG'); ?></span></td>
		</tr>
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen"><?php echo isset($this->vars['L_AIM']) ? $this->vars['L_AIM'] : $this->lang('L_AIM'); ?>:</span></td>
		  <td class="row1" valign="middle"><span class="gen"><?php echo isset($this->vars['AIM_IMG']) ? $this->vars['AIM_IMG'] : $this->lang('AIM_IMG'); ?></span></td>
		</tr>
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen"><?php echo isset($this->vars['L_ICQ_NUMBER']) ? $this->vars['L_ICQ_NUMBER'] : $this->lang('L_ICQ_NUMBER'); ?>:</span></td>
		  <td class="row1"><script language="JavaScript" type="text/javascript"><!-- 

		if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
			document.write(' <?php echo isset($this->vars['ICQ_IMG']) ? $this->vars['ICQ_IMG'] : $this->lang('ICQ_IMG'); ?>');
		else
			document.write('<table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap="nowrap"><div style="position:relative;height:18px"><div style="position:absolute"><?php echo isset($this->vars['ICQ_IMG']) ? $this->vars['ICQ_IMG'] : $this->lang('ICQ_IMG'); ?></div><div style="position:absolute;left:3px;top:-1px"><?php echo isset($this->vars['ICQ_STATUS_IMG']) ? $this->vars['ICQ_STATUS_IMG'] : $this->lang('ICQ_STATUS_IMG'); ?></div></div></td></tr></table>');
		  
		  //--></script><noscript><?php echo isset($this->vars['ICQ_IMG']) ? $this->vars['ICQ_IMG'] : $this->lang('ICQ_IMG'); ?></noscript></td>
		</tr>
	  </table>
	</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
	<td align="right"><span class="nav"><br /><?php echo isset($this->vars['JUMPBOX']) ? $this->vars['JUMPBOX'] : $this->lang('JUMPBOX'); ?></span></td>
  </tr>
</table>
