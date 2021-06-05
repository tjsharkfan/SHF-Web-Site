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
$session_loc = CAL_DAY_VIEW;

require_once('cal_main.php');
include_once($cal_file_path . 'includes/bbcode.'.$phpEx);

if ($cal_config['allow_anon'] != '1' && $caluser == 0) {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}

include ($cal_file_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'cal_day_events.tpl')
);

$currentmonth = mydateformat(time(), 'n');
$tz_diff = mytime();

// Set link dates (in local time)
$your_date = gmmktime(0,0,0,$month,$day,$year);

$lastseconds = $your_date - (24*60*60);
$lastday = gmdate('j', $lastseconds);
$lastmonth = gmdate('n', $lastseconds);
$lastyear = gmdate('Y', $lastseconds);

$nextseconds = $your_date + (24*60*60);
$nextday = gmdate('j', $nextseconds);
$nextmonth = gmdate('n', $nextseconds);
$nextyear = gmdate('Y', $nextseconds);

// MOD group specific and private events - start
$sql = "SELECT *, c.event_start FROM ".CAL_TABLE." AS c 
	LEFT JOIN ".CAL_RECUR." AS r ON c.r_group_id = r.r_group_id
	LEFT JOIN ".CAL_CATS." AS cat ON c.category = cat.cat_id
	LEFT JOIN ".CAL_GROUP_EVENT." AS ge ON c.id = ge.event_id
	LEFT JOIN ".USERS_TABLE." AS u ON u.user_id = c.user_id
	WHERE c.valid = 'yes' AND c.r_type != 'D' AND ";

if(isset($groups[0])) {
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
	$sql_access .= ' (c.event_access = 1 AND c.user_id = "'.$userdata['user_id'].'") ';
}

$sql .= ($sql_access) ? '('.$sql_access.' OR c.event_access = 0)  AND ' : 'c.event_access = 0 AND ';
// MOD end



if ($id) {
	$sql .= " id = '$id'";
}
else {
	// Set unixtimes to GMT to search by
	$this_date_local = gmmktime(0,0,0,$month,$day,$year) - $tz_diff;
	$this_end_local = gmmktime(23,59,59,$month,$day,$year) - $tz_diff;


// MOD Null time/stable date fix
	if($board_config['board_timezone'] < 12) {
		$sql .= " c.event_end >= $this_date_local AND c.event_start <= '$this_end_local' ";
	}
	else {
		$time_adjust = 12 * 60 * 60;
		$sql .= " ((c.event_end >= '$this_date_local' AND c.event_start <= '$this_end_local' AND event_time_set >= 1)
			OR (c.event_end >= '". ($this_date_local + $time_adjust) ."' AND c.event_start <= '". ($this_end_local + $time_adjust) ."' AND event_time_set = 0)) ";
	}
}

if ($category) {
	$sql .= ($category != PRIVATE_EVENT && $category != ADMIN_PRIVATE_EVENT) ? " AND c.category = '$category' " : "AND c.event_access = 1 ";
}

$sql .= "ORDER BY c.event_start";


$time_adjust = ($board_config['board_timezone'] >= 12) ? (12 * 60 * 60) : 0;
// MOD end

if ( !($result = $db->sql_query($sql)) ) {
	message_die(GENERAL_ERROR, 'Could not select Event data');
}

$check=0;
while ($row = $db->sql_fetchrow($result)) {

	// If just an event ID provided then we need to grab the date info from the record
	if($id) {
		$t_date = $row['event_start'] + $tz_diff;
		$day = (!$day) ? gmdate('j', $t_date) : $day;
		$month = (!$month) ? gmdate('n', $t_date) : $month;
		$year = (!$year) ? gmdate('Y', $t_date) : $year;
	}

	// MOD group specific events - start
	// Stop repeats of the same event
	/* 	Because the events are in order of date, duplicate events created for users in multiple usergroups
		will follow duplicate events and can be screened out here
	*/
	if($prev_event_id == $row['id']) {
		continue;
	}
	$prev_event_id = $row['id'];
	// MOD end

	$temp = get_subject($row, $cal_config['subject_length'], TRUE);	// Supress the default bullet
	// Set $bullet for group or private events to allow easy differentiation.
	$bullet = $temp['bullet'];	
	$subject = $temp['full_subject'];

	if ($row['r_desc'] != '' && $row['description'] != '') {
		$zdesc = stripslashes($row['r_desc']) .'<BR><BR>'. stripslashes($row['description']);
	}
	elseif ($row['r_desc'] != '') {
		$zdesc = stripslashes($row['r_desc']);
	}
	else {
		$zdesc = stripslashes($row['description']);
	}
	$cat_name = stripslashes($row['cat_name']);
	if( $row['bbcode_uid'] != '' ) {
		$zdesc = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($zdesc, $row['bbcode_uid']) : preg_replace("/\:[0-9a-z\:]+\]/si", "]", $zdesc);
	}
	if ( $board_config['allow_smilies'] ) {
		$zdesc = smilies_pass($zdesc);
	}
	// Delete icon
	//echo $caluser; exit;
	if ( ( $caluser >= 4 && $userdata['user_id'] == $row['user_id'] ) || $caluser >= 5 ) {
		$delpost_img = '<a href="'. append_sid("cal_choice.$phpEx?mode=del&id=".$row['id'], 1) .'"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';

		if ($cal_config['allow_old'] == '1' || time() <= $row['event_start']) {
			$edit_img = '<a href="'.append_sid('cal_choice.'.$phpEx.'?mode=edit&id='.$row['id'], 1).'"><img src="' . $images['icon_edit'] . '" alt="' . $lang['Edit_delete_post'] . '" title="' . $lang['Edit_delete_post'] . '" border="0" /></a>';
		}
		else {
			$edit_img = '';
		}
	}
	else {
		$edit_img = '';
		$delpost_img = '';
	}

// MOD Add in User details.

	if ( $row['user_id'] != ANONYMOUS )
	{
		$poster_id = $row['user_id'];
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
		$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

		$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
		$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
		$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

		if ( !empty($row['user_viewemail']) || $is_auth['auth_mod'] )
		{
			$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $row['user_email'];

			$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
			$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
		}
		else
		{
			$email_img = '';
			$email = '';
		}

		$www_img = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
		$www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

		$icq_img = ( $row['user_icq'] ) ? '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>' : '';
		$aim_img = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
		$aim = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$msn_img = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
		$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

		$yim_img = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		$yim = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
	}
	else
	{
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

// MOD end.

	$zdesc = make_clickable($zdesc);

	// Null time/stable date fix
	if (!$row['event_time_set'] && $board_config['board_timezone'] >= 12) {
		$row['event_start'] -= $time_adjust;
		$row['event_end'] -= $time_adjust;
	}
	// Timezone difference fix
	/*
		mydateformat() handles this for us and adds the relevant timezone adjustment to the
		GMT stored date... So, no need to do it again for any displayed records
		SO LONG as we use the mydateformat() function to format it ;)
	*/



	$start_date = mydateformat($row['event_start'], $cal_config['cal_dateformat']);
	$end_date = mydateformat($row['event_end'], $cal_config['cal_dateformat']);


// DEV 2.0.25 - Start time or both option.
	if($row['event_time_set'] && $cal_config['cal_timeformat']) {
		$event_time_start = '('.mydateformat($row['event_start'], $cal_config['cal_timeformat']).')';

		// event_time_set can be: 1 - both, 2 - start only

		if($row['event_time_set'] == 1) {
			$event_time_end = '('.mydateformat($row['event_end'], $cal_config['cal_timeformat']).')';
		} else {
			$event_time_end = '';
		}
	} else {
		$event_time_start = '';
		$event_time_end = '';
	}
// End DEV.
	if($cat_name) {
		$cat_name = ' <i>('.$cat_name.')</i>';
	}
	else {
		$cat_name = '';
	}
	$template->assign_block_vars('event_row', array(
		'SUBJECT' => $bullet.$subject,
		'CATEGORY' => $cat_name,
		'DATE' => $start_date,
		'END_DATE' => $end_date,
		'TIME' => $event_time_start,
		'END_TIME' => $event_time_end,
		'AUTHOR' => $row[username],
		'DESC' => $zdesc,
		'BUTTON_MOD' => $edit_img,
		'BUTTON_DEL' => $delpost_img,
		'POSTER_ONLINE' => (($row['user_session_time'] >= ( time() - 300 )) && ($row['user_allow_viewonline'])) ? '<img src="' . $images['Online'] . '" alt="' . $lang['Online'] . '" title="' . $lang['Online'] . '" border="0" />' : '<img src="' . $images['Offline'] . '" alt="' . $lang['Offline'] . '" title="' . $lang['Offline'] . '" border="0" />',
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

if($check == 0)
	{
	$template->assign_block_vars('no_events', array(
		'NO_EVENTS' => $lang['No events'])
		);
	}

// Previous Month button	
$url = append_sid('cal_display.'.$phpEx.'?day='.$lastday.'&month='.$lastmonth.'&year='.$lastyear.'&category='.$category, 1);
$button_prev = button_prev($url);

// Viewed month link
$monthname = $lang['datetime'][date('F', mktime(0,0,0,$month,1,$year))];
$select_month_url = append_sid('cal_view_month.'.$phpEx.'?month='.$month.'&year='.$year.'&category='.$category, 1);

// Home Button
$curmonthname = $lang['datetime'][date('F', mktime(0,0,0,$currentmonth,1,$year))];
$url = append_sid('cal_view_month.'.$phpEx.'?month='.$currentmonth.'&year='.$year, 1);
$button_home = button_main($url, $lang['Cal_back2cal'], 'center');

// Next Month button.
$url = append_sid('cal_display.'.$phpEx.'?day='.$nextday.'&month='.$nextmonth.'&year='.$nextyear.'&category='.$category, 1);
$button_next = button_next($url);

if ($caluser >= 2) {
	// Add button
	$url = append_sid('cal_add.'.$phpEx.'?day='.$day.'&month='.$month.'&year='.$year.'&category='.$category, 1);
	$button_add = button_add($url, $category);

	// Validate button
	$url = append_sid('cal_validate.'.$phpEx.'?action=getlist', 1);
	$button_val = button_validate($url);
	}

$template->assign_vars(array(
	'PHPBBHEADER' => $phpbbheaders,
	'CAL_VERSION' => 'Ver: '.$cal_config['version'],
	'CALENDAR' => $lang['Calendar'],
	'L_CAL_NEW' => $lang['Cal_add_event'],
	'U_INDEX' => append_sid("index.$phpEx", 1),
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'U_CAL_HOME' => $homeurl)
	);

$template->assign_vars(array(
	'CAL_MONTH' => " <a href='$select_month_url' class='topictitle'>&nbsp;$monthname&nbsp;</a>",
	'CAL_YEAR' => $year,
	'CAL_DAY' => $day,
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
	'BUTTON_VAL' => $button_val)
);
$template->pparse('body');
//return;

include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
exit;
?>