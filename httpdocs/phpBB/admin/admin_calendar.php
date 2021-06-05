<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-04-30 22:04:09 +0100 (Sat, 30 Apr 2005) $
*	$Revision: 80 $
*
*********************************************/

/***************************************************************************
 *                            admin_calendar_config.php
 *                            -------------------
 * Copyright:   (C) 2002 SnailSource.com
 * Mod Title: 	phpBB2 Calendar
 * Mod Version: 2.0.35
 * Author:      WebSnail < http://www.snailsource.com >
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
	$module['Calendar']['Calendar Config'] = $filename;

	return;
}

global $db;

//
// Load default header
//
$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
require($phpbb_root_path . 'cal_settings.php');

require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_calendar.' . $phpEx);
$page_title =  $lang['Config_Cal'];


$sql = "SELECT * FROM ". CAL_CONFIG;
if(!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Couldn't query calendar config table", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CAL_CONFIG . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update calendar configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Cal_config_updated'] . "<br /><br />" . sprintf($lang['Cal_return_config'], "<a href=\"" . append_sid("admin_calendar.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}
}
// Build Week Start select box
$week_start_select  = "<select name='week_start'>";
$week_start_select .= "<option value='0' ";
$week_start_select .= ( $new['week_start'] == '0' ) ? "selected='selected'" : "";
$week_start_select .= ">".$lang['datetime']['Sunday']."</option>";
$week_start_select .= "<option value='1' ";
$week_start_select .= ( $new['week_start'] == '1' ) ? "selected='selected'" : "";
$week_start_select .= ">".$lang['datetime']['Monday']."</option>";
$week_start_select .= "</select>";

$allow_anon_yes = ( $new['allow_anon'] ) ? "checked=\"checked\"" : "";
$allow_anon_no = ( !$new['allow_anon'] ) ? "checked=\"checked\"" : "";

$allow_old_yes = ( $new['allow_old'] ) ? "checked=\"checked\"" : "";
$allow_old_no = ( !$new['allow_old'] ) ? "checked=\"checked\"" : "";

$show_headers_yes = ( $new['show_headers'] ) ? "checked=\"checked\"" : "";
$show_headers_no = ( !$new['show_headers'] ) ? "checked=\"checked\"" : "";

$allow_cat_yes = ( $new['allow_cat'] ) ? "checked=\"checked\"" : "";
$allow_cat_no = ( !$new['allow_cat'] ) ? "checked=\"checked\"" : "";

$require_cat_yes = ( $new['require_cat'] ) ? "checked=\"checked\"" : "";
$require_cat_no = ( !$new['require_cat'] ) ? "checked=\"checked\"" : "";

$require_time_yes = ( $new['require_time'] ) ? "checked=\"checked\"" : "";
$require_time_no = ( !$new['require_time'] ) ? "checked=\"checked\"" : "";

$allow_group_events_yes = ( $new['allow_group_events'] ) ? "checked=\"checked\"" : "";
$allow_group_events_no = ( !$new['allow_group_events'] ) ? "checked=\"checked\"" : "";

$allow_private_yes = ( $new['allow_private'] ) ? "checked=\"checked\"" : "";
$allow_private_no = ( !$new['allow_private'] ) ? "checked=\"checked\"" : "";

$admin_private_view_yes = ( $new['admin_private_view'] ) ? "checked=\"checked\"" : "";
$admin_private_view_no = ( !$new['admin_private_view'] ) ? "checked=\"checked\"" : "";

$cal_dateformat = date_format_select($new['cal_dateformat'], $board_config['board_timezone'], 'cal_dateformat');
$cal_timeformat = date_format_select($new['cal_timeformat'], $board_config['board_timezone'], 'cal_timeformat');

$cal_levels[0] = $lang['no_public'];
$cal_levels[1] = $lang['view_only'];
$cal_levels[2] = $lang['view_suggest'];
$cal_levels[3] = $lang['view_add'];
$cal_levels[4] = $lang['view_edit_own'];
$s_cal_type = "<select name='allow_user_default'>";
for ($i=0; $i<=4; $i++) {
	$s_cal_type .="<option value='". $i;
	if ($i == $new['allow_user_default']) {
		$s_cal_type .="' selected='selected'>\n";
		}
	else {
		$s_cal_type .="'>\n";
		}
	$s_cal_type .= $cal_levels[$i] ."</option>";
	}
$s_cal_type .="</select>";



$template->set_filenames(array(
	"body" => "admin/calendar_config_body.tpl")
);

$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_calendar.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_CONFIGURATION_TITLE" => $lang['Config_Calendar'],
	"L_GENERAL_SETTINGS" => $lang['Config_Calendar'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Config_Calendar_explain'],
	"L_WEEK_START" => $lang['week_start'],
	"L_SUBJECT_LENGTH" => $lang['subject_length'], 
	"L_SUBJECT_LENGTH_EXPLAIN" => $lang['subject_length_explain'],
	"L_SCRIPT_PATH" => $lang['Script_path'],
	"L_SCRIPT_PATH_EXPLAIN" => $lang['cal_script_path_explain'],
	"L_ALLOW_ANON" => $lang['allow_anon'], 
	"L_ALLOW_USER_POST" => $lang['allow_user_post'],
	"L_ALLOW_USER_DEFAULT" => $lang['allow_user_post_default'],
	"L_ALLOW_OLD" => $lang['allow_old'], 
	"L_ALLOW_OLD_EXPLAIN" => $lang['allow_old_explain'], 
	"L_SHOW_HEADERS" => $lang['show_headers'],
	"L_DATE_FORMAT" => $lang['Date_format'],
	"L_TIME_FORMAT" => $lang['time_format'], 
	"L_ALLOW_CATEGORIES" => $lang['allow_categories'],
	"L_REQUIRE_CATEGORIES" => $lang['require_categories'],
	"L_REQUIRE_TIME" => $lang['require_time'],
	"L_ALLOW_PRIVATE" => $lang['allow_private_event'],
	"L_ADMIN_PRIVATE_VIEW" => ($lang['admin_private_view'] ? $lang['admin_private_view'] : 'Allow admins to view private events:'),
	"L_ALLOW_GRP_EVENTS" => $lang['allow_group_event'],

	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'], 
	
	"CAL_VERSION" => $default_config['version'],
	"WEEK_START_SELECT" => $week_start_select, 
	"SUBJECT_LENGTH" => $new['subject_length'], 
	"SCIPT_PATH" => $new['cal_script_path'],

	"S_ALLOW_ANON_YES" => $allow_anon_yes,
	"S_ALLOW_ANON_NO" => $allow_anon_no,
	"S_ALLOW_USER_POST_YES" => $allow_user_post_yes,
	"S_ALLOW_USER_POST_NO" => $allow_user_post_no,
	"S_ALLOW_USER_DEFAULT" => $s_cal_type,
	"S_ALLOW_OLD_YES" => $allow_old_yes,
	"S_ALLOW_OLD_NO" => $allow_old_no, 
	"S_SHOW_HEADERS_YES" => $show_headers_yes,
	"S_SHOW_HEADERS_NO" => $show_headers_no,
	"S_ALLOW_CATEGORIES_YES" => $allow_cat_yes,
	"S_ALLOW_CATEGORIES_NO" => $allow_cat_no,
	"S_REQUIRE_CATEGORIES_YES" => $require_cat_yes,
	"S_REQUIRE_CATEGORIES_NO" => $require_cat_no,
	"S_DATE_FORMAT" => $cal_dateformat,
	"S_TIME_FORMAT" => $cal_timeformat,
	"S_REQUIRE_TIME_YES" => $require_time_yes,
	"S_REQUIRE_TIME_NO" => $require_time_no,
	"S_ALLOW_PRIVATE_YES" => $allow_private_yes,
	"S_ALLOW_PRIVATE_NO" => $allow_private_no,
	"S_ADMIN_PRIVATE_VIEW_YES" => $admin_private_view_yes,
	"S_ADMIN_PRIVATE_VIEW_NO" => $admin_private_view_no,
	"S_ALLOW_GRP_EVENTS_YES" => $allow_group_events_yes,
	"S_ALLOW_GRP_EVENTS_NO" => $allow_group_events_no
	)
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);


function date_format_select($default, $timezone, $select_name = 'cal_dateformat')
{
	global $board_config;
	$type = ($type < 0 || $type > 1) ? 0 : $type;

	// Include any valid PHP date format strings here, in your preferred order
	$date_format = array();
	$date_formats['cal_dateformat'] = array(
		'd-m-Y',
		'D. j. M. Y',
		'D d M, Y',
		'D M d, Y',
		'jS F Y',
		'F jS Y',
		'j/n/Y',
		'n/j/Y',
		'Y-m-d'
	);
	$date_formats['cal_timeformat'] = array(
		'g:i a',
		'H:i'
	);
	if ( !isset($timezone) ) {
		$timezone == $board_config['board_timezone'];
	}
	$now = time() + (3600 * $timezone);

	$df_select = '<select name="' . $select_name . '">';
	for ($i = 0; $i < sizeof($date_formats[$select_name]); $i++)
	{
		$format = $date_formats[$select_name][$i];
		$display = date($format, $now);
		$df_select .= '<option value="' . $format . '"';
		if (isset($default) && ($default == $format))
		{
			$df_select .= ' selected';
		}
		$df_select .= '>' . $display . '</option>\n';
	}
	$df_select .= '</select>';

	return $df_select;
}

?>