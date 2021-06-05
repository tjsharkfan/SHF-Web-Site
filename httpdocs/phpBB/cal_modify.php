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
$session_loc = CAL_MODIFY;

require_once('cal_main.php');
include ($cal_file_path . 'includes/page_header.'.$phpEx);

if (($ed_option == 'edit_all' || $ed_option == 'split_future' || (!$ed_option && $row['r_type'] == '')) && ($caluser <= 2)) {
	// Users limited to suggesting events cannot suggest/modify a recurring event
	// ... so something is wrong if the user has access to a recurring event.
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']." <BR><span class='gensmall'>(ERROR: Modify Recur attempt by level <2 user.)</span>");
}

if($caluser >= 4) {

	include_once($cal_file_path . 'includes/functions_post.'.$phpEx);
	include_once($cal_file_path . 'includes/bbcode.'.$phpEx);

	if ($userdata['user_id'] != '-1') 
	{
		if (!$id) {
			message_die(GENERAL_ERROR, $lang['Cal_must_sel_event']);  
		}

		if ($ed_option == 'edit_all') {
			// Need to select the info for the first Iteration of the chain.

			$sql = "SELECT * FROM ".CAL_TABLE." AS c, ".CAL_RECUR." AS r 
				WHERE c.r_group_id = r.r_group_id ";
			$sql .= (!$cal_config['allow_old']) ? " AND c.event_start >= '".time()."' ": '' ;
			$sql .= " AND c.r_type = 'R' AND c.r_group_id = '$r_group_id' ORDER BY c.r_iteration";
		}
		elseif ($ed_option == 'split_future' || $ed_option == 'split_solo' || $ed_option == 'add_notes') {
			$sql = "SELECT * FROM ".CAL_TABLE." AS c, ".CAL_RECUR." AS r
				WHERE c.r_group_id = r.r_group_id AND c.id = '$id' AND c.r_group_id = '$r_group_id'";
		}
		else {
			$sql = "SELECT * FROM ".CAL_TABLE." AS c WHERE c.id = '$id'";
		}

		if ( !($query = $db->sql_query($sql)) )	{
			// CHECK define('DEBUG', 1);
			message_die(GENERAL_ERROR, 'Could not select event to modify from Table', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($query);

		if (($row['event_start'] < time()) && ($cal_config['allow_old'] != '1')) {
			message_die(GENERAL_ERROR, $lang['No_modify_old']);  
		}

		// Get info for group access
		$sql_group = "SELECT * FROM ".CAL_GROUP_EVENT." WHERE event_id = '".$row['id']."'";
		if ( !($query_group = $db->sql_query($sql_group)) )	{
			// CHECK define('DEBUG', 1);
			message_die(GENERAL_ERROR, 'Could not select groups with access to this event', '', __LINE__, __FILE__, $sql_group);
		}

		$group_access = array();
		while($acc = $db->sql_fetchrow($query_group)) {
			$group_access[] = $acc;
		}


		generate_smilies('inline', PAGE_POSTING);
		$template->set_filenames(array(
			'body' => 'cal_posting_body.tpl')
			);

		$template->assign_vars(array(
			'PHPBBHEADER' => $phpbbheaders,
			'CAL_VERSION' => 'Ver: '.$cal_config['version'],
			'CALENDAR' => $lang['Calendar'],
			'L_CAL_NEW' => $lang['Cal_mod_marked'],
			'U_INDEX' => append_sid("index.$phpEx", 1),
			'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
			'U_CAL_HOME' => $homeurl)
			);

		$template->assign_vars(array(
			'L_BBCODE_B_HELP' => $lang['bbcode_b_help'], 
			'L_BBCODE_I_HELP' => $lang['bbcode_i_help'], 
			'L_BBCODE_U_HELP' => $lang['bbcode_u_help'], 
			'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'], 
			'L_BBCODE_C_HELP' => $lang['bbcode_c_help'], 
			'L_BBCODE_L_HELP' => $lang['bbcode_l_help'], 
			'L_BBCODE_O_HELP' => $lang['bbcode_o_help'], 
			'L_BBCODE_P_HELP' => $lang['bbcode_p_help'], 
			'L_BBCODE_W_HELP' => $lang['bbcode_w_help'], 
			'L_BBCODE_A_HELP' => $lang['bbcode_a_help'], 
			'L_BBCODE_S_HELP' => $lang['bbcode_s_help'], 
			'L_BBCODE_F_HELP' => $lang['bbcode_f_help'], 
			'L_EMPTY_MESSAGE' => $lang['Empty_message'],

			'L_FONT_COLOR' => $lang['Font_color'], 
			'L_COLOR_DEFAULT' => $lang['color_default'], 
			'L_COLOR_DARK_RED' => $lang['color_dark_red'], 
			'L_COLOR_RED' => $lang['color_red'], 
			'L_COLOR_ORANGE' => $lang['color_orange'], 
			'L_COLOR_BROWN' => $lang['color_brown'], 
			'L_COLOR_YELLOW' => $lang['color_yellow'], 
			'L_COLOR_GREEN' => $lang['color_green'], 
			'L_COLOR_OLIVE' => $lang['color_olive'], 
			'L_COLOR_CYAN' => $lang['color_cyan'], 
			'L_COLOR_BLUE' => $lang['color_blue'], 
			'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'], 
			'L_COLOR_INDIGO' => $lang['color_indigo'], 
			'L_COLOR_VIOLET' => $lang['color_violet'], 
			'L_COLOR_WHITE' => $lang['color_white'], 
			'L_COLOR_BLACK' => $lang['color_black'], 

			'L_FONT_SIZE' => $lang['Font_size'], 
			'L_FONT_TINY' => $lang['font_tiny'], 
			'L_FONT_SMALL' => $lang['font_small'], 
			'L_FONT_NORMAL' => $lang['font_normal'], 
			'L_FONT_LARGE' => $lang['font_large'], 
			'L_FONT_HUGE' => $lang['font_huge'], 

			'L_EMPTY_DESC' => $lang['Empty description'],
			'L_EMPTY_SUBJECT' => $lang['Empty subject'],
			'L_MAX' => $lang['max'],
			'L_DAY' => $lang['day'],
			'L_JAN' => $lang['datetime']['January'],
			'L_FEB' => $lang['datetime']['February'],
			'L_MAR' => $lang['datetime']['March'],
			'L_APR' => $lang['datetime']['April'],
			'L_MAY' => $lang['datetime']['May'],
			'L_JUN' => $lang['datetime']['June'],
			'L_JUL' => $lang['datetime']['July'],
			'L_AUG' => $lang['datetime']['August'],
			'L_SEP' => $lang['datetime']['September'],
			'L_OCT' => $lang['datetime']['October'],
			'L_NOV' => $lang['datetime']['November'],
			'L_DEC' => $lang['datetime']['December'],

			'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'], 
			'L_STYLES_TIP' => $lang['Styles_tip'], 

			'S_POST_ACTION' => append_sid('cal_commit.'.$phpEx, 1))
			);

		$title_note = ' - ';

		// Check if this is the first iteration for edit_all. If not then change to a split_future
		if ($ed_option == 'edit_all' && $row['r_iteration'] != '0') {
			$id = $row['id'];
			$ed_option = 'split_future';
			$early_iteration = $lang['early_iteration'];
			$title_note .= $lang['Edit all title'];
			$title_set = 'yes';
		}

		if ($userdata['user_id'] == $row['user_id'] || $caluser == 5) {
			$bbcode_uid = $row['bbcode_uid'];

			$hidden_form_fields = "<input type=hidden name=id value='".$row['id']."'>
				<input type=hidden name=bbcode_uid value='".$row['bbcode_uid']."'>
				<input type=hidden name=modify value='Modify'>
				";
			if($ed_option) {
				$hidden_form_fields .= "<input type=hidden name=r_select value='$ed_option'>";
			}

			if($ed_option == 'edit_all') {
				// $row['event_start'] = $row['r_event_begin'];
				$edit_desc = $row['r_desc'];
				$edit_subject = $row['r_subject'];
				$title_note .= $lang['Edit all title'];
			}
			else if($ed_option == 'split_future') {
				$edit_desc = $row['r_desc'];
				$edit_subject = $row['r_subject'];
				if (!$title_set) {
					$title_note .= $lang['Split future title'];
				}
			}
			else if ($ed_option == 'split_solo') {
				$edit_desc = $row['r_desc'] . "\n------------\n". $row['description'];
				$edit_subject = INDICATE_SPLIT. $row['r_subject'];
				if ($row['subject']) {
					$edit_subject .= ': '. $row['subject'];
				}
				$title_note .= $lang['Split solo title'];
			}
			else {
				$edit_desc = $row['description'];
				$edit_subject = $row['subject'];
			}

			if ($ed_option == 'add_notes') {
				$title_note .= $lang['Add notes'];
			}			

			$year = mydateformat($row['event_start'], 'Y');
			$year_end = mydateformat($row['event_end'], 'Y');
			$month = mydateformat($row['event_start'], 'n');
			$month_end = mydateformat($row['event_end'], 'n');
			$day = mydateformat($row['event_start'], 'd');
			$day_end = mydateformat($row['event_end'], 'd');

			// Date fields field
			$drop_day = create_day_drop($day, 31, 1);
			$drop_month = create_month_drop($month, $year, 1);
			$drop_year = create_year_drop($year, $year, 1);

			$drop_day_end = create_day_drop($day_end, 31, 1);
			$drop_month_end = create_month_drop($month_end, $year_end, 1);
			$drop_year_end = create_year_drop($year_end, $year_end, 1);

			// Time fields
			if ($row['event_time_set'] > 0) {
				if($cal_config['cal_timeformat'] == 'g:i a') {
					$drop_hour = create_drop_hours(mydateformat($row['event_start'], 'g'), TRUE);	// Special select function starting with 12 then cycling 1 - 11.

					$switch_ampm = (mydateformat($row['event_start'], 'H') >= 12) ? 'pm' : 'am';
					$drop_am_pm = select_am_pm('am_pm', $switch_ampm);
				}
				else {
					$drop_hour = create_drop_num( mydateformat($row['event_start'], 'H'), 23, 1, 0);
					$drop_am_pm = '';
				}
				$drop_min = create_drop_num( mydateformat($row['event_start'], 'i'), 59, 5, 0);

				if ($row['event_time_set'] == 1) {
					if($cal_config['cal_timeformat'] == 'g:i a') {
						$drop_hour_end = create_drop_hours(mydateformat($row['event_end'], 'g'), TRUE);
						
						$switch_ampm = (mydateformat($row['event_end'], 'H') >= 12) ? 'pm' : 'am';
						$drop_am_pm_end = select_am_pm('am_pm_end', $switch_ampm);
					}
					else {
						$drop_hour_end = create_drop_num( mydateformat($row['event_end'], 'H'), 23, 1, 0);
						$drop_am_pm_end = '';
					}
					$drop_min_end = create_drop_num( mydateformat($row['event_end'], 'i'), 59, 5, 0);
				}
				else {
					$drop_hour_end = ($cal_config['cal_timeformat'] == 'g:i a') ? create_drop_hours('', TRUE) : create_drop_num('', 23, 1, 0);
					$drop_min_end = create_drop_num('', 59, 5, 0);
					$drop_am_pm_end = ($cal_config['cal_timeformat'] == 'g:i a') ? select_am_pm('am_pm_end') : '';
				}
			}
			else {
				if($cal_config['cal_timeformat'] == 'g:i a') {
					$drop_hour_end = $drop_hour = create_drop_hours('', TRUE);
					$drop_am_pm_end = $drop_am_pm = select_am_pm('am_pm_end');
				} else {
					$drop_hour_end = $drop_hour = create_drop_num('',23, 1, 0);
					$drop_am_pm_end = $drop_am_pm = '';			
				}
				$drop_min = $drop_min_end = create_drop_num('', 59, 5, 0);
			}
// End DEV.

			$currentmonth = mydateformat(time(), 'n');

			$category_select = create_category_drop(stripslashes($row['category']));

			// MOD Recurring event fields for Modify function

			// Check if this is a recurring event
			if ($row['r_group_id'] >= '1') {

				// Set "Repeat Until..." information
				$r_day = mydateformat($row['r_event_stop'], 'd');
				$r_month = mydateformat($row['r_event_stop'], 'n');
				$r_year = mydateformat($row['r_event_stop'], 'Y');

				$drop_r_day = create_day_drop($r_day, 31, 0);
				$drop_r_month = create_month_drop($r_month, $r_year, 0);
				$drop_r_year = create_year_drop($r_year, $r_year, 0);

				if ($row['r_type'] == 'S') {
					$row['r_num'] = '';
					$row['r_period'] = '';
					}

				$drop_num = (is_numeric($row['r_period'])) ? 0 : $row['r_num'];
				$drop_r_num = create_drop_num($drop_num, 30);
				$drop_r_period = create_drop_period($row['r_period']);

				$drop_nth_num = create_drop_nth_num($row['r_num'], $row['r_period']);
				$drop_nth_period = create_drop_nth_period($row['r_period']);

				//CHECK echo '<BR>'.$row['r_num'].' : '.$row['r_period']; exit;

				if ($row['r_type'] == 'R') {
					$hidden_form_fields .= "
				<input type=hidden name='r_iteration' value='".$row['r_iteration']."'>
				<input type=hidden name='r_group_id' value='".$row['r_group_id']."'>";

					$r_info = $row['r_iteration'] + 1;
					}

				if ($row['r_type'] == 'S') {
					$hidden_form_fields .= "
				<input type=hidden name='r_solo' value='solo_del'>";
					}
			} // End of recurring event check

			if ($row['r_type'] == '') {
				// Blank Recurring fields in case someone wants to turn this into a recur event

				$drop_r_day = create_day_drop('', 31, 0);
				$drop_r_month = create_month_drop('', $year, 0);
				$drop_r_year = create_year_drop('', ($year+2), 0);

				$drop_r_num = create_drop_num('', 30);
				$drop_r_period = create_drop_period('');

				$drop_nth_num = create_drop_nth_num('', '');
				$drop_nth_period = create_drop_nth_period('');

				$hidden_form_fields .= "<input type=hidden name='r_solo' value='solo_del'>\n\t\t\t\t";

				//CHECK echo '<BR>'.$row['r_num'].' : '.$row['r_period']; exit;
			}
			$edit_desc = str_replace('<br />', "\n", $edit_desc);
			$edit_desc = str_replace('<br>', "\n", $edit_desc);
			$edit_desc = preg_replace("/\:(([a-z0-9]:)?)" . $bbcode_uid . "/si", '', $edit_desc);
			$edit_desc = stripslashes($edit_desc);
			$edit_subject = stripslashes($edit_subject);

			if ($ed_option == 'add_notes' || !$ed_option) {
				$l_event_sp = $lang['Event specific'];
				$l_msg_body = $lang['Additional info'];

				if ($ed_option == 'add_notes') {
					$glob_subject = '<span class=genmed>[ '.stripslashes($row['r_subject']).' ]</span><BR>';
					$glob_desc = stripslashes($row['r_desc']);
					if( $board_config['allow_bbcode'] ) {
						$glob_desc = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($glob_desc, $bbcode_uid) : preg_replace("/\:[0-9a-z\:]+\]/si", ']', $glob_desc);
					}
				}
			}
			else {
				$l_event_sp = '';
				$l_msg_body = $lang['Cal_description'];
				$glob_subject = '';
				$glob_desc = '';
			}

			$template->assign_vars(array(
				'SUBJECT' => $edit_subject,
				'MESSAGE' => $edit_desc,
				'L_SUBJECT' => $lang['Subject'],
				'L_SUBJECT_XTRA' => $l_event_sp,
				'L_MESSAGE_BODY' =>  $l_msg_body,
				'L_SUBMIT' => $lang['Cal_mod_only'],
				'L_CANCEL' => $lang['Cancel'],

				'DAY' => $day,
				'MONTH' => $month,
				'YEAR' => $year,
				'END_DAY' => $day,
				'END_MONTH' => $month,
				'END_YEAR' => $year,
				'STOP_DAY' => $day,
				'STOP_MONTH' => $month,
				'STOP_YEAR' => $year)
			);


			// Set the rest of the Calendar fields
			$template->assign_vars(array(
				'L_CAL_NEW_NOTE' => $title_note,
				'L_CAL_HOME' => $lang['Cal_back2cal'],
				'S_HIDDEN_FORM_FIELDS' => $hidden_form_fields)
				);

			// Trigger the JS checking for Access_permissions.
			/*
				If the 'Allow_group_events' option is enabled then the relevant checking is
				loaded. If not, a blank set of JS functions avoids the onchange() calls failing with
				a JS error. (ref: cal_posting_body.tpl)
			*/
			if($cal_config['allow_group_events'] && $groups) {
				$template->assign_block_vars('access_check', array());
			}
			else {
				$template->assign_block_vars('null_check', array());
			}
			// End

			if ($ed_option != 'add_notes') {
				$template->assign_block_vars('date_info', array(
					'L_CAL_DATE' => $lang['Cal_day'],
					'L_CAL_TIME' => $lang['Cal_hour'],
					'L_CAL_ENDDATE' => $lang['End_day'],
					'L_CAL_ENDTIME' => $lang['End_time'],
					'L_CAL_TITLE' => $lang['Event_title'],
					'THIS_DAY' => $drop_day,
					'THIS_MONTH' => $drop_month,
					'THIS_YEAR' => $drop_year,
					'THIS_HOUR' => $drop_hour,
					'THIS_MIN' => $drop_min,
					'THIS_AM_PM' => $drop_am_pm,
					'END_DAY' => $drop_day_end,
					'END_MONTH' => $drop_month_end,
					'END_YEAR' => $drop_year_end,
					'END_HOUR' => $drop_hour_end,
					'END_MIN' => $drop_min_end,
					'END_AM_PM' => $drop_am_pm_end)
					);
			}
			else {
				$template->assign_block_vars('global_info', array(
					'L_GLOBAL_SUBJECT' => $lang['global subject'],
					'L_GLOBAL_DESC' => $lang['global desc'],
					'GLOBAL_DESC' => $glob_desc,
					'GLOBAL_SUBJECT' => $glob_subject)
					);
			}

			if ($ed_option == 'edit_all' || $ed_option == 'split_future' || (!$ed_option && $row['r_type'] == '')) {
				$template->assign_block_vars('repeat_info', array(
					'L_CAL_TITLE_REC' => $lang['Recur_title'],
					'L_REPEAT' => $lang['Cal_repeats'],
					'L_UNTIL' => $lang['until'],
					'L_EVENT_NUM' => $lang['Event_num'],
					'L_OR' => $lang['OR_every'],
					'STOP_DAY' =>   $drop_r_day,
					'STOP_MONTH' => $drop_r_month,
					'STOP_YEAR' =>  $drop_r_year,
					'R_PERIOD' => $drop_r_period,
					'R_NUM' => $drop_r_num,
					'NTH_PERIOD' => $drop_nth_period,
					'NTH_NUM' => $drop_nth_num,
					'EVENT_INFO' => $r_info,
					'EARLY_ITERATION' => $early_iteration)
					);
			}

			if ($cal_config['allow_cat'] && ($ed_option != 'add_notes')) {
				$template->assign_block_vars('category_row', array(
					'L_CATEGORY' => $lang['category'],
					'CATEGORY_SELECT' => $category_select)
					);
			}
			// MOD group & private events
			if ($ed_option != 'add_notes') {
				if ($cal_config['allow_private'] || ($cal_config['allow_group_events'] && $groups)) {
					$cal_config['allow_private'] = (isset($cal_config['allow_private']) && $userdata['user_level'] != ANONYMOUS)  ? $cal_config['allow_private'] : 0;
					$cal_config['allow_group_events'] = (isset($cal_config['allow_group_events']) && $groups) ? $cal_config['allow_group_events'] : 0;
					$access_select = create_access_drop($row['event_access'], $cal_config['allow_private'], $cal_config['allow_group_events']);

					$template->assign_block_vars('access_choices', array(
						'L_EVENT_ACCESS' => $lang['event_access'],
						'S_EVENT_ACCESS' => $access_select)
						);
				}
				if($groups && $cal_config['allow_group_events']) {
					$group_select = create_groups_drop($groups, $group_access);
					$template->assign_block_vars('group_choices', array(
						'L_GROUP_CHOICE' => $lang['group_select'],
						'S_GROUP_SELECT' => $group_select,
						'L_GROUP_SELECT_EXPLAIN' => $lang['group_event_explain'])
						);
				}
			}
			// MOD end.

			$template->pparse('body');
			}
		else {
			message_die(GENERAL_ERROR, $lang['Cal_edit_own_event']);
		}
	}
	else {
		message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
	}
}
else {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}
include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
exit;
?>