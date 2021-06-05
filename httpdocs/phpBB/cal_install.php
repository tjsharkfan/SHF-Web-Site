<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-04-30 19:02:35 +0100 (Sat, 30 Apr 2005) $
*	$Revision: 76 $
*
*********************************************/

/*#################################################
##
##	Installation/Update Script for Calendar Pro
##
##	Copyright (c)   Martin Smallridge (2005)
##	Assistance:	Jimmy Granese (MSSQL routines)
##	Support:	http://www.snailsource.com
##
#################################################*/

// Security Check
if ( isset($HTTP_GET_VARS['caluser']) || isset($HTTP_POST_VARS['caluser']) || isset($caluser)) {
	// Failed the test... Someone tried to spoof as a user.
}
else if ( isset($HTTP_GET_VARS['userdata']) || isset($HTTP_POST_VARS['userdata']) || isset($userdata)) {
	// Failed the test... Someone tried to spoof as a user.
}
else {
	// Passed.
	define('IN_PHPBB', true);
}


/*######################
Information/vars you have to hand...

$dbms => the database schema we're using... (mysql, mysql4, postgres, mssql, msaccess, mssql-odbc)
$table_prefix => the table prefix used for the tables.

######################*/

$currentver = '2.0.38';

// Remember to update with old versions as new ones come out.
$old_versions = array(
		'1.2.2', 
		'1.4.1', '1.4.2', '1.4.3', '1.4.4', '1.4.5', '1.4.x',
		'2.0.1', '2.0.2', '2.0.3', '2.0.33', '2.0.34', '2.0.35', '2.0.36', '2.0.37'
	);

$filename = basename(__FILE__);
$cal_file_path = realpath('./').'/';

$language = 'english';


//############################
// Start phpBB Session

require_once($cal_file_path . 'extension.inc');
require_once($cal_file_path . 'config.'.$phpEx);
require_once($cal_file_path . 'common.'.$phpEx);
require_once($cal_file_path . 'includes/functions.'.$phpEx);
require_once($cal_file_path . 'includes/functions_selects.'.$phpEx);
require_once($cal_file_path . 'includes/sql_parse.'.$phpEx);

require_once($cal_file_path . 'cal_settings.'.$phpEx);	// Variables that users can change (tablenames, etc..)
require_once($cal_file_path . 'cal_install/cal_convert_fn.'.$phpEx);	// Functions & variables needed to complete the installation
require_once($cal_file_path . 'cal_constants.inc');		// Required for session start

if(!defined("CAL_INSTALL")) {
	$error = 'Constants aren\'t defined. Probably missing cal_constants.inc file';
	cal_update_err($error);
}

$userdata = session_pagestart($user_ip, CAL_INSTALL, $session_length);
init_userprefs($userdata);

require($cal_file_path.'language/lang_' . $language . '/lang_main.'.$phpEx);
require($cal_file_path.'language/lang_' . $language . '/lang_admin.'.$phpEx);
require($cal_file_path.'language/lang_' . $language . '/lang_calendar.'.$phpEx);

//############################
// Setup templates for display

$template->set_filenames(array(
	"body" => "cal_install.tpl")
	);
$template->assign_vars(array(
	"L_INSTALLATION" => 'Calendar Pro Installation',
	"S_FORM_ACTION" => $filename)
	);

//############################
// Ensure Admin only runs this

// If register_globals get user to login.
if(!$userdata['session_logged_in']) {
	header('Location:login.'.$phpEx.'?redirect='.$filename);
}
// Logged in and not the Admin... Go Away
if($userdata['user_level'] != ADMIN) {
	$error = $lang['Not_Authorised'];
	cal_update_err($error);
}

//###########################
// What are we doing?

if(!isset($HTTP_POST_VARS['install_action'])) {
	thisdefault();
}
else if ($HTTP_POST_VARS['install_action'] == 0) {
	$ver = test_cal();
	if($ver == '') {
		install();
	}
	elseif ($ver == 'empty') {
		$error = "<b>You appear to have an empty calendar installed.</b><br /><br /> 
			Recommend you wipe your existing Calendar DB tables and install fresh";
		cal_update_err($error);
	}
	elseif ($ver == $currentver) {
		$error = '<b>You already appear to have the latest calendar installed.</b><br /><br />';
		cal_update_err($error);
	}
	else {
		$error = "<b>A version of Calendar is already installed.</b><br /><br /> 
			Recommend you choose 'upgrade' instead ";
		cal_update_err($error);
	}
}
else if ($HTTP_POST_VARS['install_action'] == 1){
	$ver = test_cal();

	foreach($old_versions AS $old_ver) {
		if($old_ver == $ver) {
			upgrade($ver);
			exit;
		}
	}
	if ($ver == $currentver) {

		// Fix updates that weren't applied in some upgrades.
		$sql = "INSERT INTO ".CAL_CONFIG." VALUES ('require_time', 0)"; 	// 2.0.33
		$query = @$db->sql_query($sql);
		$sql = "INSERT INTO ".CAL_CONFIG." VALUES ('admin_private_view', 1)";
		$query = @$db->sql_query($sql);

		$error = '<b>You already appear to have the latest calendar installed.</b><br /><br />';
		cal_update_err($error);
	}
	elseif ($ver == 'empty') {
		$error = "<b>You appear to have an empty calendar installed.</b><br /><br /> 
			Recommend you wipe your existing SQL tables and install from scratch";
		cal_update_err($error);
	}
	else {
		$error = "<b>You don't appear to have a valid calendar version installed.</b><br /><br /> 
			Recommend you wipe your existing SQL tables and install from scratch";
		cal_update_err($error);
	}
}
else {
	thisdefault();
}
exit;

//#####################
// Functions Start

function thisdefault() {
	global $template, $lang, $HTTP_GET_VARS;
	// Display the form for any user selections :)
	$lang_options = language_select($language, 'language');


	$upgrade_option = '<select name="install_action">';
	$upgrade_option .= '<option value="0">' . $lang['Install'] . '</option>';
	$upgrade_option .= '<option value="1">' . $lang['Upgrade'] . '</option></select>';
	
	$s_hidden_fields = "<input type='hidden' name='install_step' value='1' />\n<input type='hidden' name='sid' value='".$HTTP_GET_VARS['sid']."'>";

	$instruction_text = 'Please choose whether you wish to install or upgrade Calendar. <br /><br />
		<span class="genmed">NB: This script will check for pre-existing versions of Calendar and advise you (if necessary) 
		whether you can continue with an installation/upgrade.<br />
		If you experience any problems then please visit the Calendar Pro forums at 
		<a href="http://www.snailsource.com/forum/" class="nav">Snailsource.com</a></span>';

	$template->assign_block_vars('switch_stage_one_install', array());
	$template->assign_block_vars('switch_common_install', array());

	$template->assign_vars(array(
		"L_INSTRUCTION_TEXT" => $instruction_text,
		"L_INITIAL_CONFIGURATION" => $lang['Initial_config'], 
		"L_LANGUAGE" => $lang['Default_lang'], 
		"L_UPGRADE" => $lang['Install_Method'],
		"L_SUBMIT" => $lang['Start_Install'], 
		
		"S_LANG_SELECT" => $lang_options, 
		"S_HIDDEN_FIELDS" => $s_hidden_fields,
		"S_UPGRADE_SELECT" => $upgrade_option)
	);
	$template->pparse('body');
	exit;
}


//#####################
// Install Clean

function install() {
	global $db, $template, $lang, $dbms, $available_dbms, $currentver;
	$dbms_schema = './cal_install/schema/' . $available_dbms[$dbms]['SCHEMA'] . '_schema.sql';
	$dbms_basic = './cal_install/schema/' . $available_dbms[$dbms]['SCHEMA'] . '_inserts.sql';

    if( $available_dbms[$dbms]['SCHEMA'] != 'mysql' && $available_dbms[$dbms]['SCHEMA'] != 'mssql' ) {
		$error = "<b>Sorry, only MySQL & MSSQL are currently supported.</b><br /><br /> 
			However additional DBMS support will hopefully be available shortly";
		cal_update_err($error);
	}

	if( $available_dbms[$dbms]['SCHEMA'] != 'msaccess' ) {

		// Ok we have the db info go ahead and read in the relevant schema
		//
		install_sql($dbms_schema);
		
		// Ok tables have been built, let's fill in the basic information
		//
		install_sql($dbms_basic);

		// Add permission fields to user and usergroup tables
	        switch( $dbms )
        	{
			case 'mysql':
			case 'mysql4':
				$inserts[] = 'ALTER TABLE '.GROUPS_TABLE.' ADD group_calendar_perm TINYINT(1) UNSIGNED DEFAULT "0" NOT NULL';
				$inserts[] = 'ALTER TABLE '.USERS_TABLE.' ADD user_calendar_perm TINYINT(1) UNSIGNED DEFAULT "0" NOT NULL';
				break;

			case 'mssql-odbc':
			case 'mssql':

				$inserts[] = 'ALTER TABLE '.GROUPS_TABLE.' ADD group_calendar_perm tinyint NOT NULL CONSTRAINT [DF_" . $table_prefix . "groups_group_calendar_perm] DEFAULT (0) ';

				$inserts[] = 'ALTER TABLE '.USERS_TABLE.' ADD user_calendar_perm tinyint NOT NULL CONSTRAINT [DF_" . $table_prefix . "users_user_calendar_perm] DEFAULT (0) ';
				break;
		}
		// Insert version number
		$inserts[] = "INSERT INTO ".CAL_CONFIG." (config_name, config_value) VALUES ('version', '$currentver')";
		$inserts[] = 'INSERT INTO '. CAL_TABLE ." (username, subject, description, user_id, valid, event_start, event_end) VALUES ('test', 'CalPro Installed', 'This is just a test event to prove it works. <br /><br />Delete as required :)',-1 , 'yes', ". (time()+i_mytime()) .", ". (time()+i_mytime()+3600) .")";

		$report = 'Add version number and Test event to calendar:<br /><br />';
		$report = go_sql($inserts, $report);
		$report .= '<br /><br />';

	}
	// Success..
	$template->assign_block_vars('switch_success_install', array());

	$report .= 'Congratulations, you have successfully installed <b>Calendar Pro</b>.<br /><br />
		If you have any questions, need documentation, or just want to catch up on new releases for CalPro then please
		visit Snailsource at <br /><br /><a href="http://www.snailsource.com/" class="nav">http://www.snailsource.com/</a>
		<br /><br /><center><img src="http://www.snailsource.com/files/'.$currentver.'__2.jpeg"></center>';

	$template->assign_vars(array(
		"L_INSTRUCTION_TEXT" => '',
		"L_SUCCESS_TITLE" => '** Success **',
		"L_MESSAGE" => $report)
	);

	$template->pparse('body');
	exit;
}


//#####################
// Upgrade Existing

function upgrade($ver) {
	global $db, $template, $lang, $dbms, $available_dbms, $currentver;
	// Upgrade older versions of Calendar to the latest.

	$report = 'Commencing Upgrade for Calendar Version: ';

	$report .= $ver . '<br/><br />';

	$col_inserts = array();
	$inserts = array();
	$convert = array();
	$drops = array();


	//
	//------------------------------------------------------
	// Install any tables that need to be put in position

	$dbms_table = array();

	switch($ver) {
		case '1.2.2':
			// Install tables
			$dbms_table['schema'] .= './cal_install/schema/' . $available_dbms[$dbms]['SCHEMA'].'_122_ud_schema.sql';
			$dbms_table['data'] .= './cal_install/schema/' . $available_dbms[$dbms]['SCHEMA'].'_inserts.sql';
			break;

		case '1.4.x':
			$dbms_table['schema'] .= './cal_install/schema/' . $available_dbms[$dbms]['SCHEMA'].'_141_ud_schema.sql';
			break;

		case '2.0.1':
		case '2.0.2':
			// Install the Cal_group_event table
			$dbms_table['schema'] .= './cal_install/schema/' . $available_dbms[$dbms]['SCHEMA'].'_202_ud_schema.sql';
			break;

		case '2.0.3':
		case '2.0.33':
		case '2.0.34':
		case '2.0.35':
		case '2.0.36':
		case '2.0.37':
			// Nothing doing
			$dbms_table = array();
			break;

		default:
			$error = "<b>HALT! Version number not recognised during upgrade.</b><br/>[Ver: $ver ]";
			cal_update_err($error);
			exit;
	}

	if(isset($dbms_table['schema'])) {
		$report = install_table($dbms_table['schema'], $report);
	}
	if(isset($dbms_table['data'])) {
		$report = install_table($dbms_table['data'], $report);
	}


	//
	//------------------------------------------------------
	// Handle column inserts as required.

	switch($ver) {

		case '1.2.2':
			$col_inserts[] = 'ALTER TABLE '.GROUPS_TABLE.' ADD group_calendar_perm TINYINT(1) UNSIGNED DEFAULT "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.USERS_TABLE.' ADD user_calendar_perm TINYINT(1) UNSIGNED DEFAULT "0" NOT NULL';

		case '1.4.x':
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' CHANGE `description` `description` TEXT DEFAULT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_start int(10) unsigned DEFAULT "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_end int(10) unsigned DEFAULT "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_time_set tinyint(1) unsigned default "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD category int(10) unsigned';					// FIX!
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD r_iteration int(10) unsigned default NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD r_group_id int(10) unsigned default "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD r_type char(1) NOT NULL default ""';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_access tinyint(1) unsigned DEFAULT "0" NOT NULL';	// 2.0.3

			// add keys	event_start_idx	, event_end_idx
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD INDEX event_date_idx (event_start)';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD INDEX event_end_idx (event_end)';
			break;

		case '2.0.1':
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_start int(10) unsigned DEFAULT "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_end int(10) unsigned DEFAULT "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_time_set tinyint(1) default "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_RECUR.' ADD r_event_begin int(10) unsigned DEFAULT "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_RECUR.' ADD r_event_stop int(10) unsigned DEFAULT "0" NOT NULL';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' CHANGE category old_category VARCHAR(255)';
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD category int(10) unsigned';

		case '2.0.2':
			$col_inserts[] = 'ALTER TABLE '.CAL_TABLE.' ADD event_access tinyint(1) unsigned DEFAULT "0" NOT NULL';	// 2.0.3

		case '2.0.3':
		case '2.0.33':
		case '2.0.34':
		case '2.0.35':
		case '2.0.36':
			$col_inserts[] = 'ALTER TABLE '.CAL_CATS.' ADD cat_color varchar(6) DEFAULT NULL';			// 2.0.37
			$col_inserts[] = 'ALTER TABLE '.CAL_CATS.' ADD cat_bg_color varchar(6) DEFAULT NULL';		// 2.0.37
			$col_inserts[] = 'ALTER TABLE '.CAL_CATS.' ADD cat_hover_color varchar(6) DEFAULT NULL';	// 2.0.37
			$col_inserts[] = 'ALTER TABLE '.CAL_CATS.' ADD cat_hover_bg_color varchar(6) DEFAULT NULL';	// 2.0.37

		case '2.0.37':
			break;

		default:
			$error = "<b>HALT! Version number not recognised during upgrade.</b><br/>[Ver: $ver ]";
			cal_update_err($error);
			exit;
	}
	$report .= 'Start processing INSERT and ALTER sql updates:<br/><br/>';
	$report = go_sql($col_inserts, $report);
	$report .= '<br /><br />';


	//
	//------------------------------------------------------
	// Handle data conversion [Functions]

	$convert_s = array();

	switch($ver) {

		case '1.2.2':
		case '1.4.x':
			$report = convert_date2time((CAL_TABLE), 'eventspan', 'event_end', $report, 'id');
			$report = convert_special((CAL_TABLE), 'stamp', $report);
			break;

		case '2.0.1':
			$report .= 'Correct Category association:<br/><br/>';
			$report = category_correct('old_category', 'category', $report);
			$report .= '<br /><br />';
			$report .= 'Start converting Date/Time data:<br/><br/>';
			$report = convert_special((CAL_TABLE), 'event_date', $report);

			$convert_s[] = 'UPDATE '. CAL_TABLE .' SET event_end = (event_span + event_start + 86399)';
			$convert_s[] = 'UPDATE '. CAL_TABLE .' SET r_group_id = 0 WHERE r_type = ""';
			$report = go_sql($convert_s, $report);
			unset($convert_s);

			$report = convert_date2time((CAL_RECUR), 'r_date_start', 'r_event_begin', $report, 'r_group_id');
			$report = convert_date2time((CAL_RECUR), 'r_date_end', 'r_event_stop', $report, 'r_group_id');
			break;

		case '2.0.2':
			// Perform conversion for any events with null time set
			$report .= "Convert any \"no time set\" events to timezone friendly unixtimestamp:<br /><br />";

			$test = time_to_midday((CAL_TABLE), $report, $ver);
			if(isset($test['error'])) {
				$report = $test['error'];
			} else if(isset($test['success'])) {
				$report = $test['success'];
			}
			else {
				$report .= "<font color=red>ERROR: No $report variable returned for time conversion f(n). HALTING!</font><br />\n";
				exit;
			}
			// Remove any error/success reports so they don't get counted as SQL
			unset($test['error']);
			unset($test['success']);
			// Add changes to event records for null time set records to the $convert array
			while(list(,$sql) = each($test)) {
				$convert[] = $sql;
			}
			break;

		case '2.0.3':
		case '2.0.33':
		case '2.0.34':
		case '2.0.35':
		case '2.0.36':
		case '2.0.37':
			// Increment Categories
			$sql = 'SELECT * FROM '.CAL_CATS." WHERE cat_name != 'private' ORDER by cat_id DESC";
			if(!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, "Couldn't query calendar category table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$inc_num = ($row['cat_id'] >= 100) ? $row['cat_id']+1 : 100;
			unset($sql);
			
			$convert[] = 'UPDATE '.CAL_CATS." SET cat_id=cat_id+$inc_num WHERE cat_name != 'private' AND cat_id < 100";		// 2.0.38
			$convert[] = 'UPDATE '.CAL_TABLE." SET category=category+$inc_num WHERE category IS NOT NULL AND category < 100";	// 2.0.38
			break;

		default:
			$error = "<b>HALT! Version number not recognised during upgrade.</b><br/>[Ver: $ver ]";
			cal_update_err($error);
			exit;
	}


	//
	//------------------------------------------------------
	// Handle data conversion [MySQL].

	switch($ver) {

		case '1.2.2':
		case '1.4.x':
			$convert[] = 'UPDATE '. CAL_CONFIG ." SET config_value='Y-m-d' WHERE config_name='cal_dateformat'";	// 2.0.3
			break;

		case '2.0.1':
			$convert[] = 'UPDATE '.CAL_TABLE.' SET event_time_set = "1" WHERE event_time IS NOT NULL';
			$convert[] = 'DELETE FROM '. CAL_RECUR .' WHERE r_subject IS NULL OR r_group_id = 0';
			$convert[] = 'UPDATE '. CAL_RECUR .' SET r_group_id = 0 WHERE r_subject IS NULL';

		case '2.0.2':
			$convert[] = 'UPDATE '. CAL_CONFIG ." SET config_value='Y-m-d' WHERE config_name='cal_dateformat'";	// 2.0.3

		case '2.0.3':

		case '2.0.33':
		case '2.0.34':
		case '2.0.35':
		case '2.0.36':
		case '2.0.37':
			break;

		default:
			$error = "<b>HALT! Version number not recognised during upgrade.</b><br/>[Ver: $ver ]";
			cal_update_err($error);
			exit;
	}
	$report .= 'Start processing UPDATE sql updates:<br/><br/>';
	$report = go_sql($convert, $report);
	$report .= '<br /><br />';


	//
	//------------------------------------------------------
	// Handle data inserts.

	switch($ver) {
		case '1.2.2':
		case '1.4.x':
			$inserts[] = 'INSERT INTO '.CAL_CONFIG.' (config_name, config_value) VALUES ("allow_cat", "1")';
		case '2.0.1':
			$inserts[] = 'INSERT INTO '.CAL_RECUR .' (r_group_id, r_num, r_period, r_desc, r_subject, r_event_begin, r_event_stop) VALUES (0, 0, "none", NULL, NULL, 0, 0)';
			$inserts[] = 'INSERT INTO '.CAL_CONFIG.' (config_name, config_value) VALUES ("require_cat", "0")';

		case '2.0.2':
			$inserts[] = "INSERT INTO ".CAL_CONFIG." (config_name, config_value) VALUES ('allow_private','1')";	// 2.0.3
			$inserts[] = "INSERT INTO ".CAL_CONFIG." (config_name, config_value) VALUES ('allow_group_events','1')";	// 2.0.3
			$inserts[] = "INSERT INTO ".CAL_CONFIG." (config_name, config_value) VALUES ('cal_timeformat','H:i')";	// 2.0.3

		case '2.0.3':
			$inserts[] = "INSERT INTO ".CAL_CONFIG." (config_name, config_value) VALUES ('require_time', 0)";

		case '2.0.33':
			$inserts[] = "INSERT INTO ".CAL_CONFIG." (config_name, config_value) VALUES ('admin_private_view', 1)";

		case '2.0.34':
		case '2.0.35':
		case '2.0.36':
		case '2.0.37':
			$inserts[] = "INSERT INTO ".CAL_CATS." (cat_id, cat_name) VALUES (1, 'private')";			// 2.0.38
			$inserts[] = "INSERT INTO ".CAL_CATS." (cat_id, cat_name) VALUES (99, 'private')";			// 2.0.38
			break;

		default:
			$error = "<b>HALT! Version number not recognised during upgrade.</b><br/>[Ver: $ver ]";
			cal_update_err($error);
			exit;
	}
	$report .= 'Start processing INSERT sql updates:<br/><br/>';
	$report = go_sql($inserts, $report);
	$report .= '<br /><br />';


	//
	//------------------------------------------------------
	// Handle column drops as required.

	switch($ver) {

		case '1.2.2':


		case '1.4.x':
			$drops[] = 'ALTER TABLE '.CAL_TABLE.' DROP COLUMN eventspan';
			$drops[] = 'ALTER TABLE '.CAL_TABLE.' DROP COLUMN stamp';
			break;

		case '2.0.1':
			$drops[] = 'ALTER TABLE '.CAL_TABLE.' DROP COLUMN old_category';
			$drops[] = 'ALTER TABLE '.CAL_TABLE.' DROP COLUMN event_time';
			$drops[] = 'ALTER TABLE '.CAL_TABLE.' DROP COLUMN event_date';
			$drops[] = 'ALTER TABLE '.CAL_TABLE.' DROP COLUMN event_span';
			$drops[] = 'ALTER TABLE '.CAL_RECUR.' DROP COLUMN r_date_start';
			$drops[] = 'ALTER TABLE '.CAL_RECUR.' DROP COLUMN r_date_end';
			$drops[] = 'ALTER TABLE '.CAL_RECUR.' DROP COLUMN r_event_len';

		case '2.0.2':
		case '2.0.3':
		case '2.0.33':
		case '2.0.34':
		case '2.0.35':
		case '2.0.36':
		case '2.0.37':
			break;

		default:
			$error = "<b>HALT! Version number not recognised during upgrade.</b><br/>[Ver: $ver ]";
			cal_update_err($error);
			exit;
	}
	$report .= 'Start processing DROP sql updates:<br/><br/>';
	$report = go_sql($drops, $report);
	$report .= '<br /><br />';




	//##################################
	// Update/Insert version information

	$sql = 'SELECT * FROM '.CAL_CONFIG.' WHERE config_name = "version"';
	$query = $db->sql_query($sql);
	$row = $db->sql_fetchrow($query);
	if(isset($row['config_value'])) {
		$sql = "UPDATE ".CAL_CONFIG." SET config_value = '$currentver' WHERE config_name = 'version'";
	} else {
		$sql = "INSERT INTO ".CAL_CONFIG." (config_name, config_value) VALUES ('version', '$currentver')";
	}
	$query = $db->sql_query($sql);
	$report .= 'New CalPro Version information inserted/updated<br /><br />';
	$report .= '<br /><br />';

	// Success..
	$template->assign_block_vars('switch_success_install', array());

	$success_message = 'Congratulations, you have successfully installed <b>Calendar Pro</b>.<br /><br />
		If you have any questions, need documentation, or just want to catch up on new releases for CalPro then please
		visit Snailsource at <br /><br /><a href="http://www.snailsource.com/" class="nav">http://www.snailsource.com/</a>
		<br /><br /><center><img src="http://www.snailsource.com/files/'.$currentver.'__7495.jpeg"></center>';

	$template->assign_vars(array(
		"L_INSTRUCTION_TEXT" => '',
		"L_SUCCESS_TITLE" => '** Success **',
		"L_MESSAGE" => ($report.$success_message))
	);

	$template->pparse('body');
	exit;
}

?>