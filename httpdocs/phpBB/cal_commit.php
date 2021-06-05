<?php
/*********************************************
*	Calendar Pro
*
*	$Author: martin $
*	$Date: 2005-06-18 00:12:20 +0100 (Sat, 18 Jun 2005) $
*	$Revision: 110 $
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
$session_loc = CAL_DEFAULT;

require_once('cal_main.php');
include_once($cal_file_path . 'includes/bbcode.'.$phpEx);
include ($cal_file_path . 'includes/page_header.'.$phpEx);

// Fixes problem with the BBCode smilies
//$description = $message;
// Now solved through security code in cal_main.inc

if($caluser >= 2) {

	$currentdate = time();
	$tz_diff = mytime();

//############################
// RUN INPUT DATA CHECKS

	if($access_level == 1 && $caluser < 5 && !$cal_config['allow_private']) {
		message_die(GENERAL_ERROR, $lang['No_private_events']);
	}

	if (($subject =='' || $description =='') && $r_select != 'add_notes') {
		// CHECK echo "RS: $r_select , DESC: $description , SUB: $subject";
		message_die(GENERAL_ERROR, $lang['No information']);
	}
	if($category == '' && $cal_config['require_cat'] && $cal_config['allow_cat'] && $r_select != 'add_notes') {
		message_die(GENERAL_ERROR, $lang['No_cat_selected']);
	}


	// MOD Check Event Access
	if (!isset($access_level) || $access_level > 2) {
		$access_level = 0;
	}
	else if ($access_level == 1 || $access_level == 0) {
		$group_access = array();
	}
	else if ($access_level == 2 && count($group_access) < 1) {
		$access_level = 0;
		/*
		$lang['Grp select required'] = isset($lang['Grp select required']) ? $lang['Grp select required'] : 'You must select at least one group to restrict access to usergroups only';
		message_die(GENERAL_ERROR, $lang['Grp select required']);
		*/
	}

	// MOD end

	// Start date checks.

	if ($r_select != 'add_notes') {
		// Anything other than 'add_notes' f(n) needs date info.

		// Check if recurring end date is the same as the start date then it's the default so NULL values.
		if (($stop_month <= $month) && ($stop_day <= $day) && ($stop_year <= $year) && !$modify) {
			unset($stop_month);
			unset($stop_day);
			unset($stop_year);
		}

		// Valid Start Date?
		if (!checkdate($month,$day,$year)) {
			message_die(GENERAL_ERROR, $lang['Invalid date']);
		}
		// Valid End Date?
		if (!checkdate($month_end,$day_end,$year_end)) {
			message_die(GENERAL_ERROR, $lang['Invalid date']);
		}

		// CHECK echo "H: $hour M: $minute AM/PM: $am_pm, HE: $hour_end ME: $minute_end AM/PME: $am_pm_end";

		// Check time set.
		if ($hour != '' && $minute != '') {
			// Deal with am/pm settings
			if(isset($am_pm)) {
				if($am_pm == 'am') {
					$hour = ($hour == 12) ? 0 : $hour;
				} else {
					$hour = ($hour == 12) ? 12 : ($hour + 12);
				}
			}

			if ($hour_end != '' && $minute_end != '') {
				// Deal with am/pm settings
				if(isset($am_pm_end)) {
					if($am_pm_end == 'am') {
						$hour_end = ($hour_end == 12) ? 0 : $hour_end;
					} else {
						$hour_end = ($hour_end == 12) ? 12 : ($hour_end + 12);
					}
				}

				// ALL times are set.
				$time_set = 1;
			}
			else if (!$cal_config['require_time']) {
				// Only start times are set.
				$time_set = 2;

				// But we need to have an end time after the start (or weird reports)
				$hour_end = $hour;
				$minute_end = $minute + 5;	// Even if $minute = 55, it'll still increment to 60 and act as if hour+1
			}
			else {
				message_die(GENERAL_ERROR, $lang['No time']);
			}
		}
		else if (!$cal_config['require_time']){
			$time_set = 0;

			/* MOD Null time/stable date fix
			   To stop events with no time set dropping out of the set date we start and finish at 12 noon GMT
			*/
			$date_start = gmmktime(12,0,0,$month,$day,$year);
			$date_end = gmmktime(12,0,0,$month_end,$day_end,$year_end);

			$hour = '';
			$minute = '';
			$minute_end = '';
			$hour_end = '';
			unset($am_pm);
			unset($am_pm_end);
			// End Mod
		}
		else {
			message_die(GENERAL_ERROR, $lang['No time']);
		}
		// CHECK echo "\n<br/>H: $hour M: $minute AM/PM: $am_pm, HE: $hour_end ME: $minute_end AM/PME: $am_pm_end";


		// Check that date info has been set.
		if ($month != '' && $day != '' && $year != '' && $month_end != '' && $day_end != '' && $year_end != '') {
			// MOD Null time/stable date fix
			$date_start = !isset($date_start) ? gmmktime($hour,$minute,0,$month,$day,$year) - $tz_diff : $date_start;
			$date_end = !isset($date_end) ? gmmktime($hour_end,$minute_end,0,$month_end,$day_end,$year_end) - $tz_diff : $date_end;
			// End Mod
		}
		else {
			message_die(GENERAL_ERROR, $lang['No date']);
		}

		if ( !empty($stop_month) || !empty($stop_day) || !empty($stop_year) || !empty($r_num) || !empty($r_period) || !empty($r_nth_num) || (!empty($r_nth_period) || $r_nth_period === 0) ) {
			// Error if recurring info has been left blank.
			$r_error = '';
			
			$r_test = !empty($r_num) ? 1 : 0;
			$r_test += !empty($r_period) ? 1 : 0;
			if($r_test == 1) {
				$r_error .= isset($lang['r_every_x_period_miss']) ? $lang['r_every_x_period_miss'] : 'You must specify a period number AND type (eg: 2 weeks) for recuring event';
			}
			
			// We'll use the $r_test_nth as a flag to show that we are using this type.
			$r_test_nth = !empty($r_nth_num) ? 1 : 0;
			$r_test_nth += (!empty($r_nth_period) || $r_nth_period === 0) ? 1 : 0;
// CHECK echo "R_TEST_NTH: $r_test_nth";
			if($r_test_nth == 1) {
				$r_error .= isset($lang['r_every_nth_period_miss']) ? $lang['r_every_nth_period_miss'] : 'You must specify a Nth AND xxxday for recurring event';
			}
			$r_error .= !empty($r_error) ? '<BR />' : '';
			
			if( empty($stop_month) || empty($stop_day) || empty($stop_year) ) {
				$r_error .= isset($lang['need_r_stop_date']) ? $lang['need_r_stop_date'] : 'You must specify a full \'<b>until...</b>\' date for your recurring event chain';
			}
			
			if(!empty($r_error)) {
				message_die(GENERAL_ERROR, $r_error, '', __LINE__, __FILE__);
			}


			if (!checkdate($stop_month,$stop_day,$stop_year)) {
				// Valid Recurring events Stop Date?
				message_die(GENERAL_ERROR, $lang['Invalid date']);
			}
			else if ($caluser <= 2 && $r_num != '') {
				// Someone with 'suggest only' privileges is trying to spoof the server with recurring event.
				message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
			}
			else {
				$date_r_stop = gmmktime(23,59,59,$stop_month,$stop_day,$stop_year) - $tz_diff;

				if(preg_match("/^(day|week|month|year)$/", $r_period) && !empty($r_num)) {
					$recur_type = 0;	// Default older type of recurring event

					$next_event = strtotime(("+". $r_num. " $r_period"),$date_start);
					$next_event = dst_check($next_event, $date_start);

					// MOD Check for special recurring event issues with 28th - 31st dates.
					if($day >= 28 && $r_period == 'month') {
					// Check all dates to ensure that the day remains the same (ie: doesn't jump to beginning of month+2) 
						for ($this_date = $date_start; $this_date <= $date_r_stop; $this_date = inc_event_date($r_num, $r_period, $this_date, $recur_type)) {
							$test_day = gmdate("j", ($this_date - $tz_diff));

							if(intval($day) != intval($test_day)) {
								$test_month = gmdate("n", ($this_date - $tz_diff)) - 1;
								$test_month = ($test_month == 0) ? 12 : $test_month;
								$test_year = gmdate("Y", ($this_date - $tz_diff));
								message_die(GENERAL_ERROR, sprintf($lang['recur_no_such_date'], "$day/$test_month/$test_year"));
							}
						}
					}
				}
				elseif ($r_test_nth == 2) {
					$recur_type = 1;	// Newer type of recurring event.

					$r_num = $r_nth_num;
					$r_period = $r_nth_period;

					$next_event = inc_event_date($r_num, $r_period, $date_start, $recur_type);
// CHECK echo date("d-m-Y", $next_event);
				}
			}
// End MOD 2.0.31
			// Check for overlap between an initial event and a repeat

// CHECK echo "START: $date_start  DSTOP: $date_r_stop  NE: $next_event";

			if ($next_event <= $date_end) {
				// Event repeats before the initial event duration is over.
				message_die(GENERAL_ERROR, $lang['Event overlap']);
			}

			// Check that there is enough time for at least 1 repeat before finishing if r_num/r_period set
			if ($date_r_stop <= $next_event) {
				message_die(GENERAL_ERROR, $lang['R_period too small']);
			}
		}

		if ($date_start > $date_end) {
			message_die(GENERAL_ERROR, $lang['Date before start']);
		}


		//NOTE: $date_start is GMT converted so comparing it with the NOW time() requires no change.
		if ((time() > ($date_start)) && ($cal_config['allow_old'] != '1') && ($r_select != 'add_notes')) {
			// Provide debug (when DEBUG = 1) input if required to help spot obvious server misconfigurations.
			$err_debug = "GMT Time NOW      : ". time() .' ('. gmdate('d-m-Y H:i', time()) .") <BR />";
			$err_debug .= "GMT Date Converted: ".($date_start)." (". gmdate('d-m-Y H:i', ($date_start)) .")<br />Allow Old?: ".$cal_config['allow_old'];
			// date before today: Reject it.
			
			if(isset($lang['Date before today_detail'])) {
				$temp = $cal_config['cal_dateformat'].' '.$cal_config['cal_timeformat'];
				$old_event_err = sprintf($lang['Date before today_detail'], mydateformat(time(), $temp), mydateformat($date_start, $temp));
			} else {
				$old_event_err = $lang['Date before today'];
			}
			
			message_die(GENERAL_ERROR, $old_event_err, '', __LINE__, __FILE__, $err_debug);
		}

		if (isset($date_r_stop) && $date_start > $date_r_stop) {
			message_die(GENERAL_ERROR, $lang['R_period too small']);
		}

		// Calculate the length of event in seconds
		$event_length = $date_end - $date_start;
	}
	if (!$modify || $r_solo == 'solo_del') {
		// Set the username if this is a new event
		$username = addslashes($userdata[username]);
		// This stops the admin being set as the username if the event is being admin edited
	}
// FINISH Data input checks


//###############################
// PREPARE EVENT DESC & SUBJECT

	// Include necessary functions from phpBB2 for smilies and BBcode.
	include_once($cal_file_path . 'includes/functions_post.'.$phpEx);

	if (!$bbcode_uid) { $bbcode_uid = make_bbcode_uid(); }

	$description = ($board_config['allow_html']) ? $description : strip_tags($description);

	$description = prepare_message($description,
		$board_config['allow_html'],
		$board_config['allow_bbcode'],
		$board_config['allow_smilies'],
		$bbcode_uid);

	$description = str_replace("''", "'", $description);	// Deal with any single quote issues from security update
	$description = addslashes( str_replace("\n", '<br />', $description) );
	$description = ($board_config['allow_bbcode']) ? $description : cal_strip_bbcode($description);
	

	// Get rid of any commas in your subject field (causes untold problems with the HTML form)
	$subject = ereg_replace("[\"]", "", $subject);
	$subject = str_replace("''", "'", $subject);	// Deal with any single quote issues from security update
	$subject = cal_strip_bbcode($subject);			// Remove any bbcode
	$subject = strip_tags($subject);				// Remove any HTML tags
	$subject = addslashes($subject);

	if ($userdata['user_id']) { $userid = $userdata['user_id']; }
	else { $userid = '-1'; }

	$valid = 'no';
	// Auto-validate entry for users with appropriate level of access.
	if ($caluser >= 3 || $access_level == 1) {
		$valid = 'yes';
	}

	//CHECK echo "<br />\n Num: $r_num , period: $r_period , select: $r_select, groupid: $r_group_id,  iteration: $r_iteration,  start_date: $date_start,  end_date: $date_end";
	//CHECK echo "<br />\n SD: ".gmdate("Y-m-d H:i",$date_start).", SDOrig: ".gmdate("Y-m-d H:i",($date_start+$tz_diff));
	//CHECK echo "<br />\n ED: ".gmdate("Y-m-d H:i",$date_end).", EDOrig: ".gmdate("Y-m-d H:i",($date_end+$tz_diff));

	// Sanity check
	if (isset($r_iteration) && !$modify) {
		message_die(GENERAL_MESSAGE, 'ERROR: Somehow Iteration is getting through on NON modify functions');
	}


//###########################################
// SINGLE EVENTS

	if(!$r_select && !$r_num && !$r_period) {

		if ($modify) {
			// Modify an existing Single Event
			ereg_replace('<br />', '', $description);
			$sql = "UPDATE ".CAL_TABLE." SET event_start='$date_start', event_end = '$date_end', event_time_set = '$time_set', valid = '$valid',
				subject='$subject', description='$description', bbcode_uid='$bbcode_uid', category='$category', event_access='$access_level' 
				WHERE id = '$id'";
			event_group_update($id, $group_access);
		}
		else {
			// Store a NEW Single Event
			$sql = "INSERT INTO ".CAL_TABLE." (username, subject, description, user_id, valid, 
				event_start, event_end, event_time_set, bbcode_uid, category, r_type, event_access) 
				VALUES ('$username', '$subject', '$description', '$userid', '$valid', 
				'$date_start', '$date_end', $time_set, '$bbcode_uid', '$category', '', '$access_level')";
		}
		$query = do_query($sql, $lang['Cal_event_not_add']);

		// MOD Event_group
		$insert_id = (!$modify) ? ($db->sql_nextid()) : 0;
		if(!$modify) {
			event_group_add($insert_id, $group_access);
		}
		// MOD end
	}

//###########################################
// RETRIEVE RECUR' VARIABLES

	if(isset($r_select) && $r_select != 'add_notes' && $modify) {
		// We need to check whether the old recur info has changed

		ereg_replace('<br />', '', $description);

		$sql = "SELECT * FROM ".CAL_TABLE." AS c, ".CAL_RECUR." AS r 
			WHERE c.r_group_id = r.r_group_id AND c.r_group_id = '$r_group_id' AND c.id = '$id'";
		$query = do_query($sql, $lang['Cal_event_not_add']);
		$row = $db->sql_fetchrow($query);

		//CHECK echo '<br>num_rows: '. mysql_numrows($query);

		unset($sql);	// clear $sql

		$old_category = $row['category'];
		$old_rnum = $row['r_num'];
		$old_rperiod = $row['r_period'];
		$username = addslashes($row[username]);
		$start_iteration = $r_iteration;

// MOD 2.0.33b
		$old_date_unix = $row['event_start'];

	} 
	// End of set recur variables



//###########################################
// SPLIT SOLO

	if($r_select == 'split_solo') {
		ereg_replace('<br />', '', $description);

		$sql = "UPDATE ".CAL_TABLE." SET event_start='$date_start', event_time_set = '$time_set',
			subject='$subject', description='$description', event_end='$date_end',
			bbcode_uid='$bbcode_uid', category='$category', event_access = '$access_level',";

		$last_iteration = ($r_iteration != '0') ? check_end_iteration($r_group_id) : false;

		if ($r_iteration == '0' || $r_iteration == $last_iteration) {
			$sql .= " r_type = '', r_iteration = NULL, r_group_id = '0'";
			}
		else {
			$sql .= " r_type = 'S'";
			}
		$sql .= " WHERE id = '$id'";

		$query = do_query($sql, 'SPLIT_SOLO: Could not update split solo record');
		event_group_update($id, $group_access);	// MOD Event_group

		if ($r_iteration == '0') {
			// We're amending the 1st iteration of the chain, so we need to shift remaining records down.
			solo_update($r_group_id);
		}
		else {
			// Check the last available iteration
			if($r_iteration == $last_iteration) {
				// Set the master record to the date for the last iteration
// MOD 2.0.31 Updated.
// Probably need some more work.
				$sql = "SELECT event_end FROM ".CAL_TABLE." WHERE r_type = 'R' AND r_iteration = ".($r_iteration - 1);
				$query = do_query($sql, 'SPLIT_SOLO: Could not get previous recurring event');
				if($row = $db->sql_fetchrow($query)) {
					$old_r_enddate = $row['event_ed'] + 1;
				}
				$sql = "UPDATE ".CAL_RECUR." SET r_event_stop = '$old_r_enddate' 
					WHERE r_group_id = '$r_group_id'";
				$query = do_query($sql, 'SPLIT_SOLO: Could not update end date in old master record');
			}
		}
	}


//###########################################
// NEW RECURRING EVENT 

//CHECK echo "RN: $r_num, RP: $r_period,  RGRP_ID: $r_group_id,  MOD: $modify,  R_SOLO: $r_solo";

	if ($r_num != '' && $r_period != '' && !isset($r_group_id) && (!$modify || $r_solo == 'solo_del')) 
	{
		// New recurring event: Insert from start to finish.

		if ($r_solo == 'solo_del') {
			// This WAS a solo event but we're starting a new chain with it so delete
			// the old solo record and start a new chain now.

			$sql = "DELETE FROM ".CAL_TABLE." WHERE id = '$id'";
			$query = do_query($sql, 'NEW REC: Could not delete old SOLO tagged record');

			event_group_del($id);	// MOD Event_group
		}

		// NEW Insert Master Record
		$sql = "INSERT INTO ".CAL_RECUR." (r_num, r_period, r_desc, r_subject, 
			r_event_begin, r_event_stop)
			VALUES ('$r_num', '$r_period', '$description', '$subject', 
			'$date_start', '$date_r_stop')";
		$query = do_query($sql, 'NEW REC: Could not insert new recur master event record');

		// Get the r_group_id autoincremented in the last INSERT.
		$new_group_id = $db->sql_nextid();

		// Now add the event records to the Calendar table

		$new_it = 0;

// MOD 2.0.31
		for ($this_date = $date_start; $this_date <= $date_r_stop; $this_date = inc_event_date($r_num, $r_period, $this_date, $recur_type)) {

		// CHECK echo "RN: $r_num, RP: $r_period, TD: $this_date, RT: $recur_type <BR>\n";

			$sql = "INSERT INTO ".CAL_TABLE." (username, user_id, valid, 
					bbcode_uid, event_time_set, event_start, event_end, 
					category, r_group_id, r_iteration, r_type, event_access) 
				VALUES ('$username', '$userid', '$valid',
					'$bbcode_uid', $time_set, '$this_date', '". ($this_date + $event_length) ."',
					'$category', '$new_group_id', '$new_it', 'R', '$access_level')";

			$query = do_query($sql, 'NEW REC: Could not insert recurring event data to calendar table');
			event_group_add(($db->sql_nextid()), $group_access);	// MOD Event_group

			$new_it++;
		}
	}

//###########################################
// Sanity checks

	// Sanity check
	if ($r_select == 'split_future' && $r_iteration == 0) { 
		message_die(DEBUG, 'Split future tag with zero iteration - should be edit_all');
	}
	if ($r_select == 'edit_all' && $r_iteration >= 1) {
		message_die(DEBUG, 'Edit All tag with iteration > 0 - should be split_future');
	}
	if ($r_select && $r_select != 'edit_all' && $r_select != 'split_solo' && $r_select != 'split_future' && $r_select != 'add_notes') {
		message_die(DEBUG, 'Incorrect command being received. Check your cal_options.tpl templates command values');
	}

//###########################################
// SPLIT FUTURE

	if ($r_select == 'split_future') { 
	    // Insert the new master record
		$sql = "INSERT INTO ".CAL_RECUR." (r_num, r_period, r_desc, 
				r_subject, r_event_begin, r_event_stop)
			VALUES ('$r_num', '$r_period', '$description', 
				'$subject', '$date_start', '$date_r_stop');";

		$query = do_query($sql, 'SPLIT_FUTURE: Could not insert new master record');

	    // Get the r_group_id autoincremented in the last INSERT.
		$group_id = $db->sql_nextid($query);

	    // Now update the OLD r_group record: r_event_stop value.
		//CHECK echo "R_IT: $r_iteration";

		if ($r_iteration <= '1') {
			// If we're split_future at the first recurrence then the original event
			// will have no repeats so: Delete the old master record 

			$sql = "SELECT c.id, r.r_desc, r.r_subject, c.subject, c.description 
				FROM ".CAL_TABLE." AS c, ".CAL_RECUR." AS r 
				WHERE c.r_group_id = r.r_group_id
				AND c.r_iteration = '0' AND c.r_group_id = '$r_group_id'";
			$query = do_query($sql, 'SPLIT_FUTURE: Could not select info from defunct master record');
			$row = $db->sql_fetchrow($query);

/* CHECK
	echo "SQL: $sql, ROW: $row, DATA: <BR>\n";
	print_r($row);
	echo "<BR>\n";
*/

			// MOD
			$new_info = defunct_master($r_group_id, $row, 1);

			// Dis-associate event with deleted master record
			$sql = "UPDATE ".CAL_TABLE." SET r_group_id = '0', 
				description = '".$new_info['desc']."', subject = '".$new_info['subject']."', 
				category = '$category', event_access = '$access_level',
				r_type = '', r_iteration = NULL
				WHERE id = ".$row['id'];
			$query = do_query($sql, 'SPLIT_FUTURE: Could not update child events for old master record');
		}
		else {
			// Set the date for the last iteration
			$old_r_enddate = strtotime(("-".$old_rnum." ".$old_rperiod), $old_date_unix);
			$old_r_enddate = dst_check($old_r_enddate, $old_date_unix);

			$sql = "UPDATE ".CAL_RECUR." SET r_event_stop = '$old_r_enddate' 
				WHERE r_group_id = '$r_group_id'";
			$query = do_query($sql, 'SPLIT_FUTURE: Could not update end date in old master record');
		}
	    // Now update the child events to the new master record

	    	// MOD Event_group Update the group_event perms for these child events also.
		// Get event_id's for child events.
		$sql = "SELECT id FROM ".CAL_TABLE." WHERE r_group_id = '$r_group_id' AND r_iteration >= '$r_iteration'";
		$query = do_query($sql, 'SPLIT_FUTURE: Unable to select recurring records affected');
		while($row = $db->sql_fetchrow($query)) {
			$ids[] = $row['id'];
			}
		// Update event_group associations related to events that will also be changed
		event_group_update($ids, $group_access);
		// MOD end

		$sql = "UPDATE ".CAL_TABLE." SET r_group_id = '$group_id', r_iteration = r_iteration-".$r_iteration.", event_access='$access_level'
			WHERE r_group_id = '$r_group_id' AND r_iteration >= '$r_iteration'";
		$query = do_query($sql, 'SPLIT_FUTURE: Could not update future child events');
	}


//###########################################
// EDIT ALL

	if ($r_select == 'edit_all') {

	    	// MOD Event_group Update the group_event perms for all child events also.
		// Get event_id's for child events.
		$sql = "SELECT id FROM ".CAL_TABLE." WHERE r_group_id = '$r_group_id'";
		$query = do_query($sql, 'EDIT_ALL: Unable to select recurring records affected');
		while($row = $db->sql_fetchrow($query)) {
			$ids[] = $row['id'];

			// Update all access levels for records also
			$sql_eg = "UPDATE ".CAL_TABLE." SET event_access = '$access_level'
				WHERE id = ".$row['id'];
			$query_eg = do_query($sql_eg, 'EDIT_ALL: Could not update access level for recurring events');
			}
		// Update event_group associations related to events that will also be changed
		event_group_update($ids, $group_access);
		// MOD end

		$sql = "UPDATE ".CAL_RECUR." SET r_num = '$r_num', r_period = '$r_period',
			r_desc = '$description', r_subject = '$subject', r_event_begin = '$date_start',
			r_event_stop = '$date_r_stop'
			WHERE r_group_id = '$r_group_id'";

		$query = do_query($sql, 'EDIT_ALL: Could not update master event record');

		$group_id = $r_group_id;
		}

//#####################################
// Deal with period and date changes

	if ($r_select == 'edit_all' || $r_select == 'split_future') {

		/*
			If the dates have changed or the repetition period then:
			> the number of child events (repetitions) will change
			> the date when the child events start will also change

			Note: 	If 'Edit_all' then this is iteration=0
				If 'split_future' we've created  new chain already so iteration=0
		*/

		if ($r_num == '') {
			// User has selected to make this a single event and delete all related or future events.
			$sql = "SELECT c.id, r.r_desc, r.r_subject, c.subject, c.description 
				FROM ".CAL_TABLE." AS c, ".CAL_RECUR." AS r 
				WHERE c.r_group_id = r.r_group_id
				AND r_iteration = '0' AND c.r_group_id = '$group_id'";
			$query = do_query($sql, 'SPLIT_FUTURE: Could not select info from defunct master record');
			$row = $db->sql_fetchrow($query);

			// Get rid of the master event as there's no recurring chain left.
			$new_info = defunct_master($r_group_id, $row);

			$sql = "UPDATE ".CAL_TABLE." SET r_iteration=NULL, r_type='', r_group_id='0',
				description = '".$new_info['desc']."', subject = '".$new_info['subject']."',
				category = '$category', event_access = '$access_level'
				WHERE id = ".$row['id'];
			$query = do_query($sql, 'SPLIT_FUTURE: Unable to update event to a single');
		} else {
			$it_count = 0;	// Iteration Count

			//CHECK echo "<BR><BR>DS: $date_start";
			//CHECK echo "<BR>DE: $date_r_stop";

			// Check the last available iteration
			$last_iteration = check_end_iteration($group_id);
			$this_end = $date_end;

// MOD 2.0.31
			for ($this_date = $date_start; $this_date <= $date_r_stop; $this_date = inc_event_date($r_num, $r_period, $this_date, $recur_type)) {
				//CHECK echo "<BR>LastIT: $last_iteration,   ThisIT: $it_count,  THIS_DATE: $this_date";

				if ($it_count <= $last_iteration) {
					// Update current child events
					$sql = "UPDATE ".CAL_TABLE." SET event_start = '$this_date', event_end = '". ($this_date + $event_length) ."', 
						r_iteration = '$it_count', event_time_set = $time_set, category = '$category', event_access='$access_level'
						WHERE r_iteration = '$it_count' AND r_group_id = '$group_id' AND r_type = 'R'";
					}
				else if ($it_count > $last_iteration) {
					// Need to add child events
					$sql = "INSERT INTO ".CAL_TABLE." (username, user_id, valid, bbcode_uid, 
						event_time_set, event_start, event_end, category, r_group_id, r_iteration, r_type, event_access) 
						VALUES ('$username', '$userid', '$valid', '$bbcode_uid',
						$time_set, '$this_date', '". ($this_date + $event_length) ."', '$category', '$group_id', '$it_count', 'R','$access_level')";
					}

				$query = do_query($sql, 'SPLIT_FUTURE: Could not update future child events');

				// MOD Add additional group perms for the new events
				if($it_count > $last_iteration) {
					event_group_add(($db->sql_nextid()), $group_access);
				}
				// MOD end

				$it_count++;
				}
			// MOD Event_group
			// Get event_id's for events soon to be deleted.
			$sql = "SELECT id FROM ".CAL_TABLE." WHERE r_group_id = '$group_id' AND r_iteration >= '$it_count' AND r_type != 'S'";
			$query = do_query($sql, 'SPLIT_FUTURE: Unable to select excess recurring records');
			while($row = $db->sql_fetchrow($query)) {
				$del_ids[] = $row['id'];
			}
			// Delete event_group associations related to the events that will be deleted
			event_group_del($del_ids);
			// MOD end

			// Any child events beyond this point are excess to requirements so we need to delete them
			$sql = "DELETE FROM ".CAL_TABLE." WHERE r_group_id = '$group_id' AND r_iteration >= '$it_count' AND r_type != 'S'";
			$query = do_query($sql, 'SPLIT_FUTURE: Could not delete excess child events');

				// If a solo event drops out of the iteration date range then remove from group
			$sql = "UPDATE ".CAL_TABLE." SET r_type = '', r_iteration = '0', r_group_id = '0' 
				WHERE r_group_id = '$group_id' AND r_iteration >= '$it_count' AND r_type = 'S'";
			$query = do_query($sql, 'SPLIT_FUTURE: Count not disassociate solo event outside of date range from master record');

			}
		}


//###########################################
// RECUR event Description changes 

	if ($r_select == 'add_notes') {
		$sql = "UPDATE ".CAL_TABLE." SET description = '$description', subject = '$subject'
			WHERE id = '$id'";
		$query = do_query($sql, 'ADD NOTES: Could not update relevant event record');
		}

//###########################################
// SUCCESS 

	// MOD Event validation notification
	if ($valid == 'no' && $access_level != 1) {

		if (preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery']) {
			$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';
			// We are running on windows, force delivery to use our smtp functions
			// since php's are broken by default
			$board_config['smtp_delivery'] = 1;
			$board_config['smtp_host'] = @$ini_val('SMTP');
		}

		include_once($cal_file_path . 'includes/emailer.'.$phpEx);
		$emailer = new emailer($board_config['smtp_delivery']);

		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);

		$server_name = trim($board_config['server_name']);
		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';

		$email_headers = 'From: ' . $board_config['board_email'] . "\nReturn-Path: " . $board_config['board_email'] . "\n";

		$subject = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($subject)) : unprepare_message($subject);
		$event_ref = "?id=$insert_id&action=validevent&mode=";

		if($time_set) {
			$cal_config['cal_dateformat'] = $cal_config['cal_dateformat'].' ('.$cal_config['cal_timeformat'].')';
		}
		$starting = mydateformat($date_start, $cal_config['cal_dateformat']);
		$ending = mydateformat($date_end, $cal_config['cal_dateformat']);

		$sql = "SELECT user_id, user_email, user_lang 
			FROM " . USERS_TABLE . " 
  			WHERE user_level = 1 OR user_calendar_perm = 5 ";

		if (!($result = $db->sql_query($sql))) {
			message_die(GENERAL_ERROR, 'Could not select Calendar admins', '', __LINE__, __FILE__, $sql);
		}

		$bcc_list_ary = array();
		do
		{
			if ($row['user_email'] != '') {
				$bcc_list_ary[$row['user_lang']] .= (($bcc_list_ary[$row['user_lang']] != '') ? ', ' : '') . $row['user_email'];
			}
		}
		while ($row = $db->sql_fetchrow($result));

		while (list($user_lang, $bcc_list) = each($bcc_list_ary))
		{
			$emailer->use_template('cal_event_notify', $user_lang);
			$emailer->email_address(' ');
			// The Topic_reply_notification lang string below will be used
			// if for some reason the mail template subject cannot be read
			// ... note it will not necessarily be in the posters own language!
			$emailer->set_subject($lang['Topic_reply_notification']);

			$emailer->extra_headers($email_headers . "Bcc: $bcc_list\n");

			// This is a nasty kludge to remove the username var ... till (if?)
			// translators update their templates
			$emailer->msg = preg_replace('#[ ]?{USERNAME}#', '', $emailer->msg);
  
			$emailer->assign_vars(array(
				'SITENAME' => $board_config['sitename'],
				'SUBJECT' => $subject, 
				'STARTS' => $starting,
				'ENDS' => $ending,
				"POST_TEXT" => (substr($description, 0, 250). "..."), 
				"POSTERNAME" => $userdata['username'], 
				"U_MAIN" => $server_protocol . $server_name . $server_port . $board_config['script_path'] . 'cal_validate.'.$phpEx,
				"U_VALIDATE" => $server_protocol . $server_name . $server_port . $board_config['script_path'] . "cal_validate.".$phpEx . $event_ref . 'val',
				"U_DENY" => $server_protocol . $server_name . $server_port . $board_config['script_path'] . "cal_validate.".$phpEx . $event_ref . 'del',
				)
			);
			$emailer->send();
			$emailer->reset();
		}
	}
	// MOD end

	// Success the event is now pending or actually added.

	// Temp measure until the language files all get updated.
	$lang['Cal_add4valid'] = (!empty($lang['Cal_add4valid'])) ? $lang['Cal_add4valid'] : 'Event submitted for validation by an Administrator';

	$l_add = ($valid != 'no') ? $lang['Cal_event_add'] : $lang['Cal_add4valid'];
	
	$urladd = append_sid('cal_add.'.$phpEx.'?month='.$month.'&year='.$year, 1);
	$message = $l_add. "</br></br>
		<a href='".$urladd."'>".$lang['Cal_add_event']."</a><br>
		<a href='".$home_this_month."'>".$lang['Cal_back2cal'].'</a>';
	message_die(GENERAL_MESSAGE, $message);
}
else {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}

include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
exit;
?>