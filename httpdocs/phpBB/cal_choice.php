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
$session_loc = CAL_DEFAULT;

require_once('cal_main.php');

if ($mode == 'edit') {
	$title = $lang['Cal_mod_marked'];
	$action = 'cal_modify.'.$phpEx;
	$add = $lang['Add notes'];
	$all = $lang['Edit all'];
	$split_solo = $lang['Split solo'];
	$future = $lang['Split future'];
	}
elseif ($mode == 'del') {
	$title = $lang['Cal_del_marked'];
	$action = 'cal_delete.'.$phpEx;
	$future = $lang['Del future'];
	$all = $lang['Del all'];
	$split_solo = $lang['Del this'];
	}
else {
	message_die(GENERAL_ERROR, 'hack attempt - no action selected');
	}
if (!$id) {
	message_die(GENERAL_ERROR, 'hack attempt - no event selected');
	}

// Home Button
$month = create_date('n', time(), $userdata[user_timezone]);
$year = create_date('Y', time(), $userdata[user_timezone]);

$button_home = button_main($home_this_month, $lang['Cal_back2cal'], 'center');

$sql = "SELECT r_type, r_iteration, r_group_id FROM ".CAL_TABLE." WHERE valid = 'yes' AND id = '$id'";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not select Event data');
}
$row_choice = $db->sql_fetchrow($result);

if ($row_choice[r_type] == '' || $row_choice[r_type] == 'S') {
	// We're not dealing with a recurring event so we can skip to the point.
	$url = append_sid("$action?id=$id",1);
	Header("Location:$url");
	}

include ($cal_file_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'cal_options.tpl')
);

if ($row_choice[r_iteration] >= '1' && $row_choice[r_type] == 'R') {
	$template->assign_block_vars('future', array(
		'SPLIT_FUTURE' => $future)
		);
	}
if (isset($add)) {
	$template->assign_block_vars('add', array(
		'ADD_NOTES' => $add)
		);
	}

$hidden_fields = "<input type='hidden' name='id' value='$id'>
	<input type='hidden' name='r_group_id' value='". $row_choice[r_group_id] ."'>\n";

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
	'EDIT_ALL' => $all,
	'SPLIT_SOLO' => $split_solo,
	'S_HIDDEN_FORM_FIELDS' => $hidden_fields,
	'EDIT_OR_DELETE' => $title,
	'S_POST_ACTION' => append_sid($action),
	'BUTTON_HOME' => $button_home, 
	'L_SUBMIT' => $lang['Submit'])
	);
$template->pparse('body');

include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
exit;
?>