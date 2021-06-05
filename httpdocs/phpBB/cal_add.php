<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-04-29 18:41:35 +0100 (Fri, 29 Apr 2005) $
*	$Revision: 75 $
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
$session_loc = CAL_ADD;

require_once('cal_main.php');
include ($cal_file_path . 'includes/page_header.'.$phpEx);

if($caluser >= 2) {
	if ($userdata && $userdata['user_id'] != '-1') {
		$currentday = mydateformat(time(), 'j');
		} 
	else {
		$currentday = mydateformat(time(), 'j');
		}
	if ($day) { $currentday = $day; }

	include_once($cal_file_path . 'includes/functions_post.'.$phpEx);
	generate_smilies('inline', PAGE_POSTING);
	$template->set_filenames(array(
		'body' => 'cal_posting_body.tpl')
		);

	$template->assign_vars(array(
		'PHPBBHEADER' => $phpbbheaders,
		'CAL_VERSION' => 'Ver: '.$cal_config['version'],
		'CALENDAR' => $lang['Calendar'],
		'L_CAL_NEW' => $lang['Cal_add_event'],
		'U_INDEX' => append_sid("index.$phpEx"),
		'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
		'U_CAL_HOME' => $homeurl)
		);

	$template->assign_vars(array(
		'SUBJECT' => $subject,
		'MESSAGE' => $message,

		'L_SUBJECT' => $lang['Subject'],
		'L_MESSAGE_BODY' =>  $lang['Cal_description'],
		'L_SUBMIT' => $lang['Submit'],
		'L_CANCEL' => $lang['Cancel'],

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

		'S_POST_ACTION' => append_sid('cal_commit.'.$phpEx),
		'S_HIDDEN_FORM_FIELDS' => '',

		'DAY' => $currentday,
		'MONTH' => $month,
		'YEAR' => $year,
		'END_DAY' => $currentday,
		'END_MONTH' => $month,
		'END_YEAR' => $year,
		'STOP_DAY' => $currentday,
		'STOP_MONTH' => $month,
		'STOP_YEAR' => $year)
		);

	// Start Date fields
	$this_day = create_day_drop($currentday, 31, 1);
	$this_month = create_month_drop($month, $year, 1);
	if (!$cal_config['allow_old']) {
		$this_year = create_year_drop($year, ($year+2), 1);
		}
	else {
		$this_year = create_year_drop($year, '', 1);
		}

	// Time Fields
	if($cal_config['cal_timeformat'] == 'g:i a') {
		$this_hour = create_drop_hours('', TRUE);	// Special select function starting with 12 then cycling 1 - 11.
		$this_am_pm = select_am_pm('am_pm');
		$end_am_pm = select_am_pm('am_pm_end');
	} else {
		$this_hour = create_drop_num('', 23, 1, 0);
		$am_pm = '';
	}
	$this_min = create_drop_num('', 59, 5, 0);

	// End Date fields
	$r_end_day = create_day_drop('', 31, 0);
	$r_end_month = create_month_drop('', $year, 0);
	$r_end_year = create_year_drop('', ($year+2), 0);

	// Recurring fields
	$r_num = create_drop_num('', 30);
	$r_period = create_drop_period('');
	$drop_nth_num = create_drop_nth_num('', '');
	$drop_nth_period = create_drop_nth_period('');

	$currentmonth = mydateformat(time(), 'n');

	$category_select = create_category_drop($category);
	// Set the rest of the Calendar fields
	$template->assign_vars(array(
		'L_CAL_END_DATE' => $lang['End_day'],
		'L_CAL_HOME' => $lang['Cal_back2cal'])
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



	$template->assign_block_vars('date_info', array(
		'L_CAL_TITLE' => $lang['Event_title'],
		'L_CAL_DATE' => $lang['Cal_day'],
		'L_CAL_TIME' => $lang['Cal_hour'],
		'L_CAL_ENDDATE' => $lang['End_day'],
		'L_CAL_ENDTIME' => $lang['End_time'],
		'THIS_DAY' => $this_day,
		'THIS_MONTH' => $this_month,
		'THIS_YEAR' => $this_year,
		'THIS_HOUR' => $this_hour,
		'THIS_MIN' => $this_min,
		'THIS_AM_PM' => $this_am_pm,
		'END_DAY' => $this_day,
		'END_MONTH' => $this_month,
		'END_YEAR' => $this_year,
		'END_HOUR' => $this_hour,
		'END_MIN' => $this_min,
		'END_AM_PM' => $end_am_pm )
		);
	if ($caluser > 2) {
		// Users limited to suggesting events cannot suggest a recurring event
		// ... so we do now show this block for such users.
		$template->assign_block_vars('repeat_info', array(
			'L_CAL_TITLE_REC' => $lang['Recur_title'],
			'L_REPEAT' => $lang['Cal_repeats'],
			'L_UNTIL' => $lang['until'],
			'L_OR' => $lang['OR_every'],
			'STOP_DAY' =>   $r_end_day,
			'STOP_MONTH' => $r_end_month,
			'STOP_YEAR' =>  $r_end_year,
			'R_PERIOD' => $r_period,
			'R_NUM' => $r_num,
			'NTH_PERIOD' => $drop_nth_period,
			'NTH_NUM' => $drop_nth_num)
			);
	}

	if ($cal_config['allow_cat']) {
		$template->assign_block_vars('category_row', array(
			'L_CATEGORY' => $lang['category'],
			'CATEGORY_SELECT' => $category_select)
			);
	}
	if ($cal_config['allow_private'] || ($cal_config['allow_group_events'] && $groups)) {
		$cal_config['allow_private'] = (isset($cal_config['allow_private']) && $userdata['user_level'] != ANONYMOUS)  ? $cal_config['allow_private'] : 0;
		$cal_config['allow_group_events'] = (isset($cal_config['allow_group_events']) && $groups) ? $cal_config['allow_group_events'] : 0;

		// MOD set default event to private if private events being viewed when "add event" pressed
		$select_default = ($cal_config['allow_private'] && $category == 'private') ? 1 : 0;

		$access_select = create_access_drop($select_default, $cal_config['allow_private'], $cal_config['allow_group_events']);

		$template->assign_block_vars('access_choices', array(
			'L_EVENT_ACCESS' => $lang['event_access'],
			'S_EVENT_ACCESS' => $access_select)
			);
	}
	if($groups && $cal_config['allow_group_events']) {
		$group_select = create_groups_drop($groups, '');
		$template->assign_block_vars('group_choices', array(
			'L_GROUP_CHOICE' => $lang['group_select'],
			'S_GROUP_SELECT' => $group_select,
			'L_GROUP_SELECT_EXPLAIN' => $lang['group_event_explain'])
			);
	}

	$template->pparse('body');
}
else {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}

include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
exit;
?>