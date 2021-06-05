<?php

// eXtreme Styles mod cache. Generated on Tue,  9 Aug 2005 20:58:07 -0700 (time=1123646287)

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="<?php echo isset($this->vars['S_CONTENT_DIRECTION']) ? $this->vars['S_CONTENT_DIRECTION'] : $this->lang('S_CONTENT_DIRECTION'); ?>">

<head>
  <link rel="stylesheet" href="modules/gallery/css/screen.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo isset($this->vars['S_CONTENT_ENCODING']) ? $this->vars['S_CONTENT_ENCODING'] : $this->lang('S_CONTENT_ENCODING'); ?>">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <?php echo isset($this->vars['META']) ? $this->vars['META'] : $this->lang('META'); ?>
  <?php echo isset($this->vars['NAV_LINKS']) ? $this->vars['NAV_LINKS'] : $this->lang('NAV_LINKS'); ?>
  <title><?php echo isset($this->vars['SITENAME']) ? $this->vars['SITENAME'] : $this->lang('SITENAME'); ?> :: <?php echo isset($this->vars['PAGE_TITLE']) ? $this->vars['PAGE_TITLE'] : $this->lang('PAGE_TITLE'); ?></title>
  <link rel="stylesheet" href="templates/BMan1Blue/<?php echo isset($this->vars['T_HEAD_STYLESHEET']) ? $this->vars['T_HEAD_STYLESHEET'] : $this->lang('T_HEAD_STYLESHEET'); ?>" type="text/css" />
  <style type="text/css"><!--
    body { background-image: url(templates/BMan1Blue/images/body_bg.gif); }
    td.banner { background-image: url(templates/BMan1Blue/images/SCU_logo_bg.gif); background-color: #C0C0C0; }
    td.rowpic { background-image: url(templates/BMan1Blue/images/<?php echo isset($this->vars['T_TH_CLASS3']) ? $this->vars['T_TH_CLASS3'] : $this->lang('T_TH_CLASS3'); ?>); }
    th { background-image: url(templates/BMan1Blue/images/<?php echo isset($this->vars['T_TH_CLASS2']) ? $this->vars['T_TH_CLASS2'] : $this->lang('T_TH_CLASS2'); ?>); }
    td.cat,td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom { background-image: url(templates/BMan1Blue/images/<?php echo isset($this->vars['T_TH_CLASS1']) ? $this->vars['T_TH_CLASS1'] : $this->lang('T_TH_CLASS1'); ?>); }
    .topictitle,h1,h2 { font-weight: bold; font-size: <?php echo isset($this->vars['T_FONTSIZE2']) ? $this->vars['T_FONTSIZE2'] : $this->lang('T_FONTSIZE2'); ?>px; color: <?php echo isset($this->vars['T_BODY_TEXT']) ? $this->vars['T_BODY_TEXT'] : $this->lang('T_BODY_TEXT'); ?>; }
    a.topictitle:link,a.topictitle:active { text-decoration: none; color: <?php echo isset($this->vars['T_BODY_LINK']) ? $this->vars['T_BODY_LINK'] : $this->lang('T_BODY_LINK'); ?>; }
    a.topictitle:visited { text-decoration: none; color: <?php echo isset($this->vars['T_BODY_VLINK']) ? $this->vars['T_BODY_VLINK'] : $this->lang('T_BODY_VLINK'); ?>; }
    a.topictitle:hover { text-decoration: underline; color: <?php echo isset($this->vars['T_BODY_HLINK']) ? $this->vars['T_BODY_HLINK'] : $this->lang('T_BODY_HLINK'); ?>; }
    @import url("templates/BMan1Blue/formIE.css");
  --></style>
  <?php

$switch_enable_pm_popup_count = ( isset($this->_tpldata['switch_enable_pm_popup.']) ) ?  sizeof($this->_tpldata['switch_enable_pm_popup.']) : 0;
for ($switch_enable_pm_popup_i = 0; $switch_enable_pm_popup_i < $switch_enable_pm_popup_count; $switch_enable_pm_popup_i++)
{
 $switch_enable_pm_popup_item = &$this->_tpldata['switch_enable_pm_popup.'][$switch_enable_pm_popup_i];
 $switch_enable_pm_popup_item['S_ROW_COUNT'] = $switch_enable_pm_popup_i;
 $switch_enable_pm_popup_item['S_NUM_ROWS'] = $switch_enable_pm_popup_count;

?>
  <script language="Javascript" type="text/javascript">
  <!--
    if ( <?php echo isset($this->vars['PRIVATE_MESSAGE_NEW_FLAG']) ? $this->vars['PRIVATE_MESSAGE_NEW_FLAG'] : $this->lang('PRIVATE_MESSAGE_NEW_FLAG'); ?> )
    {
      window.open('<?php echo isset($this->vars['U_PRIVATEMSGS_POPUP']) ? $this->vars['U_PRIVATEMSGS_POPUP'] : $this->lang('U_PRIVATEMSGS_POPUP'); ?>', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
    }
  //-->
  </script>
  <?php

} // END switch_enable_pm_popup

if(isset($switch_enable_pm_popup_item)) { unset($switch_enable_pm_popup_item); } 

?>
</head>

<body <?php echo isset($this->vars['GALLERY_CODE']) ? $this->vars['GALLERY_CODE'] : $this->lang('GALLERY_CODE'); ?>><a name="top"></a>
<table class="forumline" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
  <tr>
    <td class="banner" align="absbottom" align="left"><img src="templates/BMan1Blue/images/SCU_logo.jpg" alt="" border="0" />
    <td class="banner" align="absbottom" align="right"><img src="templates/BMan1Blue/images/SCU_EMBA_title.jpg" alt="" border="0" /></td>
  </tr>

  <?php

$switch_user_logged_in_count = ( isset($this->_tpldata['switch_user_logged_in.']) ) ?  sizeof($this->_tpldata['switch_user_logged_in.']) : 0;
for ($switch_user_logged_in_i = 0; $switch_user_logged_in_i < $switch_user_logged_in_count; $switch_user_logged_in_i++)
{
 $switch_user_logged_in_item = &$this->_tpldata['switch_user_logged_in.'][$switch_user_logged_in_i];
 $switch_user_logged_in_item['S_ROW_COUNT'] = $switch_user_logged_in_i;
 $switch_user_logged_in_item['S_NUM_ROWS'] = $switch_user_logged_in_count;

?>
  <tr>
    <td width="100%"><table width="100%" cellspacing="0" cellpadding="3" border="0">
      <tr>
        <td align="left"><span class="mainmenu">Welcome Back: <a href="<?php echo isset($this->vars['U_LOGIN_LOGOUT']) ? $this->vars['U_LOGIN_LOGOUT'] : $this->lang('U_LOGIN_LOGOUT'); ?>" class="mainmenu"><?php echo isset($this->vars['L_LOGIN_LOGOUT']) ? $this->vars['L_LOGIN_LOGOUT'] : $this->lang('L_LOGIN_LOGOUT'); ?></a></span></td>
      </tr>
    </table></td>
  </tr>
  <?php

} // END switch_user_logged_in

if(isset($switch_user_logged_in_item)) { unset($switch_user_logged_in_item); } 

?>

  <?php

$switch_user_logged_out_count = ( isset($this->_tpldata['switch_user_logged_out.']) ) ?  sizeof($this->_tpldata['switch_user_logged_out.']) : 0;
for ($switch_user_logged_out_i = 0; $switch_user_logged_out_i < $switch_user_logged_out_count; $switch_user_logged_out_i++)
{
 $switch_user_logged_out_item = &$this->_tpldata['switch_user_logged_out.'][$switch_user_logged_out_i];
 $switch_user_logged_out_item['S_ROW_COUNT'] = $switch_user_logged_out_i;
 $switch_user_logged_out_item['S_NUM_ROWS'] = $switch_user_logged_out_count;

?>
  <tr>
    <td width="100%" align="left"><table cellspacing="0" cellpadding="3" border="0"><tr><td><span class="mainmenu">Welcome Guest: <a href="<?php echo isset($this->vars['U_REGISTER']) ? $this->vars['U_REGISTER'] : $this->lang('U_REGISTER'); ?>" class="mainmenu"><?php echo isset($this->vars['L_REGISTER']) ? $this->vars['L_REGISTER'] : $this->lang('L_REGISTER'); ?></a> | <a href="<?php echo isset($this->vars['U_LOGIN_LOGOUT']) ? $this->vars['U_LOGIN_LOGOUT'] : $this->lang('U_LOGIN_LOGOUT'); ?>" class="mainmenu"><?php echo isset($this->vars['L_LOGIN_LOGOUT']) ? $this->vars['L_LOGIN_LOGOUT'] : $this->lang('L_LOGIN_LOGOUT'); ?></a></span></td></tr></table></td>
  </tr>
  <?php

} // END switch_user_logged_out

if(isset($switch_user_logged_out_item)) { unset($switch_user_logged_out_item); } 

?>
  </table>
  <span class="gensmall">&nbsp;</span>
  <table width=100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="2" border="0">
      <tr>
	   <td class="mainmenubody">
					<span class="mainmenu">
					<a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="mainmenu">Home</a> | 
					<a href="<?php echo isset($this->vars['U_CALENDAR']) ? $this->vars['U_CALENDAR'] : $this->lang('U_CALENDAR'); ?>" class="mainmenu"><?php echo isset($this->vars['L_CALENDAR']) ? $this->vars['L_CALENDAR'] : $this->lang('L_CALENDAR'); ?></a> |
					<a href="<?php echo isset($this->vars['U_SEARCH']) ? $this->vars['U_SEARCH'] : $this->lang('U_SEARCH'); ?>" class="mainmenu"><?php echo isset($this->vars['L_SEARCH']) ? $this->vars['L_SEARCH'] : $this->lang('L_SEARCH'); ?></a> |
					<a href="<?php echo isset($this->vars['U_PROFILE']) ? $this->vars['U_PROFILE'] : $this->lang('U_PROFILE'); ?>" class="mainmenu">My Profile</a> | 
					<a href="<?php echo isset($this->vars['U_PRIVATEMSGS']) ? $this->vars['U_PRIVATEMSGS'] : $this->lang('U_PRIVATEMSGS'); ?>" class="mainmenu">My Private Messages</a> | 
					<a href="<?php echo isset($this->vars['U_FAQ']) ? $this->vars['U_FAQ'] : $this->lang('U_FAQ'); ?>" class="mainmenu"><?php echo isset($this->vars['L_FAQ']) ? $this->vars['L_FAQ'] : $this->lang('L_FAQ'); ?></a> | 
				 <!-- <a href="<?php echo isset($this->vars['U_MEMBERLIST']) ? $this->vars['U_MEMBERLIST'] : $this->lang('U_MEMBERLIST'); ?>" class="mainmenu"><?php echo isset($this->vars['L_MEMBERLIST']) ? $this->vars['L_MEMBERLIST'] : $this->lang('L_MEMBERLIST'); ?></a> | -->
					<a href="<?php echo isset($this->vars['U_MEMBERLIST']) ? $this->vars['U_MEMBERLIST'] : $this->lang('U_MEMBERLIST'); ?>" class="mainmenu">Registered Users</a> | 
				 <!-- <a href="<?php echo isset($this->vars['U_GROUP_CP']) ? $this->vars['U_GROUP_CP'] : $this->lang('U_GROUP_CP'); ?>" class="mainmenu"><?php echo isset($this->vars['L_USERGROUPS']) ? $this->vars['L_USERGROUPS'] : $this->lang('L_USERGROUPS'); ?></a> -->
					<a href="<?php echo isset($this->vars['U_GROUP_CP']) ? $this->vars['U_GROUP_CP'] : $this->lang('U_GROUP_CP'); ?>" class="mainmenu">EMBA Groups</a> | 
				 	<a href="<?php echo isset($this->vars['U_GALLERY']) ? $this->vars['U_GALLERY'] : $this->lang('U_GALLERY'); ?>" class="mainmenu">Photo Gallery</a>
				 <!-- <a href="<?php echo isset($this->vars['U_PAYMENTS']) ? $this->vars['U_PAYMENTS'] : $this->lang('U_PAYMENTS'); ?>" class="mainmenu"><?php echo isset($this->vars['L_PAYMENTS']) ? $this->vars['L_PAYMENTS'] : $this->lang('L_PAYMENTS'); ?></a> | -->
				 <!-- <a href="<?php echo isset($this->vars['U_HALLOFFAME']) ? $this->vars['U_HALLOFFAME'] : $this->lang('U_HALLOFFAME'); ?>" class="mainmenu"><?php echo isset($this->vars['L_HALLOFFAME']) ? $this->vars['L_HALLOFFAME'] : $this->lang('L_HALLOFFAME'); ?></a> -->
					</span>
	   </td>
      </tr>
    </table>
  </td>
  </tr>
  </table>
  <span class="gensmall">&nbsp;</span>
  <table width="100%" cellspacing="0" cellpadding="10" border="0">
  <tr>
  <td class="bodyline">