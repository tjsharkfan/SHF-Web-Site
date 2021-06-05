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
$session_loc = CAL_VALIDATE;

require_once('cal_main.php');
include_once($cal_file_path . 'includes/bbcode.'.$phpEx);

// Start of MOD function (validate untrusted events)

// Set new language field if required
$lang['no_action'] = isset($lang['no_action']) ? $lang['no_action'] : 'No action selected';


if ($userdata['session_logged_in'] && $caluser >= 5) {
	switch ($action) {
		case "validevent":
          	// Validate the selected events.
          	if ((is_array($validate_id) && count($validate_id) <= 0) || empty($validate_id)) {
				message_die(GENERAL_MESSAGE, $lang['Cal_must_sel_event'], '', __LINE__, __FILE__, '');
			}

           	// $validate_id can be an array of items for validation or a single event
			// Array for form submission.
			// Single event from email link
			if(is_array($validate_id)) {
        	  	foreach($validate_id AS $thisid => $value) {
					if ($value=='yes') {
						$sql = "UPDATE ".CAL_TABLE." SET valid = 'yes' WHERE id = '$thisid'";
					}
					elseif ($value=='del')
						{
						$sql = "DELETE FROM ".CAL_TABLE." WHERE id = '$thisid'";
					}
					else {
						continue;
					}
					if ( !($query = $db->sql_query($sql)) ) {
						message_die(GENERAL_ERROR, 'Could not validate events', '', __LINE__, __FILE__, $sql);
					}
			   		else {
			   			$message = $lang['Cal_event_validated'];
					}
				}
				$message = (isset($message)) ? $message : $lang['no_action'];
			}
			else {
				if ($mode =='val') {
					$sql = "UPDATE ".CAL_TABLE." SET valid = 'yes' WHERE id = '$validate_id'";
				}
				elseif ($mode =='del') {
					$sql = "DELETE FROM ".CAL_TABLE." WHERE id = '$validate_id'";
				}
				else {
					message_die(GENERAL_MESSAGE, 'No mode provided', '', __LINE__, __FILE__, '');
				}
				if ( !($query = $db->sql_query($sql)) ) {
					message_die(GENERAL_ERROR, 'Could not validate events', '', __LINE__, __FILE__, $sql);
				}
			   	else {
		   			$message = $lang['Cal_event_validated'];
				}
			}
	
			$message .= "<br /><br /><a href='".$home_this_month."'>".$lang['Cal_back2cal'].'</a>';
			message_die(GENERAL_MESSAGE, $message, '', __LINE__, __FILE__, '');

			// end of case
			//exit;
			break;


		default:
			// Get the list of events waiting to be validated and display them for selection

			include ($cal_file_path . 'includes/page_header.'.$phpEx);

			$sql = "SELECT * FROM ".CAL_TABLE." WHERE valid='no' ORDER BY event_start";
			if ( !($query = $db->sql_query($sql)) ) {
				message_die(GENERAL_ERROR, 'Could not get events list to validate', '', __LINE__, __FILE__, $sql);
				}

			$template->set_filenames(array(
				'body' => 'cal_validate_events.tpl')
				);

			$template->assign_vars(array(
				'VALIDATE' => $lang['Validate'],
				'SELECT' => $lang['Select'],
				'SUBJECT' => $lang['Subject'],
				'CATEGORY' => ' - '.$lang['category'],
				'DATE' => $lang['Date'],
				'END_DATE' => $lang['End_day'],
				'AUTHOR' => $lang['Username'],
				'BUTTON_HOME' => button_main($home_this_month, $lang['Cal_back2cal'], 'center'))
				);

			$template->assign_vars(array(
				'PHPBBHEADER' => $phpbbheaders,
				'CAL_VERSION' => 'Ver: '.$cal_config['version'],
				'CALENDAR' => $lang['Calendar'],
				'L_CAL_NEW' => $lang['Cal_add_event'],
				'U_INDEX' => append_sid("index.$phpEx", 1),
				'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
				'U_CAL_HOME' => $homeurl)
				);
			$i = 0;
			while ($row = $db->sql_fetchrow($query))
				{
				$options = '<select name=validate_id['.$row['id'].']>
					<option value=\'hold\' SELECTED>Hold</option>
					<option value=\'yes\'>Accept</option>
					<option value=\'del\'>Deny</option>
					</select>';

			   	$zdesc  = stripslashes($row['description']);
		   	   	$bbcode_uid = $row['bbcode_uid'];
				if( $board_config['allow_bbcode'] ) {
					$zdesc = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($zdesc, $bbcode_uid) : preg_replace("/\:[0-9a-z\:]+\]/si", "]", $zdesc);
					}
				if ( $board_config['allow_smilies'] )
					{
					$zdesc = smilies_pass($zdesc);
					}
			   	$zsujet = stripslashes($row['subject']);
			   	$category = stripslashes($row[category]);

				$start_date = mydateformat($row['event_start'], $cal_config['cal_dateformat']);
				$end_date = mydateformat($row['event_end'], $cal_config['cal_dateformat']);

	// DEV 2.0.25 - Start time or both option.
				if($row['event_time_set'] && $cal_config['cal_timeformat']) {
					$event_time_start = '('.mydateformat($row['event_start'], $cal_config['cal_timeformat']).')';
					if($row['event_time_set'] == 1) {
						$event_time_end = '('.mydateformat($row['event_end'], $cal_config['cal_timeformat']).')';
					}
				}
	// End DEV.

				$template->assign_block_vars('event_row', array(
					'SELECT' => $options,
					'SUBJECT' => $zsujet,
					'CATEGORY' => $category,
					'DATE' => $start_date,
					'TIME' => $event_time_start,
					'END_DATE' => $end_date,
					'END_TIME' => $event_time_end,
					'AUTHOR' => stripslashes($row[username]),
					'DESC' => $zdesc)
					);
				$i++;
				}
			if($i == 0)
				{
				$template->assign_block_vars('no_events', array(
					'NO_EVENTS' => $lang['No records'])
					);
				$submit_button = '';
				}
			else {
				$submit_button = "<input type='submit' accesskey='s' tabindex='6' name='post' class='mainoption' value='".$lang['Submit']."' />";
				}
			$template->assign_vars(array(
				'SUBMIT' => $submit_button)
				);
			$template->pparse('body');
			include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
			break;
		}
	}
else {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
	}
exit;
?>