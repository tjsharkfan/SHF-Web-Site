<?php
/***************************************************************************
 *                            admin_cal_ug_auth.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_cal_ug_auth.php,v 1.2 2004/07/20 09:27:36 martin Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Calendar']['User Permissions'] = $filename . "?mode=user";
	$module['Calendar']['Group Permissions'] = $filename . "?mode=group";

	return;
}

//
// Load default header
//
$no_page_header = TRUE;

$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);

$params = array('mode' => 'mode', 'user_id' => POST_USERS_URL, 'group_id' => POST_GROUPS_URL, 'adv' => 'adv');

while( list($var, $param) = @each($params) )
{
	if ( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )
	{
		$$var = ( !empty($HTTP_POST_VARS[$param]) ) ? $HTTP_POST_VARS[$param] : $HTTP_GET_VARS[$param];
	}
	else
	{
		$$var = "";
	}
}


$params = array('callevel' => 'callevel', 'dlmanlevel' => 'dlmanlevel', 'gallerylevel' => 'gallerylevel', 'linkzlevel' => 'linkzlevel');
while( list($var, $param) = @each($params) )
{
	if ( isset($HTTP_POST_VARS[$param]) || isset($HTTP_GET_VARS[$param]) )
	{
		$$var = ( isset($HTTP_POST_VARS[$param]) ) ? $HTTP_POST_VARS[$param] : $HTTP_GET_VARS[$param];
	}
	else
	{
		$$var = "";
	}
}

$links_flag = file_exists($phpbb_root_path.'links.' . $phpEx) ? TRUE : FALSE;
$gallery_flag = file_exists($phpbb_root_path.'modules.' . $phpEx) ? TRUE : FALSE;
$dlman_flag = file_exists($phpbb_root_path.'dlman.' . $phpEx) ? TRUE : FALSE;
$cal_flag = file_exists($phpbb_root_path.'cal_main.' . $phpEx) ? TRUE : FALSE;

define('CALENDAR_PRESENT', $cal_flag);
define('LINKZ_PRESENT', $links_flag);
define('GALLERY_PRESENT', $gallery_flag);
define('DLMAN_PRESENT', $dlman_flag);


$user_id = intval($user_id);
$group_id = intval($group_id);
$adv = intval($adv);
$mode = htmlspecialchars($mode);

//
// Start program - define vars
//
$forum_auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_vote', 'auth_pollcreate');

$auth_field_match = array(
	'auth_view' => AUTH_VIEW,
	'auth_read' => AUTH_READ,
	'auth_post' => AUTH_POST,
	'auth_reply' => AUTH_REPLY,
	'auth_edit' => AUTH_EDIT,
	'auth_delete' => AUTH_DELETE,
	'auth_sticky' => AUTH_STICKY,
	'auth_announce' => AUTH_ANNOUNCE, 
	'auth_vote' => AUTH_VOTE, 
	'auth_pollcreate' => AUTH_POLLCREATE);

$field_names = array(
	'auth_view' => $lang['View'],
	'auth_read' => $lang['Read'],
	'auth_post' => $lang['Post'],
	'auth_reply' => $lang['Reply'],
	'auth_edit' => $lang['Edit'],
	'auth_delete' => $lang['Delete'],
	'auth_sticky' => $lang['Sticky'],
	'auth_announce' => $lang['Announce'], 
	'auth_vote' => $lang['Vote'], 
	'auth_pollcreate' => $lang['Pollcreate']);

if ( isset($HTTP_POST_VARS['submit']) && ( ( $mode == 'user' && $user_id ) || ( $mode == 'group' && $group_id ) ) )
{
	$user_level = '';
	if ( $mode == 'user' )
	{
		//
		// Get group_id for this user_id
		//
		$sql = "SELECT g.group_id, u.user_level
			FROM " . USER_GROUP_TABLE . " ug, " . USERS_TABLE . " u, " . GROUPS_TABLE . " g
			WHERE u.user_id = $user_id 
				AND ug.user_id = u.user_id 
				AND g.group_id = ug.group_id 
				AND g.group_single_user = " . TRUE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select info from user/user_group table', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);

		$group_id = $row['group_id'];
		$user_level = $row['user_level'];

		$db->sql_freeresult($result);
	}

	// 
	// MOD Calendar
	// Carry out update request for calendar
	if(CALENDAR_PRESENT === TRUE) {
		if ( $mode == 'user' && ($callevel || $callevel == '0')) {
			$sql = "UPDATE ". USERS_TABLE ." SET user_calendar_perm = ". $callevel
				." WHERE user_id = $user_id";
		}
		if ( $mode == 'group' && ($callevel || $callevel == '0')) {
			$sql = "UPDATE ". GROUPS_TABLE ." SET group_calendar_perm = ". $callevel
				." WHERE group_id = $group_id";
		}
		if ( !($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not update Calendar level', '', __LINE__, __FILE__, $sql);
		}
	}
	// END Mod Calendar


	// 
	// MOD DlMan
	// Carry out update request for Download Manager
	if(DLMAN_PRESENT === TRUE) {
		if ( $mode == 'user' && ($dlmanlevel || $dlmanlevel == '0')) {
			$sql = "UPDATE ". USERS_TABLE ." SET user_dlman_perm = ". $dlmanlevel
				." WHERE user_id = $user_id";
		}
		if ( $mode == 'group' && ($dlmanlevel || $dlmanlevel == '0')) {
			$sql = "UPDATE ". GROUPS_TABLE ." SET group_dlman_perm = ". $dlmanlevel
				." WHERE group_id = $group_id";
		}
		if ( !($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not update Download Manager level', '', __LINE__, __FILE__, $sql);
		}
	}
	// END Mod DlMan

	// 
	// MOD Linkz
	// Carry out update request for Linkz
	if(LINKZ_PRESENT === TRUE) {
		if ( $mode == 'user' && ($linkzlevel || $linkzlevel == '0')) {
			$sql = "UPDATE ". USERS_TABLE ." SET user_linkz_perm = ". $linkzlevel
				." WHERE user_id = $user_id";
		}
		if ( $mode == 'group' && ($linkzlevel || $linkzlevel == '0')) {
			$sql = "UPDATE ". GROUPS_TABLE ." SET group_linkz_perm = ". $linkzlevel
				." WHERE group_id = $group_id";
		}
		if ( !($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not update Linkz level', '', __LINE__, __FILE__, $sql);
		}
	}
	// END Mod Linkz


	// 
	// MOD Gallery Integration
	// Carry out update request for Gallery Integration
	if(GALLERY_PRESENT === TRUE) {
		if ( $mode == 'user' && ($gallerylevel || $gallerylevel == '0')) {
			$sql = "UPDATE ". USERS_TABLE ." SET user_gallery_perm = ". $gallerylevel
				." WHERE user_id = $user_id";
		}
		if ( $mode == 'group' && ($gallerylevel || $gallerylevel == '0')) {
			$sql = "UPDATE ". GROUPS_TABLE ." SET group_gallery_perm = ". $gallerylevel
				." WHERE group_id = $group_id";
		}
		if ( !($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not update Gallery level', '', __LINE__, __FILE__, $sql);
		}
	}
	// END Mod Gallery Integration

	$message = $lang['Auth_updated'] . '<br /><br />' . sprintf($lang['Click_return_userauth'], '<a href="' . append_sid("admin_cal_ug_auth.$phpEx?mode=$mode") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);

}
else if ( ( $mode == 'user' && ( isset($HTTP_POST_VARS['username']) || $user_id ) ) || ( $mode == 'group' && $group_id ) )
{
	// MOD START
	if ( isset($HTTP_POST_VARS['username']) || isset($HTTP_POST_VARS['email']) || isset($HTTP_POST_VARS['posts']) || isset($HTTP_POST_VARS['joined']) )
	{
	  //
	  // Lookup user
	  //
	  $username = ( !empty($HTTP_POST_VARS['username']) ) ? str_replace('%', '%%', trim(strip_tags( $HTTP_POST_VARS['username'] ) )) : '';
	  $email = ( !empty($HTTP_POST_VARS['email']) ) ? trim(strip_tags(htmlspecialchars( $HTTP_POST_VARS['email'] ) )) : '';
	  $posts = ( !empty($HTTP_POST_VARS['posts']) ) ? intval(trim(strip_tags( $HTTP_POST_VARS['posts'] ) )) : '';
	  $joined = ( !empty($HTTP_POST_VARS['joined']) ) ? trim(strtotime( $HTTP_POST_VARS['joined'] ) ) : 0;

	  $sql_where = ( !empty($username) ) ? 'u.username LIKE "%' . str_replace("\'", "''", $username) . '%"' : '';
	  $sql_where .= ( !empty($email) ) ? ( ( !empty($sql_where) ) ? ' AND u.user_email LIKE "%' . $email . '%"' : 'u.user_email LIKE "%' . $email . '%"' ) : '';
	  $sql_where .= ( !empty($posts) ) ? ( ( !empty($sql_where) ) ? ' AND u.user_posts >= ' . $posts : 'u.user_posts >= ' . $posts ) : '';
	  $sql_where .= ( $joined ) ? ( ( !empty($sql_where) ) ? ' AND u.user_regdate >= ' . $joined : 'u.user_regdate >= ' . $joined ) : '';

	  if ( !empty($sql_where) )
	  {
	    $sql = "SELECT u.user_id, u.username, u.user_email, u.user_posts, u.user_active, u.user_regdate
	      FROM " . USERS_TABLE . " u
	      WHERE $sql_where
	      ORDER BY u.username ASC";

	    if ( !( $result = $db->sql_query($sql) ) )
	    {
	      message_die(GENERAL_ERROR, 'Unable to query users', '', __LINE__, __FILE__, $sql);
	    }
	    else if ( !$db->sql_numrows($result) )
	    {
	      $message = $lang['No_user_id_specified'];
	      $message .= '<br /><br />' . sprintf($lang['Click_return_perms_admin'], '<a href="' . append_sid("admin_cal_ug_auth.$phpEx?mode=user") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
	      message_die(GENERAL_MESSAGE, $message);
	    }
	    else if ( $db->sql_numrows($result) == 1 )
	    {
	      // Redirect to this user
	      $row = $db->sql_fetchrow($result);

	     	$template->assign_vars(array(
	    		"META" => '<meta http-equiv="refresh" content="5;url=' . append_sid("admin_cal_ug_auth.$phpEx?mode=user&" . POST_USERS_URL . "=" . $row['user_id']) . '">')
		    );

	     	$message .= $lang['One_user_found'];
     		$message .= '<br /><br />' . sprintf($lang['Click_goto_user'], '<a href="' . append_sid("admin_cal_ug_auth.$phpEx?mode=user&" . POST_USERS_URL . "=" . $row['user_id']) . '">', '</a>');

	     	message_die(GENERAL_MESSAGE, $message);
	    }
	    else
	    {
	      // Show select screen
	      include('page_header_admin.'.$phpEx);

	    	$template->set_filenames(array(
			    'body' => 'admin/cal_user_lookup_body.tpl')
		    );

		    $template->assign_vars(array(
			'L_USERNAME' => $lang['Username'],
			'L_USER_TITLE' => $lang['Auth_Control_User'],
			'L_POSTS' => $lang['Posts'],
			'L_JOINED' => $lang['Sort_Joined'],
			'L_USER_EXPLAIN' => $lang['User_admin_explain'],
			'L_ACTIVE' => $lang['User_status'],
			'L_EMAIL_ADDRESS' => $lang['Email_address'])
		    );

		    $i = 0;
	      while ( $row = $db->sql_fetchrow($result) )
	      {
					$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

	        $template->assign_block_vars('user_row', array(
		      'ROW_COLOR' => '#' . $row_color,
		  	  'ROW_CLASS' => $row_class,
	          'USERNAME' => $row['username'],
        	  'EMAIL' => $row['user_email'],
	          'POSTS' => $row['user_posts'],
        	  'ACTIVE' => ( $row['user_active'] ) ? $lang['Yes'] : $lang['No'],
	          'JOINED' => create_date($lang['DATE_FORMAT'], $row['user_regdate'], $board_config['board_timezone']),

	          'U_USERNAME' => append_sid("admin_cal_ug_auth.$phpEx?mode=user&" . POST_USERS_URL . "=" . $row['user_id']))
        	);

	        $i++;
	      }
	     	$template->pparse('body');
		include('./page_footer_admin.'.$phpEx);
		exit;
	    }
	  }
	  else
	  {
		$message = $lang['No_user_id_specified'];
		$message .= '<br /><br />' . sprintf($lang['Click_return_perms_admin'], '<a href="' . append_sid("admin_cal_ug_auth.$phpEx?mode=user") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	  }	// END MOD (next line)
	}
	// MOD END 

	if ( isset($HTTP_POST_VARS['username']) )
	{
		$this_userdata = get_userdata($HTTP_POST_VARS['username'], true);
		if ( !is_array($this_userdata) )
		{
		// MOD run the check... 
			message_die(GENERAL_MESSAGE, $lang['No_such_user']);
		}
		$user_id = $this_userdata['user_id'];
	}

// Deleted code Marker

	$sql = "SELECT u.user_id, u.username, u.user_level, g.group_id, g.group_name, g.group_single_user FROM " . USERS_TABLE . " u, " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug WHERE ";
	$sql .= ( $mode == 'user' ) ? "u.user_id = $user_id AND ug.user_id = u.user_id AND g.group_id = ug.group_id" : "g.group_id = $group_id AND ug.group_id = g.group_id AND u.user_id = ug.user_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain user/group information", "", __LINE__, __FILE__, $sql);
	}
	$ug_info = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$ug_info[] = $row;
	}
	$db->sql_freeresult($result);

	$sql = ( $mode == 'user' ) ? "SELECT aa.*, g.group_single_user FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE. " g WHERE ug.user_id = $user_id AND g.group_id = ug.group_id AND aa.group_id = ug.group_id AND g.group_single_user = 1" : "SELECT * FROM " . AUTH_ACCESS_TABLE . " WHERE group_id = $group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain user/group permissions", "", __LINE__, __FILE__, $sql);
	}


// Deleted code Marker


	if ( $mode == 'user' )
	{
		$t_username = $ug_info[0]['username'];
		$s_user_type = ( $is_admin ) ? '<select name="userlevel"><option value="admin" selected="selected">' . $lang['Auth_Admin'] . '</option><option value="user">' . $lang['Auth_User'] . '</option></select>' : '<select name="userlevel"><option value="admin">' . $lang['Auth_Admin'] . '</option><option value="user" selected="selected">' . $lang['Auth_User'] . '</option></select>';
	}
	else
	{
		$t_groupname = $ug_info[0]['group_name'];
	}


	// MOD Calendar
	if(CALENDAR_PRESENT === TRUE) {
		// Query the appropriate table database re: group or user permissions.

		if ( $mode == 'user' ) {
			// Check the Users record
			$sql = "SELECT user_calendar_perm FROM ". $table_prefix ."users WHERE user_id = $user_id";
		}
		else {
			// Check Group
			$sql = "SELECT group_calendar_perm FROM ". $table_prefix ."groups WHERE group_id = $group_id";
		}
		$result = $db->sql_query($sql);
		if (!$result) { 
			message_die(GENERAL_MESSAGE, 'Could not access the Calendar Permission for User'); 
		} 
		$user_temp = $db->sql_fetchrow($result);
		if ($mode == 'user') {
			$cal_perm = $user_temp['user_calendar_perm'];
		}
		else {
			$cal_perm = $user_temp['group_calendar_perm'];
		}
		if (!$cal_perm && $cal_perm !='0')	{
			message_die(GENERAL_MESSAGE, 'Calendar Permissions Unavailable (ERR: ug_auth)');
		}
		$cal_levels[0] = $lang['no_public'];
		$cal_levels[1] = $lang['view_only'];
		$cal_levels[2] = $lang['view_suggest'];
		$cal_levels[3] = $lang['view_add'];
		$cal_levels[4] = $lang['view_edit_own'];
		$cal_levels[5] = $lang['cal_admin'];
		$s_cal_type = "<select name='callevel'>\n";
		for ($i=0; $i<=5; $i++) {
			$s_cal_type .="<option value='". $i;
			if ($i == $cal_perm) {
				$s_cal_type .="' selected='selected'>";
			}
			else {
				$s_cal_type .="'>";
			}
			$s_cal_type .= $cal_levels[$i] ."</option>\n";
		}
		$s_cal_type .="</select>\n";
	}
	else {
		$s_cal_type = "<span class='genmed'><i>(not available)</i></span>";
	}
	// End MOD Calendar


	// MOD DlMan
	if(DLMAN_PRESENT === TRUE) {
		// Query the appropriate table database re: group or user permissions.

		if ( $mode == 'user' ) {
			// Check the Users record
			$sql = "SELECT user_dlman_perm FROM ". $table_prefix ."users WHERE user_id = $user_id";
		}
		else {
			// Check Group
			$sql = "SELECT group_dlman_perm FROM ". $table_prefix ."groups WHERE group_id = $group_id";
		}
		$result = $db->sql_query($sql);

		if (!$result) { 
			message_die(GENERAL_MESSAGE, 'Could not access the Download Manager Permission for User'); 
		} 
		$user_temp = $db->sql_fetchrow($result);
		if ($mode == 'user') {
			$dlman_perm = $user_temp['user_dlman_perm'];
		}
		else {
			$dlman_perm = $user_temp['group_dlman_perm'];
		}
		if (!$dlman_perm && $dlman_perm !='0')	{
			message_die(GENERAL_MESSAGE, 'Download Manager Permissions Unavailable (ERR: ug_auth)');
		}
		$dlman_levels[0] = $lang['dlman_normal'];
		$dlman_levels[1] = $lang['dlman_upload'];
		$dlman_levels[2] = $lang['dlman_admin'];
		$s_dlman_type = "<select name='dlmanlevel'>\n";
		for ($i=0; $i<=2; $i++) {
			$s_dlman_type .="<option value='". $i;
			if ($i == $dlman_perm) {
				$s_dlman_type .="' selected='selected'>";
			}
			else {
				$s_dlman_type .="'>";
			}
			$s_dlman_type .= $dlman_levels[$i] ."</option>\n";
		}
		$s_dlman_type .="</select>\n";
	}
	else {
		$s_dlman_type = "<span class='genmed'><i>(not available)</i></span>";
	}
	// End MOD DlMan

	// MOD Linkz
	if(LINKZ_PRESENT === TRUE) {
		// Query the appropriate table database re: group or user permissions.

		if ( $mode == 'user' ) {
			// Check the Users record
			$sql = "SELECT user_linkz_perm FROM ". $table_prefix ."users WHERE user_id = $user_id";
		}
		else {
			// Check Group
			$sql = "SELECT group_linkz_perm FROM ". $table_prefix ."groups WHERE group_id = $group_id";
		}
		$result = $db->sql_query($sql);
		if (!$result) { 
			message_die(GENERAL_MESSAGE, 'Could not access the Linkz Permission for User'); 
		} 
		$user_temp = $db->sql_fetchrow($result);
		if ($mode == 'user') {
			$linkz_perm = $user_temp['user_linkz_perm'];
		}
		else {
			$linkz_perm = $user_temp['group_linkz_perm'];
		}
		if (!$linkz_perm && $linkz_perm !='0')	{
			message_die(GENERAL_MESSAGE, 'Linkz Permissions Unavailable (ERR: ug_auth)');
		}
		$linkz_levels[0] = $lang['no_public'];
		$linkz_levels[1] = $lang['view_only'];
		$linkz_levels[2] = $lang['view_suggest_links'];
		$linkz_levels[3] = $lang['view_add_links'];
		$linkz_levels[4] = $lang['view_edit_own'];
		$linkz_levels[5] = $lang['linkz_admin'];
		$s_linkz_type = "<select name='linkzlevel'>\n";
		for ($i=0; $i<=5; $i++) {
			$s_linkz_type .="<option value='". $i;
			if ($i == $linkz_perm) {
				$s_linkz_type .="' selected='selected'>";
			}
			else {
				$s_linkz_type .="'>";
			}
			$s_linkz_type .= $linkz_levels[$i] ."</option>\n";
		}
		$s_linkz_type .="</select>\n";
	}
	else {
		$s_linkz_type = "<span class='genmed'><i>(not available)</i></span>";
	}
	// End MOD Linkz

	// MOD Gallery Integration
	if(GALLERY_PRESENT === TRUE) {
		// Query the appropriate table database re: group or user permissions.

		if ( $mode == 'user' ) {
			// Check the Users record
			$sql = "SELECT user_gallery_perm FROM ". $table_prefix ."users WHERE user_id = $user_id";
		}
		else {
			// Check Group
			$sql = "SELECT group_gallery_perm FROM ". $table_prefix ."groups WHERE group_id = $group_id";
		}
		$result = $db->sql_query($sql);

		if (!$result) { 
			message_die(GENERAL_MESSAGE, 'Could not access the Gallery Permission for User'); 
		} 
		$user_temp = $db->sql_fetchrow($result);
		if ($mode == 'user') {
			$gallery_perm = $user_temp['user_gallery_perm'];
		}
		else {
			$gallery_perm = $user_temp['group_gallery_perm'];
		}
		if (!$gallery_perm && $gallery_perm !='0')	{
			message_die(GENERAL_MESSAGE, 'Gallery Permissions Unavailable (ERR: ug_auth)');
		}
		$gallery_levels[0] = $lang['View'];
		$gallery_levels[1] = $lang['Auth_User'];
		$gallery_levels[2] = $lang['Auth_Admin'];
		$s_gallery_type = "<select name='gallerylevel'>\n";
		for ($i=0; $i<=2; $i++) {
			$s_gallery_type .="<option value='". $i;
			if ($i == $gallery_perm) {
				$s_gallery_type .="' selected='selected'>";
			}
			else {
				$s_gallery_type .="'>";
			}
			$s_gallery_type .= $gallery_levels[$i] ."</option>\n";
		}
		$s_gallery_type .="</select>\n";
	}
	else {
		$s_gallery_type = "<span class='genmed'><i>(not available)</i></span>";
	}
	// End MOD Gallery Integration

	$name = array();
	$id = array();
	for($i = 0; $i < count($ug_info); $i++)
	{
		if( ( $mode == 'user' && !$ug_info[$i]['group_single_user'] ) || $mode == 'group' )
		{
			$name[] = ( $mode == 'user' ) ? $ug_info[$i]['group_name'] :  $ug_info[$i]['username'];
			$id[] = ( $mode == 'user' ) ? intval($ug_info[$i]['group_id']) : intval($ug_info[$i]['user_id']);
		}
	}

	if( count($name) )
	{
		$t_usergroup_list = '';
		for($i = 0; $i < count($ug_info); $i++)
		{
			$ug = ( $mode == 'user' ) ? 'group&amp;' . POST_GROUPS_URL : 'user&amp;' . POST_USERS_URL;

			$t_usergroup_list .= ( ( $t_usergroup_list != '' ) ? ', ' : '' ) . '<a href="' . append_sid("admin_cal_ug_auth.$phpEx?mode=$ug=" . $id[$i]) . '">' . $name[$i] . '</a>';
		}
	}
	else
	{
		$t_usergroup_list = $lang['None'];
	}

	$s_column_span = 2; // Two columns always present

	//
	// Dump in the page header ...
	//
	include('./page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		"body" => 'admin/cal_auth_ug_body.tpl')
	);

	$adv_switch = ( empty($adv) ) ? 1 : 0;
	$u_ug_switch = ( $mode == 'user' ) ? POST_USERS_URL . "=" . $user_id : POST_GROUPS_URL . "=" . $group_id;
	$switch_mode = append_sid("admin_cal_ug_auth.$phpEx?mode=$mode&amp;" . $u_ug_switch . "&amp;adv=$adv_switch");
	$switch_mode_text = ( empty($adv) ) ? $lang['Advanced_mode'] : $lang['Simple_mode'];
	$u_switch_mode = '<a href="' . $switch_mode . '">' . $switch_mode_text . '</a>';

	$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="adv" value="' . $adv . '" />';
	$s_hidden_fields .= ( $mode == 'user' ) ? '<input type="hidden" name="' . POST_USERS_URL . '" value="' . $user_id . '" />' : '<input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />';

	if ( $mode == 'user' )
	{
		$template->assign_block_vars('switch_user_auth', array());

		// MOD 'USER_CAL_LEVEL'.
		$template->assign_vars(array(
			'USERNAME' => $t_username,
			'USER_CAL_LEVEL' => "Calendar Level : </td><td>" . $s_cal_type,
			'USER_LINKZ_LEVEL' => "Linkz Level : </td><td>" . $s_linkz_type,
			'USER_DLMAN_LEVEL' => "DownLoad Man' Level : </td><td>" . $s_dlman_type,
			'USER_GALLERY_LEVEL' => "Gallery Level : </td><td>" . $s_gallery_type,
			'USER_GROUP_MEMBERSHIPS' => $lang['Group_memberships'] . ' : ' . $t_usergroup_list)
		);
	}
	else
	{
		$template->assign_block_vars("switch_group_auth", array());

		// MOD 'GROUP_CAL_LEVEL'.
		$template->assign_vars(array(
			'USERNAME' => $t_groupname,
			'GROUP_CAL_LEVEL' => "Calendar Level : </td><td>" . $s_cal_type,
			'GROUP_LINKZ_LEVEL' => "Linkz Level : </td><td>" . $s_linkz_type,
			'GROUP_DLMAN_LEVEL' => "DownLoad Man' Level : </td><td>" . $s_dlman_type,
			'GROUP_GALLERY_LEVEL' => "Gallery Level : </td><td>" . $s_gallery_type,
			'GROUP_MEMBERSHIP' => $lang['Usergroup_members'] . ' : ' . $t_usergroup_list)
		);
	}

	$template->assign_vars(array(
		'L_USER_OR_GROUPNAME' => ( $mode == 'user' ) ? $lang['Username'] : $lang['Group_name'],

		'L_AUTH_TITLE' => ( $mode == 'user' ) ? $lang['Auth_Control_User'] : $lang['Auth_Control_Group'],
		'L_AUTH_EXPLAIN' => ( $mode == 'user' ) ? $lang['User_auth_explain'] : $lang['Group_auth_explain'],
		'L_MODERATOR_STATUS' => $lang['Moderator_status'],
		'L_PERMISSIONS' => $lang['Permissions'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'], 
		'L_FORUM' => $lang['Forum'], 

		'U_USER_OR_GROUP' => append_sid("admin_cal_ug_auth.$phpEx"),
		'U_SWITCH_MODE' => $u_switch_mode,

		'S_COLUMN_SPAN' => $s_column_span,
		'S_AUTH_ACTION' => append_sid("admin_cal_ug_auth.$phpEx"), 
		'S_HIDDEN_FIELDS' => $s_hidden_fields)
	);
}
else
{
	//
	// Select a user/group
	//
	include('./page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		'body' => ( $mode == 'user' ) ? 'admin/cal_user_select_body.tpl' : 'admin/cal_auth_select_body.tpl')
	);

	if ( $mode == 'user' )
	{
		$template->assign_vars(array(
			'L_FIND_USERNAME' => $lang['Find_username'],

			'L_USERNAME' => $lang['Username'],
			'L_POSTS' => $lang['Posts'],
	 		'L_USER_LOOKUP_EXPLAIN' => $lang['User_lookup_explain'],
			'L_EMAIL_ADDRESS' => $lang['Email_address'],
			'L_JOINED' => $lang['Joined'],
			'L_JOINED_EXPLAIN' => $lang['User_joined_explain'],

			'U_SEARCH_USER' => append_sid("../search.$phpEx?mode=searchuser"))
		);
	}
	else
	{
		$sql = "SELECT group_id, group_name
			FROM " . GROUPS_TABLE . "
			WHERE group_single_user <> " . TRUE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Couldn't get group list", "", __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$select_list = '<select name="' . POST_GROUPS_URL . '">';
			do
			{
				$select_list .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
			}
			while ( $row = $db->sql_fetchrow($result) );
			$select_list .= '</select>';
		}

		$template->assign_vars(array(
			'S_AUTH_SELECT' => $select_list)
		);
	}

	$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" />';

	$l_type = ( $mode == 'user' ) ? 'USER' : 'AUTH';

	$template->assign_vars(array(
		'L_' . $l_type . '_TITLE' => ( $mode == 'user' ) ? $lang['Auth_Control_User'] : $lang['Auth_Control_Group'],
		'L_' . $l_type . '_EXPLAIN' => ( $mode == 'user' ) ? $lang['User_auth_explain'] : $lang['Group_auth_explain'],
		'L_' . $l_type . '_SELECT' => ( $mode == 'user' ) ? $lang['Select_a_User'] : $lang['Select_a_Group'],
		'L_LOOK_UP' => ( $mode == 'user' ) ? $lang['Look_up_User'] : $lang['Look_up_Group'],

		'S_HIDDEN_FIELDS' => $s_hidden_fields, 
		'S_' . $l_type . '_ACTION' => append_sid("admin_cal_ug_auth.$phpEx"))
	);

}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>