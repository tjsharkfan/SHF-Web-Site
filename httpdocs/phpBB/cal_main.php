<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-05-01 11:59:14 +0100 (Sun, 01 May 2005) $
*	$Revision: 81 $
*
*********************************************/

/*###############################################################
## Mod Title: Calendar 
## Mod Version: 2.0.38
## Author: WebSnail < http://www.snailsource.com/ >
## Description: Add a Calendar to your phpBB2 installation!
##              All registerd and logged in users can post to the calendar
##              And Admins can modify, remove, add also.
##
## Installation Level: MEDIUM
## Installation Time: 5 minutes
## Files to Edit: 2 
## Files to Execute: 1(?) Dependent on upgrade/install of previous version. 
##
## NOTE: Please read Calendar-README.txt for version information
###############################################################*/



/*###############################################################
##                               STOP                           #
##              DO NOT MODIFY ANYTHING BELOW THIS LINE          #
###############################################################*/


// Filters used for Private events.
define('PRIVATE_EVENT', 1);
define('ADMIN_PRIVATE_EVENT', 99);

/* 
	Cat_id's 0 - 99 are reserved for private events
	.. and we may use the rest for usergroup colouring (or not)
*/

// Clear the critical variables.
unset($caluser);
unset($userdata);

// Required
define('IN_PHPBB', true);



// Avoid embarrassing loops by setting restrictive timeout IF safe mode isn't on.
$test_safe_mode = (bool) ini_get('safe_mode');
if(!$test_safe_mode) {
	set_time_limit(5);
}

// Set $cal_file_path to location of phpBB2 root directory.
$cal_file_path = realpath(isset($cal_file_path) ? $cal_file_path : './') . '/';	// Realpath removes the forward slash

// connect to phpbb
include_once($cal_file_path . 'extension.inc');
include_once($cal_file_path . 'common.'.$phpEx);
include_once($cal_file_path . 'includes/functions.'.$phpEx);
include_once($cal_file_path . 'cal_settings.'.$phpEx);
include_once($cal_file_path . 'cal_constants.inc');
include_once($cal_file_path . 'cal_functions.'.$phpEx);

$scriptname = 'cal_view_month.'.$phpEx;

// Permanent register_globals work around and more secure variable parser
$params = array(
	'sid' => 'sid',

	'id' => 'id', 
	'day' => 'day', 
	'month' => 'month', 
	'year' => 'year', 
	'mode' => 'mode', 
	'action' => 'action', 

	'hour' => 'hour', 
	'minute' => 'minute',
	'am_pm' => 'am_pm',
	'day_end' => 'day_end',
	'month_end' => 'month_end',
	'year_end' => 'year_end',
	'hour_end' => 'hour_end',
	'minute_end' => 'minute_end',
	'am_pm_end' => 'am_pm_end',
	'r_num' => 'r_num',
	'r_period' => 'r_period',
	'r_nth_num' => 'r_nth_num',
	'r_nth_period' => 'r_nth_period',
	'r_solo' => 'r_solo',
	'stop_day' => 'stop_day',
	'stop_month' => 'stop_month',
	'stop_year' => 'stop_year',

	'ed_option' => 'ed_option',
	'category' => 'category',
	'subject' => 'subject',
	'description' => 'message',
	'bbcode_uid' => 'bbcode_uid',
	'modify' => 'modify',
	'r_group_id' => 'r_group_id',
	'r_select' => 'r_select',
	'r_iteration' => 'r_iteration',

	'access_level' => 'access_level',
	'group_access' => 'group_access',

	'num_weeks' => 'wks',
	'validate_id'	=> 'validate_id'
	);

while( list($var, $param) = @each($params) )
{
	if ( isset($HTTP_POST_VARS[$param]) || isset($HTTP_GET_VARS[$param]) ) {
		$$var = ( isset($HTTP_POST_VARS[$param]) ) ? $HTTP_POST_VARS[$param] : $HTTP_GET_VARS[$param];
		$$var = str_replace("\'", "''", $$var);
	} else {
		unset($$var);
	}
}

//################################################
// Exploit code check and fix.

// Check we have the necessary function(s) available.
if(!function_exists('clean_me')) {
	message_die(GENERAL_ERROR, "<b>cal_functions.php</b> needs to be updated. Please update NOW!", "", __LINE__, __FILE__, '');
}

$num_params = array(
	'category',
	'day',
	'month',
	'year',
	'hour',
	'minute',
	'r_num',
	'r_nth_num',
	'day_end',
	'month_end',
	'year_end',
	'stop_day',
	'stop_month',
	'stop_year'
);

// Arrays to be checked.
$array_check = array(
	 0 => array('param' => 'validate_id', 'key' => 'num', 'val' => 'str', 'var' => 'num')
);


// Check key value for array. (Mainly for Validation routine)
foreach($array_check AS $test_array => $test_bits) {
	if(is_array($$test_bits['param'])) {
		$test_var = $test_bits['param'];
		$test_var_array = $$test_bits['param'];
		$new = array();
		foreach($test_var_array AS $this_key => $this_value) {
			$new[clean_me($this_key, $test_bits['key'])] = clean_me($this_value, $test_bits['val']);
		}
		$$var = $new;
	} else {
		$$var = clean_me($chubb, $test_bits['var']);
	}
}
// End Array Check

// Clear everything with intval()
foreach ($num_params AS $raw_num) {
	intval($raw_num);
}

// End Exploit code fix
//################################################


$session_default = -50;

// Work out what user is doing so session can display the correct info.
$session_loc = isset($session_loc) ? $session_loc : $session_default;

// Start session management
$userdata = session_pagestart($user_ip, $session_loc, $session_length);
init_userprefs($userdata);

$sql = 'SELECT * FROM '. CAL_CONFIG;
if(!$result = $db->sql_query($sql)) {
	message_die(GENERAL_ERROR, "Couldn't query calendar config table", "", __LINE__, __FILE__, $sql);
}
else {
	while( $row = $db->sql_fetchrow($result) ) {
		$cal_config[$row['config_name']] = $row['config_value'];
	}
}
// End of Calendar settings

// DO NOT CHANGE THESE!!!!!!!!!!!!!!!!
$langdays[0] = $lang['datetime']['Sunday'];
$langdays[1] = $lang['datetime']['Monday'];
$langdays[2] = $lang['datetime']['Tuesday'];
$langdays[3] = $lang['datetime']['Wednesday'];
$langdays[4] = $lang['datetime']['Thursday'];
$langdays[5] = $lang['datetime']['Friday'];
$langdays[6] = $lang['datetime']['Saturday'];
$langdays[7] = $langdays[0];			// Repeated to cover a Monday start

$langday[0] = $lang['datetime']['Sun'];
$langday[1] = $lang['datetime']['Mon'];
$langday[2] = $lang['datetime']['Tue'];
$langday[3] = $lang['datetime']['Wed'];
$langday[4] = $lang['datetime']['Thu'];
$langday[5] = $lang['datetime']['Fri'];
$langday[6] = $lang['datetime']['Sat'];
$langday[7] = $langday[0];


// Get group array
$groups = get_groups($userdata['user_id']);

// Set Users permissions.
if ($userdata['user_level'] == ADMIN) {
	$caluser = 5;
}
elseif ($userdata['user_id'] == ANONYMOUS) {
	$caluser = ($cal_config['allow_anon']) ? 1 : 0;
}
else {
	$caluser = calendarperm($userdata['user_id'], $groups);	// Set the user level for the user.
}


// Show headers if applic.
if ($cal_config['show_headers'] == 1) {
	$ct = sprintf($lang['Current_time'], mydateformat(time(), $board_config['default_dateformat']));
	if ( $userdata['session_logged_in'] ) { 
		$lvd = sprintf($lang['You_last_visit'], mydateformat($userdata['user_lastvisit'], $board_config['default_dateformat'])); 
	} 
	else { 
		$lvd = 'Not Logged In'; 
	} 
	$phpbbheaders  = '<span class=gensmall>'. $lvd ."<br>\n";
	$phpbbheaders .= $ct.'<br></span>';
}
else {
	$phpbbheaders = '';
}

// Force login for logged out users. Still fails access if login results in 0 level access rights

if(!$userdata['session_logged_in'] && ($cal_config['allow_anon'] != '1')) {
	header("Location: " . append_sid("login.$phpEx?redirect=cal_view_month.$phpEx", true)); 
}
elseif ($caluser <= 0) {
	$er_msg =  $lang['Cal_not_enough_access']."<br><br>\n";
	$er_msg .= $lang['Cal_must_member'];
	message_die(GENERAL_MESSAGE, $er_msg);
}


// Default date
$day = (!$day && !$id) ? mydateformat(time(), 'j') : $day;
$month = (!$month && !$id) ? mydateformat(time(), 'n') : $month;
$year = (!$year && !$id) ? mydateformat(time(), 'Y') : $year; 

// Set Calendar Home URL (used in all templates)
$homeurl = append_sid('cal_view_month.'.$phpEx, 1); 
$home_this_month = append_sid('cal_view_month.'."$phpEx?month=$month&year=$year", 1);

if ( $userdata['session_logged_in'] ) {
	$board_config['board_timezone'] = $userdata['user_timezone'];
}

$page_title = $lang['Calendar'];
?>