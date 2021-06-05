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
$session_loc = CAL_DELETE;

require_once('cal_main.php');
include ($cal_file_path . 'includes/page_header.'.$phpEx);

if($caluser >= 4) {
	if (!$id) {
		message_die(GENERAL_ERROR, $lang['Cal_must_sel_event']);
	}

	if(!$r_group_id) { 
		$r_group_id = '0'; 
	}

	// First select the record(s) information

	$sql = "SELECT * FROM ".CAL_TABLE." WHERE id = '$id'";

	if ($caluser < 5) { 
		$sql .= " AND user_id = '".$userdata['user_id']."'"; 
	}
	$query = do_query($sql, 'Could not select event to delete from Table');

	$row = $db->sql_fetchrow($query);

	$r_group_id = $row['r_group_id'];
	$r_iteration = $row['r_iteration'];


	// Setup Appropriate SQL to delete the records.
	if (!$ed_option && $row['id'] != '') {
		$sql_del = "SELECT id FROM ".CAL_TABLE." WHERE id = '$id'";
		del_array($sql_del, 'DEL FUTURE: Could not Delete defunct group_events for single event');

		$sql = "DELETE FROM ".CAL_TABLE." WHERE id = '$id'";
		$query = do_query($sql, 'SINGLE: Could not delete event');
	}
	else if ($ed_option == 'edit_all') {
		// MOD
		defunct_master($r_group_id, array());
/*
		// Remove all related (non-solo) event records 
		$sql =  "DELETE FROM ".CAL_TABLE." WHERE r_group_id = '$r_group_id' AND r_type != 'S' AND r_type != ''";
		$query = do_query($sql, 'ALL: Could Not delete all non-solo recurring events');

		$sql = "DELETE FROM ".CAL_RECUR." WHERE r_group_id = '$r_group_id' AND r_group_id != '0'";
		$query = do_query($sql, 'ALL: Could Not delete master event');

		// Now update the solo records to remove any references to the now dead recurring master event.
		$sql = "UPDATE ".CAL_TABLE." SET r_group_id='0', r_type='' WHERE r_group_id = '$r_group_id' AND r_type = 'S'";
		$query = do_query($sql, 'ALL: Could Not update remaining solo events');
*/

	}
	else if ($ed_option == 'split_future') {
		// Remove all related (non-solo) event records 
		$sql_del = "SELECT id FROM ".CAL_TABLE." 
			WHERE r_group_id = '$r_group_id' AND r_type != 'S' AND r_iteration >= '$r_iteration' AND r_group_id != '0'";
		del_array($sql_del, 'DEL FUTURE: Could not Delete defunct future group_events ');

		$sql = "DELETE FROM ".CAL_TABLE." WHERE r_group_id = '$r_group_id' AND r_type != 'S' AND r_iteration >= '$r_iteration' AND r_group_id != '0'";
		$query = do_query($sql, 'DEL FUTURE: Could Not delete all future recurring events');

		// If there will only be 1 iteration left, then there's no repeats so delete the master record
		if ($r_iteration == '1') {
			$sql = "SELECT r.r_desc, r.r_subject, c.subject, c.description 
				FROM ".CAL_TABLE." AS c, ".CAL_RECUR." AS r 
				WHERE c.r_group_id = r.r_group_id
				AND r_iteration = '0' AND c.r_group_id = '$r_group_id'";
			$query = do_query($sql, 'SPLIT_FUTURE: Could not select info from defunct master record');
			$row = $db->sql_fetchrow($query);

// MOD
			$new_info = defunct_master($r_group_id, $row);

/* DEAD ?
			if ($row['r_subject'] && $row['subject']) {
				$new_subject = $row['r_subject'].' : '.$row['subject'];
			}
			else if ($row['r_subject']) {
				$new_subject = $row['r_subject'];
			}
			else {
				$new_subject = $row['subject'];
			}

			if ($row['r_desc'] && $row['description']) {
				$new_desc = $row['r_desc']. '<br /><br />----------<br />' .$row['description'];
			}
			else if ($row['r_desc']) {
				$new_desc = $row['r_desc'];
			}
			else {
				$new_desc = $row['description'];
			}

			$sql = "DELETE FROM ".CAL_RECUR." WHERE r_group_id = '$r_group_id' AND r_group_id != '0' ";
			$query = do_query($sql, 'SPLIT_FUTURE: Could not delete defunct recur info master record');

			$sql = "UPDATE ".CAL_TABLE." SET r_group_id = '0', description = '$new_desc', subject = '$new_subject', 
				r_type = '', r_iteration = NULL
				WHERE r_group_id = '$r_group_id' AND r_iteration = '0';";
*/
			$sql = "UPDATE ".CAL_TABLE." SET r_group_id = '0', 
				description = '".$new_info['desc']."', subject = '".$new_info['subject']."',
				category = '$category', event_access = '$access_level', 
				r_type = '', r_iteration = NULL
				WHERE r_group_id = '$r_group_id' AND r_iteration = '0';";
// MOD end
			$query = do_query($sql, 'DEL FUTURE: Could Not update remaining solo events');
			}
		else {
			// Update the Master record
			$new_date_nix = $row['event_start'] - 86400; 

			// Set the stop of recur group date to 1 day before the deleted event.
			$sql =  "UPDATE ".CAL_RECUR." SET r_event_stop = '$new_date_nix' WHERE r_group_id = '$r_group_id'";
			$query = do_query($sql, 'DEL FUTURE: Could Not update the master event');

			// Update solo records beyond the start point to removed ref's to master event.
			$sql = "UPDATE ".CAL_TABLE." SET r_group_id='0', r_type='', r_iteration=NULL WHERE r_group_id='$r_group_id' AND r_type = 'S' AND r_iteration >= '$r_iteration';";
			$query = do_query($sql, 'DEL FUTURE: Could Not update remaining solo events (2)');
		}
	}
	else if ($ed_option == 'split_solo') {
		// Remove this particular record

		if ($r_iteration == '0') {
			// We're deleting the 1st iteration of the chain so delete it, then shift remaining records down.
			$sql_del = "SELECT id FROM ".CAL_TABLE." WHERE id = '$id'";
			del_array($sql_del, 'DEL SOLO: Could not Delete defunct group_events for first iteration');

			$sql = "DELETE FROM ".CAL_TABLE." WHERE id = '$id'";
			$query = do_query($sql, 'DEL SOLO: Could not Delete first iteration');

			solo_update($r_group_id);
			// NOTE: Function stored in cal_functions.php
		}
		else {
			unset($row);

			// Is there an event in the chain following this one.
			$sql =  "SELECT * FROM ".CAL_TABLE." WHERE r_iteration > '$r_iteration' AND r_group_id = '$r_group_id'
				AND r_type != 'D' AND r_type != 'S' ORDER BY r_iteration ASC";
			$query = do_query($sql, 'DEL SOLO: Could Not select following event in same chain');

			// Get the preceding records date
			$row = $db->sql_fetchrow($query);
			if (!$row['event_start']) {
				// The current iteration is the last date in the chain (no following events found)

				// So check for preceding rows back 1 and 2 from this row.
				$sql =  "SELECT * FROM ".CAL_TABLE." WHERE r_iteration < '$r_iteration' AND r_group_id = '$r_group_id'
					AND r_type != 'D' AND r_type != 'S' ORDER BY r_iteration DESC";

				$query = do_query($sql, 'DEL SOLO: Could Not select preceding event in same chain');	
				$row_back1 = $db->sql_fetchrow($query);
				$row_back2 = $db->sql_fetchrow($query);	// Checks for more than just 1 iteration left before it

				if(!$row_back1['event_start']) {
					// No preceding row (already know there's no following events)
					// There's no valid events anywhere in the chain so let's kill it and non 'S' tagged records in it.

					// MOD
					defunct_master($r_group_id, array());
/*
					$sql_del = "DELETE FROM ".CAL_TABLE." 
						WHERE r_group_id = '$r_group_id' AND r_type != 'S'";
					$query = do_query($sql_del, 'DEL SOLO: Could Not delete ALL events in chain (not solo)');

					$sql_del = "DELETE FROM ".CAL_RECUR." WHERE r_group_id = '$r_group_id'";
					$query = do_query($sql_del, 'DEL SOLO: Could Not delete master event record');

					// Update any remaining SOLO events to singles.
					$sql = "UPDATE ".CAL_TABLE." SET r_group_id='0', r_type='', r_iteration=NULL WHERE r_group_id='$r_group_id' AND r_type = 'S'";
					$query = do_query($sql, 'DEL SOLO: Could Not update remaining solo events');
*/
				}
				else if (!$row_back2['event_start']) {

					$sql = "SELECT r_subject, r_desc
						FROM ".CAL_RECUR." 
						WHERE r_group_id = '$r_group_id'";
					$query = do_query($sql, 'SPLIT_FUTURE: Could not select info from original event record');

					$row = $db->sql_fetchrow($query);
					$row['subject'] = $row_back1['subject'];
					$row['description'] = $row_back1['description'];
					$row['id'] = $row_back1['id'];

					// MOD
					$new_info = defunct_master($r_group_id, $row);

/* DEAD ?
					if ($row['r_subject'] && ) {
						$new_subject = $row['r_subject'].' : '.$row_back1['subject'];
						}
					else if ($row['r_subject']) {
						$new_subject = $row['r_subject'];
						}
					else {
						$new_subject = $row_back1['subject'];
						}

					if ($row['r_desc'] && $row_back1['description']) {
						$new_desc = $row['r_desc']. '<br /><br />----------<br />' .$row_back1['description'];
						}
					else if ($row['r_desc']) {
						$new_desc = $row['r_desc'];
						}
					else {
						$new_desc = $row_back1['description'];
						}
					// There's ONE event preceding left. So delete the recur info
					$sql_del = "DELETE FROM ".CAL_RECUR." WHERE r_group_id = '$r_group_id'";
					$query = do_query($sql_del, 'DEL SOLO: Could Not delete all D tagged events in chain');

					// Update any remaining SOLO events to singles.
					$sql = "UPDATE ".CAL_TABLE." SET r_group_id='0', r_type='', r_iteration=NULL WHERE r_group_id='$r_group_id' AND r_type = 'S'";
					$query = do_query($sql, 'DEL SOLO: Could Not update remaining solo events');

					// Delete the event that's supposed to get dumped
					$sql_del = "DELETE FROM ".CAL_TABLE." WHERE r_group_id = '$r_group_id'";
					//CHECK echo "<BR>SQLDEL: $sql_del";
					$query = do_query($sql_del, 'DEL SOLO: Could Not delete the event');

					// Update any remaining events to singles.
					$sql = "UPDATE ".CAL_TABLE." SET r_group_id='0', r_type='', r_iteration=NULL, 
						description = '$new_desc', subject = '$new_subject' 
						WHERE id='". $row_back1['id'] ."'";
*/
					// Update any remaining events to singles.
					$sql = "UPDATE ".CAL_TABLE." SET r_group_id = '0', 
						description = '".$new_info['desc']."', subject = '".$new_info['subject']."', 
						category = '$category', event_access = '$access_level',
						r_type = '', r_iteration = NULL
						WHERE id=".$row_back1['id'];
					$query = do_query($sql, 'DEL SOLO: Could Not update remaining event');
				}
				else {
					// There IS a valid preceding event so update the master record to show the preceding events start date.
					$new_date = $row_back1['event_start'];

					// UPDATE the master with the new date
					$sql =  "UPDATE ".CAL_RECUR." SET r_event_stop = '$new_date' WHERE r_group_id = '$r_group_id'";
					$query = do_query($sql, 'DEL SOLO: Could not Update Master after end event deleted');

					$sql_del = "SELECT id FROM ".CAL_TABLE." WHERE r_iteration > '". $row_back1['r_iteration'] ."' 
						AND r_group_id = '$r_group_id' AND r_type != 'S'";
					del_array($sql_del, 'DEL SOLO: Could not Delete defunct group_events from chain end');

					$sql = "DELETE FROM ".CAL_TABLE." WHERE r_iteration > '". $row_back1['r_iteration'] ."' 
						AND r_group_id = '$r_group_id' AND r_type != 'S'";
					$query = do_query($sql, 'DEL SOLO: Could not Delete defunct events from chain end');
				}
			}
			else {
				// This event is > 0 and less than last in chain so just D tag it.
				$sql_del = "SELECT id FROM ".CAL_TABLE." WHERE r_iteration = '$r_iteration' AND r_group_id = '$r_group_id'";
				$query = do_query($sql_del, 'DEL SOLO: Could not Delete defunct group_events for D tagged event');
				$row = $db->sql_fetchrow($query);
				event_group_del($row['id']);

				$sql = "UPDATE ".CAL_TABLE." SET r_type='D' WHERE id = ".$row['id'];
				$query = do_query($sql, 'DEL SOLO: Could Not D tag the deleted event');
			}
		}
	}
	else {
		message_die(GENERAL_ERROR, 'Could Not delete event from Table');
	}


	$message = $lang['Cal_event_delete']. "<br><br><a href='".$home_this_month."'>".$lang['Cal_back2cal'].'</a>';
	message_die(GENERAL_MESSAGE, $message, '', __LINE__, __FILE__, $sql);
}
else
{
	// Failed
	message_die(GENERAL_ERROR, $lang['Cal_delete_event']);
}

include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
exit;


?>