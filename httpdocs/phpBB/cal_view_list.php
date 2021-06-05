<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-05-06 10:38:08 +0100 (Fri, 06 May 2005) $
*	$Revision: 82 $
*
*********************************************/

/*###############################################################
## Mod Title: 	phpBB2 Calendar
## Mod Version: 2.0.38
## Author:      WebSnail < http://www.snailsource.com/ >
## Description: Variable settings for Calendar.php
##
## NOTE: Please read Calendar-README.txt for version information
###############################################################*/

include_once('cal_constants.inc');
$session_loc = CAL_LIST_VIEW;

require_once('cal_main.php');

if ($cal_config['allow_anon'] != '1' && $caluser < 1) {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}

include ($cal_file_path . 'includes/page_header.'.$phpEx);
include_once($cal_file_path . 'includes/bbcode.'.$phpEx);

$tz_diff = mytime();
$currentday = date( 'j', (time()+$tz_diff) );
$currentmonth = date( 'n', (time()+$tz_diff) );
$currentyear = date( 'Y', (time()+$tz_diff) );

$month = (!$month) ? $currentmonth : $month;
$year =  (!$year) ? $currentyear : $year;

// get category list
$category_select = ($cal_config['allow_cat']) ? create_category_drop($category, 1) : '';

$template->set_filenames(array(
	'body' => 'cal_view_list.tpl')
);

/*
	Input can be set using $start_day/month/year so that anything from a week
	to a year or some period in between can be displayed...

	If end point information is not provided then it will choose defaults from
	the data provided or the "current" date information.
*/


$start_year = isset($year) ? $year : $currentyear;
$end_year = isset($year_end) ? $year_end : (isset($year) ? $year : $currentyear);
$start_month = isset($month) ? $month : $currentmonth;
$end_month = isset($month_end) ? $month_end : (isset($month) ? $month : $currentmonth);
$start_day = isset($day) && $month != $currentmonth && $year != $currentyear ? $day : (($month == $currentmonth && $year == $currentyear) ? $currentday : 1);
$end_day = isset($day_end) ? $day_end : date('t',  mktime(0,0,0,$end_month,1,$end_year));

$start_point_unix = gmmktime(0,0,0,$start_month,$start_day,$start_year) + $tz_diff;
$end_point_unix = gmmktime(23,59,59,$end_month,$end_day,$end_year) + $tz_diff;

// User for NEXT  button
$nextmonth = ($end_month < 12) ? ($end_month + 1) : 1;
$nextyear = ($end_month < 12) ? $end_year : ($end_year + 1);

// Used for PREV  button
$lastmonth = ($start_month > 1) ? ($start_month - 1) : 12;
$lastyear = ($start_month > 1) ? $start_year: ($start_year - 1);

// Get number of days included in the lists range
$list_duration = intval(($end_point_unix - $start_point_unix) / (24*60*60));



// MOD group specific and private events - start
$sql = "SELECT *, c.event_start FROM ".CAL_TABLE." AS c 
	LEFT JOIN ".CAL_RECUR." AS r ON c.r_group_id = r.r_group_id
	LEFT JOIN ".CAL_GROUP_EVENT." AS ge ON c.id = ge.event_id
	LEFT JOIN ".CAL_CATS." AS cat ON c.category = cat.cat_id
	LEFT JOIN ".USERS_TABLE." AS u ON u.user_id = c.user_id
	WHERE c.valid = 'yes' AND c.r_type != 'D' AND ";

if($groups) {
	// If the user is member of 1+ usegroups then check for these results too.
	while(list(,$group) = each($groups)) {
		if(count($groups > 1) && isset($sql_groups)) {
			 $sql_groups .= " OR ";
		}
		$sql_groups .= "ge.group_id = ".$group['group_id'];
	}
	$sql_access = '(c.event_access = 2 AND ('.$sql_groups.' OR ge.group_id IS NULL OR ge.group_id = 0))';
}
$sql_access .= ($groups && $cal_config['allow_private']) ? ' OR ' : '';

if ($cal_config['admin_private_view'] && $caluser == 5 && $category == ADMIN_PRIVATE_EVENT) {
	// If we're screening users private events and have the requisite permissions/option on.
	$sql_access .= ' c.event_access = 1 ';
}
elseif($cal_config['allow_private']) {
	$sql_access .= ' (c.event_access = 1 AND c.user_id = '.$userdata['user_id'].') ';
}

$sql .= ($sql_access) ? '('.$sql_access.' OR c.event_access = 0)  AND ' : 'c.event_access = 0 AND ';
// MOD end

// MOD Null time/stable date fix
if($board_config['board_timezone'] < 12) {
	$sql .= "c.event_end >= '$start_point_unix' AND c.event_start <= '$end_point_unix' ";
}
else {
	
	// If time_set is 0 then the time is going to be GMT 12 noon to keep it in the right day. 
	// Timezones >= 12 screw this up so we allow for it with this SQL :)
	$time_adjust = 12 * 60 * 60;
	$sql .= "((c.event_end >= '$start_point_unix' AND c.event_start <= '$end_point_unix' AND event_time_set >= 1)
		OR (c.event_end >= '". ($start_point_unix + $time_adjust) ."' AND c.event_start <= '". ($end_point_unix + $time_adjust) ."' AND event_time_set = 0)) ";
}
// MOD end

if ($category) {
	$sql .= ($category != PRIVATE_EVENT && $category != ADMIN_PRIVATE_EVENT) ? "AND c.category = '$category' " : "AND c.event_access = 1 ";
}
$sql .= 'ORDER BY c.event_start';

if ( !($query = $db->sql_query($sql)) ) {
	message_die(GENERAL_ERROR, 'Could not get months data', '', __LINE__, __FILE__, $sql);
}

$events = array();
$d_cnt = 0;
while($get_row = $db->sql_fetchrow($query)) {
	// Stop repeats of the same event
	/* 	Because the events are in order of date, duplicate events created for users in multiple usergroups
		will follow duplicate events and can be screened out here
	*/
	if($prev_event_id == $get_row['id']) {
		continue;
	}
	$prev_event_id = $get_row['id'];

	$events[$d_cnt] = $get_row;

	// Standardise unix timestamp value to a day with 00:00 time
	$events[$d_cnt]['start_date'] = mydateformat($get_row['event_start'], "Ymd");
	$events[$d_cnt]['start_unix'] = strtotime($events[$d_cnt]['start_date']);

	// MOD Null time/stable date fix
	if(!$events[$d_cnt]['event_time_set'] && $board_config['board_timezone'] >= 12) {
		$events[$d_cnt]['event_start'] -= $time_adjust;
		$events[$d_cnt]['event_end'] -= $time_adjust;
	}
	$d_cnt++;
}

$date_list = array();

// Loop through and put events into $date_list array 
// Format $date_list[unixtimestamp][?] = $events[$i]
for ($i=0; $i < count($events); $i++) {
	// Work out what today is.. 
	$date_list[($events[ $i]['start_unix'])][] = $events[$i];
}
ksort($date_list);

if(count($date_list) == 0) {
	$template->assign_block_vars('no_events', array(
		'NO_EVENTS' => sprintf($lang['No_events_between'], mydateformat($start_point_unix,$cal_config['cal_dateformat']), mydateformat($end_point_unix,$cal_config['cal_dateformat']))
		)
	);
}

// Day loop
while(list($today_unix, $todays_events) = each($date_list)) {
	/* 
		$today_unix => unixtimestamp of todays date.
		BUT we alread corrected it so we need to return it to GMT timestamp
		before putting it through the mydateformat() again.
	*/

	$today_date = mydateformat(($today_unix - $tz_diff), $cal_config['cal_dateformat']);

	$template->assign_block_vars('day_row', array(
		'TODAY_DATE' => $today_date
		)
	);

	// Event loop
	while(list($key, $event_info) = each($todays_events)) {

		$start_date = mydateformat($event_info['event_start'], $cal_config['cal_dateformat']);
		$end_date = mydateformat($event_info['event_end'], $cal_config['cal_dateformat']);

		if($event_info['event_time_set'] && $cal_config['cal_timeformat']) {
			$event_time_start = '('.mydateformat($event_info['event_start'], $cal_config['cal_timeformat']).')';

			// event_time_set can be: 1 - both, 2 - start only
			$event_time_end = ($event_info['event_time_set'] == 1) ? '('.mydateformat($event_info['event_end'], $cal_config['cal_timeformat']).')' : '';
		}

		// Set Subject from Recurring and Single event rows.
		unset($full_subject);	// Clear variable
		if ($event_info['r_subject'] || $event_info['subject']) {
			$temp = get_subject($event_info, $cal_config['subject_length']);
			
			$full_subject = $temp['full_subject'];
			$subject = $temp['subject'];
			$bullet = $temp['bullet'];			
			
			$subjectnum = '';

			// Set $bullet for group or private events to allow easy differentiation.
			$event_access = ($event_info['event_access'] >= 1) ? (($event_info['event_access'] == 2) ? '<font color="red">('.$lang['group_event'].')</font>' : '<font color="green">('.$lang['private_event'].')</font>') : '';
		}

		if ($event_info['r_desc'] != '' && $event_info['description'] != '') {
			$zdesc = stripslashes($event_info['r_desc']) .'<BR><BR>'. stripslashes($event_info['description']);
		}
		elseif ($event_info['r_desc'] != '') {
			$zdesc = stripslashes($event_info['r_desc']);
		}
		else {
			$zdesc = stripslashes($event_info['description']);
		}
		$cat_name = stripslashes($event_info['cat_name']);
		if( $event_info['bbcode_uid'] != '' ) {
			$zdesc = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($zdesc, $event_info['bbcode_uid']) : preg_replace("/\:[0-9a-z\:]+\]/si", "]", $zdesc);
		}
		$zdesc = ( $board_config['allow_smilies'] ) ? smilies_pass($zdesc) : $zdesc;
		$zdesc = make_clickable($zdesc);

		// Delete icon
		if ( ( $caluser >= 4 && $userdata['user_id'] == $event_info['user_id'] ) || $caluser >= 5 ) {
			$delpost_img = '<a href="'. append_sid("cal_choice.$phpEx?mode=del&id=".$event_info['id'], 1) .'"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" align="middle" /></a>';
			if ($cal_config['allow_old'] == '1' || time() <= $event_info['event_start']) {
				$edit_img = '<a href="'.append_sid('cal_choice.'.$phpEx.'?mode=edit&id='.$event_info['id'], 1).'"><img src="' . $images['icon_edit'] . '" alt="' . $lang['Edit_delete_post'] . '" title="' . $lang['Edit_delete_post'] . '" border="0" align="middle" /></a>';
			}
			else {
				$edit_img = '';
			}
		}
		else {
			$edit_img = '';
			$delpost_img = '';
		}

		// Provide in User details.

		if ( $event_info['user_id'] != ANONYMOUS ) {
			$poster_id = $event_info['user_id'];
			$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
			$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
			$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

			$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
			$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
			$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

			if ( !empty($event_info['user_viewemail']) || $is_auth['auth_mod'] ) {
				$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $event_info['user_email'];
				$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
				$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
			}
			else {
				$email_img = '';
				$email = '';
			}
			$www_img = ( $event_info['user_website'] ) ? '<a href="' . $event_info['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
			$www = ( $event_info['user_website'] ) ? '<a href="' . $event_info['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

			$icq_img = ( $event_info['user_icq'] ) ? '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $event_info['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>' : '';
			$aim_img = ( $event_info['user_aim'] ) ? '<a href="aim:goim?screenname=' . $event_info['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
			$aim = ( $event_info['user_aim'] ) ? '<a href="aim:goim?screenname=' . $event_info['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

			$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
			$msn_img = ( $event_info['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
			$msn = ( $event_info['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

			$yim_img = ( $event_info['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $event_info['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
			$yim = ( $event_info['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $event_info['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
		}
		else {
			$profile_img = '';
			$profile = '';
			$pm_img = '';
			$pm = '';
			$email_img = '';
			$email = '';
			$www_img = '';
			$www = '';
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
			$aim_img = '';
			$aim = '';
			$msn_img = '';
			$msn = '';
			$yim_img = '';
			$yim = '';
		}

		// Null time/stable date fix
		if (!$event_info['event_time_set'] && $board_config['board_timezone'] >= 12) {
			$event_info['event_start'] -= $time_adjust;
			$event_info['event_end'] -= $time_adjust;
		}

		if($cat_name) {
			$cat_name = $cat_name ? ' <i>('.$cat_name.')</i>' : '';
		}

		$template->assign_block_vars('day_row.event_row', array(
			'ACCESS' => $event_access,
			'SUBJECT' => $full_subject,
			'CATEGORY' => $cat_name,
			'DATE' => $start_date,
			'END_DATE' => $end_date,
			'TIME' => $event_time_start,
			'END_TIME' => $event_time_end,
			'AUTHOR' => $event_info[username],
			'DESC' => $zdesc,
			'BUTTON_MOD' => $edit_img,
			'BUTTON_DEL' => $delpost_img,
			'POSTER_ONLINE' => (($event_info['user_session_time'] >= ( time() - 300 )) && ($event_info['user_allow_viewonline'])) ? '<img src="' . $images['Online'] . '" alt="' . $lang['Online'] . '" title="' . $lang['Online'] . '" border="0" />' : '<img src="' . $images['Offline'] . '" alt="' . $lang['Offline'] . '" title="' . $lang['Offline'] . '" border="0" />',
			'PROFILE_IMG' => $profile_img,
			'PROFILE' => $profile,
			'PM_IMG' => $pm_img,
			'PM' => $pm,
			'EMAIL_IMG' => $email_img,
			'EMAIL' => $email,
			'WWW_IMG' => $www_img,
			'WWW' => $www,
			'ICQ_STATUS_IMG' => $icq_status_img,
			'ICQ_IMG' => $icq_img,
			'ICQ' => $icq,
			'AIM_IMG' => $aim_img,
			'AIM' => $aim,
			'MSN_IMG' => $msn_img,
			'MSN' => $msn,
			'YIM_IMG' => $yim_img,
			'YIM' => $yim)
			);
		$check++;
	}
	// End Event Loop
}
// End Day Loop



if ($cal_config['allow_cat']) {
	// set range for this list_view.
	$jump_cat_info = "month=$start_month&month_end=$end_month&day=$start_day&day_end=$end_day";
	$jump_cat_info .= "&year=$start_year&year_end=$end_year";

	// Set append_sid( x, true) to stop it escaping the ampersand and screwing up JS call
	$jump_cat = append_sid('cal_view_list.'.$phpEx.'?'.$jump_cat_info, 1) .'&category=';
	$template->assign_block_vars('category_select', array(
		'L_FILTER_CATS_ALT' => $lang['Filter_cats_alt'],
		'L_FILTER_CATS' => $lang['Filter_cats'],
		'S_CATEGORY' => $category_select,
		'S_POST_ACTION' => append_sid('cal_view_list.'.$phpEx.'?'.$jump_cat_info, 1))
		);
	}
else {
	$template->assign_block_vars('no_categories', array());
	}
if ($category) {
	// Get the Category name.
	$cat_name = get_cal_cat($category);
	// Category display in title bar if filtering to a category is set.
	$filter = '('.$cat_name.')';
	}

// Home Button
$curmonthname = $lang['datetime'][date('F', mktime(0,0,0,$currentmonth,1,$year))];
$url = append_sid('cal_view_month.'.$phpEx.'?month='.$currentmonth.'&year='.$year, 1);
$button_home = button_main($url, $lang['Cal_back2cal'], 'center');

if ((($userdata && $userdata['user_id'] != '-1') && ($usersuggest == 'yes')) || ($caluser >= 2))
	{
	// Add Event button
	$button_add = button_add(append_sid('cal_add.'.$phpEx.'?month='.$month.'&year='.$year, 1), $category);
	// Admin Validate button
	$button_val = button_validate(append_sid('cal_validate.'.$phpEx.'?action=getlist', 1));
	}

// Previous Month button
$url = append_sid('cal_view_list.'.$phpEx.'?month='.$lastmonth.'&year='.$lastyear.'&day=1', 1);
$url .= ($category) ? '&category='.$category : '';
$button_prev = button_prev($url);

// Next Month button
$url = append_sid('cal_view_list.'.$phpEx.'?month='.$nextmonth.'&year='.$nextyear.'&day=1', 1);
$url .= ($category) ? '&category='.$category : '';
$button_next = button_next($url);

$template->assign_vars(array(
	'L_GO' => $lang['Go'], 
	'FILTER' => $filter,
	'U_JUMP_CAT' => $jump_cat,
	'U_JUMP_MONTH' => append_sid('cal_view_list.'.$phpEx.'?year='.$year.'&category='.$category.'&month=', 1),
	'U_JUMP_YEAR' => append_sid('cal_view_list.'.$phpEx.'?month='.$month.'&category='.$category.'&year=', 1),
	'L_MONTH_JUMP' => $lang['Month_jump'],
	'S_MONTH' => create_month_drop($month, $year),
	'S_YEAR' => create_year_drop($year, ''),
	'PHPBBHEADER' => $phpbbheaders,
	'CAL_VERSION' => 'Ver: '.$cal_config['version'],
	'CALENDAR' => $lang['Calendar'],
	'L_CAL_NEW' => $lang['Cal_add_event'],
	'U_INDEX' => append_sid("index.$phpEx", 1),
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'U_CAL_HOME' => $homeurl,
	'SUBJECT' => $lang['Subject'],
	'DATE' => $lang['Date'],
	'END_DATE' => $lang['End_day'],
	'TIME' => $lang['Cal_hour'],
	'AUTHOR' => $lang['Author'],
	'CATEGORY' => ' <i>('. $lang['category'] .')</i>',
	'BUTTON_PREV' => $button_prev,
	'BUTTON_NEXT' => $button_next,
	'BUTTON_HOME' => $button_home,
	'BUTTON_ADD' => $button_add,
	'BUTTON_VALIDATE' => $button_val)
);

$template->pparse('body');

include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
exit;
?>