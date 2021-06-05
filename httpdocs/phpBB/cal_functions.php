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
## Mod Version: 2.0.37
## Author:      WebSnail < http://www.snailsource.com/ >
## Description: Variable settings for Calendar.php
##
## NOTE: Please read Calendar-README.txt for version information
###############################################################*/

// MOD Group specific events
function calendarperm($user_id, $groups='')
{
	if(!is_array($groups)) {
		$groups = array();
	}

	global $db, $cal_config;
	// Get the user permissions first.
	$sql = 'SELECT user_calendar_perm FROM ' .USERS_TABLE. " WHERE user_id = '$user_id'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select Calendar permission from user table', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$topgroup = 0;
	while(list(,$group) = each($groups)) {
		if($topgroup < $group['group_calendar_perm']) {
			$topgroup = $group['group_calendar_perm']; 
		}
	}

	// Use whichever value is highest.
	if ($topgroup > $row['user_calendar_perm']) {
		$cal_perm = $topgroup;
		}
	else {
		$cal_perm = $row['user_calendar_perm'];
		}
	if($cal_config['allow_user_default'] > $cal_perm && $user_id != ANONYMOUS) {
		$cal_perm = $cal_config['allow_user_default'];
		}
        return $cal_perm;
}

function get_groups($user_id)
{
	global $db, $userdata;
	// Get an array of all the groups this user is a member of
	// Get the group permissions second.
	$sql = 'SELECT g.group_id, g.group_calendar_perm FROM '. USER_GROUP_TABLE .' ug, '. GROUPS_TABLE .' g 
			WHERE g.group_id = ug.group_id AND g.group_single_user != 1 ';

	$sql .= ($userdata['user_level'] != ADMIN) ? "AND ug.user_id = '$user_id' AND ug.user_pending = 0 " : '';
	$sql .= " ORDER BY g.group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select Calendar permission from user/usergroup table', '', __LINE__, __FILE__, $sql);
	}
	$groups = array();
	while($row = $db->sql_fetchrow($result)) {
		// screen out duplicates
		if (!empty($row) && $row['group_id'] != $this_group) {
			$this_group = $row['group_id'];
			$groups[] = $row;
		}
	}
	return $groups;
}

function event_group_update($event_id, $group_access) 
{
	global $db;
	// Update the Event->Group access table
	$id = array();
	if(!is_array($event_id) && !empty($event_id)) {
		$id[0] = $event_id;
	}
	else {
		$id = $event_id;
	}
	$sql = array();
	for($i=0; $i<count($id); $i++) {
		$sql[] = "DELETE FROM ".CAL_GROUP_EVENT."  WHERE event_id = ".$id[$i];
		for($j=0; $j<count($group_access); $j++) {
			$sql[] = "INSERT INTO ".CAL_GROUP_EVENT." (event_id, group_id) VALUES ('".$id[$i]."', '".$group_access[$j]."')";
		}
	}
	for($i=0; $i<count($sql); $i++) {
		$query = do_query($sql[$i], 'Failed to update events access permissions', __LINE__, __FILE__);
	}
}

function event_group_add($event_id, $group_access) 
{
	global $db;
	// Add new record(s) to Event->Group access table
	$id = array();
	if(!is_array($event_id) && !empty($event_id)) {
		$id[0] = $event_id;
	}
	else {
		$id = $event_id;
	}
	$sql = array();
	for($i=0; $i<count($id); $i++) {
		for($j=0; $j<count($group_access); $j++) {
			$sql[] = "INSERT INTO ".CAL_GROUP_EVENT." (event_id, group_id) VALUES ('".$id[$i]."', '".$group_access[$j]."')";
		}
	}
	for($i=0; $i<count($sql); $i++) {
		$query = do_query($sql[$i], 'Failed to update events access permissions', __LINE__, __FILE__);
	}
}

function event_group_del($event_id)
{
	global $db;
	$id = array();
	if(!is_array($event_id) && !empty($event_id)) {
		$id[0] = $event_id;
	}
	else {
		$id = $event_id;
	}
	for($i=0; $i<count($id); $i++) {
		$sql = "DELETE FROM ".CAL_GROUP_EVENT." WHERE event_id = ".$id[$i];
		$query = do_query($sql, 'Failed to update events access permissions', __LINE__, __FILE__);
	}
}

// MOD end


function cat_colors($full="") { 
	global $db; 
	$sql = 'SELECT * FROM '.CAL_CATS.' WHERE cat_color IS NOT NULL AND cat_id >= 100 ORDER BY cat_name ASC'; 
	$query = do_query($sql, 'Failed to get category color list', __LINE__, __FILE__); 

	$cat_colors = array(); 

	while($row = $db->sql_fetchrow($query)) { 
		if(!empty($row['cat_color'])) { 
			if ($full) { 
				$cat_colors[$row['cat_id']] = array(
					"id"=>$row['cat_id'],
					"color"=>$row['cat_color'],
					"name"=>stripslashes($row['cat_name'])
				); 
			} else { 
				$cat_colors[$row['cat_id']] = $row['cat_color']; 
			} 
		} 
	} 
	return $cat_colors; 
} 

function cat_colors_css() { 
	global $db; 
	$sql = 'SELECT * FROM '.CAL_CATS.' WHERE cat_color IS NOT NULL AND cat_color <> "" AND cat_id >= 100'; 
	$query = do_query($sql, 'Failed to get category color list', __LINE__, __FILE__); 

	$cat_colors_css = "<style type='text/css'>\n<!-- \n"; 

	while($row = $db->sql_fetchrow($query)) {
		$class = "cal_{$row['cat_id']}";
		if ($style = ((''===$color=$row['cat_color'])?'':   "color: #$color;")
					.((''===$color=$row['cat_bg_color'])?'':"background: #$color;")) {
			$cat_colors_css .= ".$class, a.$class, a.$class:link, a.$class:visited { $style }\n";
		}
		if ($style = ((''===$color=$row['cat_hover_color'])?'':   "color: #$color;")
					.((''===$color=$row['cat_hover_bg_color'])?'':"background: #$color;")) {
			$cat_colors_css .= "a.$class:hover, a.$class:active { $style }\n";
		}
	} 

	$cat_colors_css .= "-->\n</style>\n"; 

	return $cat_colors_css; 
}



function mydateformat($gmt_time, $dateformat)
{
	global $userdata, $board_config, $lang, $cal_config;

	if (!$dateformat) {
		$dateformat = $cal_config['cal_dateformat'];	// MOD set to default as it's most likely this.
	}

	// Adjust for the timezone 
	if ( $userdata['session_logged_in'] ) {
		$board_config['board_timezone'] = $userdata['user_timezone'];
	}
	// $gmt_time = $gmt_time + ($board_config['board_timezone'] * 3600);
	// $returndate = date($dateformat, $gmt_time);

	// MOD: Because the create_date() function is shagged if you installed the DST hack we'll go back to our own version
	//	$returndate = create_date($dateformat, $gmt_time, $board_config['board_timezone']);
	//	return $returndate;

	static $translate;

	if ( empty($translate) && $board_config['default_lang'] != 'english' )
	{
		@reset($lang['datetime']);
		while ( list($match, $replace) = @each($lang['datetime']) )
		{
			$translate[$match] = $replace;
		}
	}
	return ( !empty($translate) ) ? strtr(@gmdate($dateformat, $gmt_time + (3600 * $board_config['board_timezone'])), $translate) : @gmdate($dateformat, $gmt_time + (3600 * $board_config['board_timezone']));
}

function mytime() {
	global $userdata, $board_config;
	// Return the timezone difference.

	if ( $userdata['session_logged_in'] ) {
		$board_config['board_timezone'] = $userdata['user_timezone'];
	}
	$tz_diff = $board_config['board_timezone'] * 3600;
	return $tz_diff;
}

function get_cal_cat($category) {
	global $lang;

	if($category == PRIVATE_EVENT) {
		return $lang['private_event'];
	} elseif($category == ADMIN_PRIVATE_EVENT){
		return $lang['admin_private_filter'];
	}
	global $db, $template;
	// Get the Category name.
	$sql = 'SELECT cat_name FROM ' .CAL_CATS . " WHERE cat_id = '$category'";
	if ( !($query = $db->sql_query($sql)) ) {
		message_die(GENERAL_ERROR, 'Could not get category name', '', __LINE__, __FILE__, $sql);
	}
	$cat_row = $db->sql_fetchrow($query);
	$cat_name = stripslashes($cat_row['cat_name']);
	return $cat_name;
}

function create_day_drop($day, $lastday, $start=1)
{
	if($start == 0) {
	    if($day == '') {
		$day_drop = "<option value='' selected> -- </option>\n";
		}
	    else {
		$day_drop = "<option value=''> -- </option>\n";
		}
	    }
	for ($i=1; $i<=$lastday; $i++) {
	    if ($i == $day) {
		$day_drop .= "<option value=$i selected>$i</option>\n";
		}
	    else {
	        $day_drop .=  "<option value=$i>$i</option>\n";
	        }
	    }
	return $day_drop;
}

function create_month_drop($month, $year, $start=1)
{
	global $lang;
	if($start == 0) {
	    if($month == '') {
			$mon_drop = "<option value='' selected> --- </option>\n";
		}
	    else {
			$mon_drop = "<option value=''> --- </option>\n";
		}
	}
	for ($i=1; $i<=12; $i++) {
	    $nm = $lang['datetime'][date('F', mktime(0,0,0,$i,1,$year))]; 

	    if ($i == $month) {
			$mon_drop .= "<option value=$i selected>$nm</option>\n";
		}
	    else {
			$mon_drop .= "<option value=$i>$nm</option>\n";
		}
	}
	return $mon_drop;
}

function create_year_drop($year, $start_year, $start=1)
{
	if($start == 0) {
	    if($year == '') {
		$yr_drop = "<option value='' selected> --- </option>\n";
		}
	    else {
		$yr_drop = "<option value=''> --- </option>\n";
		}
	    }
	if (!$start_year) {
	    $start_year = $year;
	    }
	for ($i=$start_year-5; $i<$start_year+5; $i++) {
	    if ($i == $year) {
		$yr_drop .= "<option value=$i selected>$i</option>\n";
		}
	    else {
		$yr_drop .= "<option value=$i>$i</option>\n";
		}
	    }
	return $yr_drop;
}

function create_drop_period($period='')
{
	global $lang;

	$period = (is_numeric($period)) ? '' : $period;	// MOD 2.0.31

	$periods = array($lang['days'], $lang['weeks'], $lang['months'], $lang['years']);
	$eng_per = array('day', 'week', 'month', 'year');
	if (!$period) { 
		$drop_period .= "<option value='' selected>--</option>\n"; 
		}
	else { 
		$drop_period .= "<option value=''>--</option>\n"; 
		}

	foreach ($periods AS $thisp) {
		list (,$engp) = each ($eng_per);
		//echo "$thisp : $period<BR>";
		if ($engp == $period) {
			$drop_period .= "<option value='".$engp."' selected>".$thisp."</option>\n";
			}
		else	{
			$drop_period .= "<option value='".$engp."'>".$thisp."</option>\n";
			}
		}
	return $drop_period;
}

function create_drop_num($num, $limit, $interval=1, $start=1)
{
	if ($num == '' && $num != '0') { 
		$drop_num = "<option value='' selected>--</option>\n"; 
		unset($num);
		}
	else { 
		$drop_num = "<option value=''>--</option>\n"; 
		} 
	for ($i=$start; $i<=$limit; $i+=$interval) {
		if ($limit == 59 && $i < 10) {
			// prepend '0' to single char numbers
			$j = '0'.$i;
			}
		else {
			$j = $i;
			}
		if ($i == $num && isset($num)) {
			$drop_num .= "<option value='$i' selected>$j</option>\n";
			}
		else {
			$drop_num .= "<option value='$i'>$j</option>\n";
			}
		}
	return $drop_num;
}


function create_drop_hours($num, $am_pm = FALSE)
{
	$hours = array(12,1,2,3,4,5,6,7,8,9,10,11);

	$num = ($am_pm && $num == 0 && $num != '') ? 12 : $num;

	if ($num == '') { 
		$drop_hours = "<option value='' selected>--</option>\n"; 
		unset($num);
	}
	else { 
		$drop_hours = "<option value=''>--</option>\n"; 
	} 
	while (list(,$h) = each($hours)) {
		if ($h == $num && isset($num)) {
			$drop_hours .= "<option value='$h' selected>$h</option>\n";
		}
		else {
			$drop_hours .= "<option value='$h'>$h</option>\n";
		}
	}
	return $drop_hours;
}


function select_am_pm($name, $period = '')
{
	// Create a drop selection box for am/pm if the time format is 'g:i a'
	$select = "<select name=\"$name\" size=\"1\">\n";
	$select .= ($period == 'am') ? "<option value=\"am\" selected>am</option>\n" : "<option value=\"am\">am</option>\n";
	$select .= ($period == 'pm') ? "<option value=\"pm\" selected>pm</option>\n" : "<option value=\"pm\">pm</option>\n";
	$select .= "</select>\n";
	return $select;
}


function create_category_drop($category='', $viewall='') 
{
	global $db, $lang, $cal_config, $caluser;

	$sql = 'SELECT * FROM '.CAL_CATS.' WHERE cat_id >= 100 ORDER BY cat_name';
	if ( !($result = $db->sql_query($sql)) ) {
		message_die(GENERAL_ERROR, 'Could not select Category data', '', __LINE__, __FILE__, $sql);
	}
	if (!$viewall) { 
		$catlist = "<option value=''>--</option>\n"; 
	}
	else {
		$catlist .= "<option value=''>- ". $lang['View All'] ." -</option>\n"; 
	}
	if($cal_config['allow_private'] && $viewall) {
		$sel = ($category == PRIVATE_EVENT) ? 'selected = \'SELECTED\'' : '';
		$catlist .= "<option value='".PRIVATE_EVENT."' $sel>- ". $lang['private_event'] ." -</option>\n"; 
	}
	if($cal_config['allow_private'] && $viewall && $cal_config['admin_private_view'] && $caluser == 5) {
		$sel = ($category == ADMIN_PRIVATE_EVENT) ? 'selected = \'SELECTED\'' : '';
		$catlist .= "<option value='".ADMIN_PRIVATE_EVENT."' $sel>- ". $lang['admin_private_filter'] ." -</option>\n"; 
	}
	while ($row = $db->sql_fetchrow($result)) {
		$sel = ($row['cat_id'] == $category) ? "selected='SELECTED'" : '';
		$catlist .= "<option value='".$row['cat_id']."' $sel class=cal_".$row['cat_id']." >".stripslashes($row['cat_name'])."</option>\n";
	}
	return $catlist;		
}

function create_access_drop($selected, $allow_private, $allow_group_events)
{
	global $db, $lang;
	// Create access selection
	
   // MOD by Martin: make usergroup default 
   $selected = ($selected == '' && $allow_group_events) ? 2 : $selected;	

	$access_list = array(0 => $lang['public_event']);
	if($allow_private) {
		$access_list[1] = $lang['private_event'];
	}
	if($allow_group_events) {
		$access_list[2] = $lang['ug_event'];
	}
	while (list($key, $access) = each($access_list)) {
		$sel = ($key == $selected) ? 'SELECTED' : '';
		$access_select .= "<option value=\"$key\" $sel>$access</option>\n";
	}
	if(count($access_list) <= 1) {
		message_die(GENERAL_ERROR, 'Access List generation attempt (no options are available)', '', __LINE__, __FILE__, '');
	}
	return $access_select;
}

function create_groups_drop($groups, $selected) 
{
	global $db, $lang;
	// Create usergroup list for this user

	if(!is_array($selected)) {
		$selected = array();
	}

	if($groups <= 1) {
		// 1 or fewer groups.
		if(empty($groups[0])) {
			message_die(GENERAL_ERROR, 'Groups array was empty and should not have reached this point', '', __LINE__, __FILE__, '');
		}

		$sql = 'SELECT group_id, group_name FROM '.GROUPS_TABLE." 
			WHERE group_id = '".$groups[0]['group_id']."'";
		if ( !($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not select Group data', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		for($i=0; $i<count($selected); $i++) {
			$sel = '';
			if($row['group_id'] == $selected[$i]['group_id']) {
				$sel = 'SELECTED';
			}
		}
		//MOD by Martin: select group by default 
      	$sel = 'SELECTED';
		
		$groups_select = "<option value='' $sel>".$row['group_name']."</option>\n";
	}
	else {
		$sql = 'SELECT group_id, group_name FROM '.GROUPS_TABLE;

		while(list($key,$group) = each($groups)) {
			$sql_groups .= (!empty($sql_groups)) ? ' OR ' : '';
			$sql_groups .= "group_id = '".$group['group_id']."'";
		}
		if($sql_groups) {
			$sql .= " WHERE ($sql_groups)";
		}

		if ( !($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not select Groups data', '', __LINE__, __FILE__, $sql);
		}
		while($row = $db->sql_fetchrow($result)) {
			$sel = '';
			for($i=0; $i<count($selected); $i++) {
				$sel = ($row['group_id'] == $selected[$i]['group_id']) ? 'SELECTED' : $sel;
			}
			//MOD by Martin: select first group by default 
         	$sel = (count($selected) < 1 && !$flag_sel) ? 'SELECTED' : $sel; 
         	$flag_sel = TRUE;
			
			$groups_select .= '<option value="'.$row['group_id'].'" '.$sel.'>'.$row['group_name']."</option>\n";
		}

	}
/*
echo "SQL: ".$sql."\n<br />";
echo $groups_select; exit;
*/
	return $groups_select;
}



// buttons

function button_main($url, $month, $align='center')
{
	global $lang;
	$button_main = "<form method=post action='$url'><td align='$align'>\n";
	$button_main .= "<input type=submit value='$month' class=mainoption>\n";
	$button_main .= '</td></form>';
	return $button_main;
}

function button_validate($url) 
{
	global $lang, $caluser;
	if ($caluser >= 5) {
		// Validate button
		$button_validate = "<form method=post action='$url'><td>";
		$button_validate .= "<input type=submit value='" . $lang['Validate'] . "' class=mainoption>";
		$button_validate .= '</td></form>';
		}
	else {
		$button_validate = '';
		}
	return $button_validate;
}

function button_mod_del($url)
{
	global $lang, $caluser;
	if ($caluser >= 4) {
		// Delete/Modify Button
		$button_mod_del = "<form method=post action=$url><td>";
		$button_mod_del .= '<input type=submit value="';
		if ($caluser >= 5) { $button_mod_del .= $lang['Cal_Del_mod']; }
		else { $button_mod_del .= $lang['Cal_mod_only']; }
		$button_mod_del .= '" class=mainoption></td></form>';
		}
	else {
		$button_mod_del = '';
		}
	return $button_mod_del;
}

function button_add($url, $category='')
{
	global $lang, $caluser;
	// Mod url to include category if not empty
	if(!empty($category)) {
		$url .= '&category='.$category;
	}

	// Next Month			
	$button_add = "<form method=post action='$url'><td>";
	$button_add .= '<input type=submit value="' . $lang['Cal_add_event'] .'" class=mainoption>';
	$button_add .= '</td></form>';
	return $button_add;
}

function button_prev($url, $align='left')
{
	// Previous Month			
	$button_prev =  "<form method=post action='$url'><td align='$align' width='10' NOWRAP height='10'>";
	$button_prev .=  "<input type=submit value='<<' class=mainoption></td></form>";
	return $button_prev;
}

function button_next($url, $align='right')
{
	// Next Month			
	$button_next =  "<form method=post action='$url'><td align='$align' width='10' NOWRAP height='10'>";
	$button_next .= "<input type=submit value='>>' class=mainoption></td></form>";
	return $button_next;
}

function do_query($sql, $error_msg, $line='', $file='') {
	global $db;
	if ( !($query = $db->sql_query($sql)) )
		{
		$line = (!$line) ? __LINE__ : $line;
		$file = (!$file) ? __FILE__ : $file;
		$error_msg .= "<BR><span class=genmed>".mysql_error()."</span>";
		message_die(GENERAL_ERROR, $error_msg, '', $line, $file, $sql);
		}
	return $query;
}


function check_end_iteration($group_id) {
	global $db;
	// Check the last available iteration
	$sql = "SELECT MAX(r_iteration) AS max_it FROM ".CAL_TABLE." WHERE r_group_id = '$group_id'
		AND r_type != 'S' AND r_type != 'D'";
	$query = do_query($sql, 'Could not select last iteration for group');
	$row = $db->sql_fetchrow($query);
	return $row['max_it'];
}



function create_drop_nth_num($r_num, $r_period) {	// We use the $r_period as an indicator of whether it's nth data or not
	// create a drop select field for the nth number
	global $lang;

	// Allow for language packs missing this.
	$lang['c_last'] = isset($lang['c_last']) ? $lang['c_last'] : 'Last';

	$nth_lang = array(0 => '--', 1 => $lang['c_first'], 2 => $lang['c_second'], 3 => $lang['c_third'], 4 =>$lang['c_fourth'], 5 =>$lang['c_last']);
	$r_num = (is_numeric($r_period)) ? $r_num : 0;

	while(list($key, $val) = each($nth_lang)) {
		if ($r_num == $key) {
			$drop_num .= "<option value='$key' selected>".$val."</option>\n";
			}
		else	{
			$drop_num .= "<option value='$key'>".$val."</option>\n";
			}
		}
	return $drop_num;
}

function create_drop_nth_period($r_period='') {
	// create a drop select field for the nth period
	global $langdays;

	$r_period = (is_numeric($r_period)) ? $r_period : '';

	if (!$r_period) { 
		$drop_period .= "<option value='' selected>--</option>\n"; 
		}
	else { 
		$drop_period .= "<option value=''>--</option>\n"; 
		}
	for ($i=0; $i<=6; $i++)	{
		if ($r_period == $i && $r_period != '') {
			$drop_period .= "<option value='$i' selected>".$langdays[$i]."</option>\n";
			}
		else	{
			$drop_period .= "<option value='$i'>".$langdays[$i]."</option>\n";
			}
		}
	return $drop_period;
}


function xGetNthDay($t_year, $t_month, $nth, $day_of_week) { 
	// Find the nth ???day in t_month / t_year
	$o_date = gmmktime(0,0,0,$t_month,1,$t_year);
	return $day_of_week = (7 * $nth) - 6 + (($day_of_week + 7 - gmdate("w",$o_date)) %7); 

// Usage: the 4th Sunday of January, 2003 
// 		   year, mon, nth, day
// trace(xGetNthDay(2003, 1, 4, 0));  
// Output: 26
} 


function inc_event_date($r_num, $r_period, $this_date, $recur_type, $symbol = '+') {
	global $tz_diff;

	// Check the symbol is valid.
	$symbol = ($symbol == '-') ? $symbol : '+';

	// Increment the date depending on the type 
	if($recur_type == 1) {
		// New method ie: Nth Xday in a month.

		// To cope with timezone differences we have to adjust the incoming variables BACK.
		$this_date += $tz_diff;	// remember to correct back!!

		$i_year = gmdate("Y", $this_date);
		$i_month = gmdate("n", $this_date);
		$day = gmdate("j", $this_date);
		$hour = gmdate("H", $this_date);
		$minute = gmdate("i", $this_date);

// TEST echo "DAY: $day, M: $i_month, HOUR: $hour, MIN: $minute \n<br />";

		if($r_num <= 4) {
			$next_day = xGetNthDay($i_year, $i_month, $r_num, $r_period);
		} else {
			// Last Day in month so test for 4th
			$forth_day = xGetNthDay($i_year, $i_month, 4, $r_period);
			$fifth_day = xGetNthDay($i_year, $i_month, 5, $r_period);
			$test_month = date("n", gmmktime($hour,$minute,0,$i_month,$fifth_day,$i_year));
/* TEST 
echo "4th: $forth_day, 5th: $fifth_day \n<br/>";
echo "TM: $test_month, IM: $i_month \n<br/>";
exit;
*/

			$next_day = (intval($test_month) != intval($i_month)) ? $forth_day : $fifth_day;
		}

		if($next_day <= $day) {
			if($i_month >=12) {
				$i_month = 1;
				$i_year++;
			} else {
				$i_month++;
			}

			if($r_num <= 4) {
				$next_day = xGetNthDay($i_year, $i_month, $r_num, $r_period);
			} else {
				// Last Day in month so test for 4th
				$forth_day = xGetNthDay($i_year, $i_month, 4, $r_period);
				$fifth_day = xGetNthDay($i_year, $i_month, 5, $r_period);
				$test_month = gmdate("n", gmmktime($hour,$minute,0,$i_month,$fifth_day,$i_year));

				$next_day = (intval($test_month) != intval($i_month)) ? $forth_day : $fifth_day;
			}
		}
		$new_date = gmmktime($hour,$minute,0,$i_month,$next_day,$i_year) - $tz_diff;	// Correct for timezone addition earlier

	} else {
		// Old method ie: repeat every X * Y period
		$new_date = strtotime(($symbol . $r_num. " $r_period"),$this_date.' GMT');

		$new_date = dst_check($new_date, $this_date);
	}
	return $new_date; 
} 

// Double check that we've not gone into or out of DST
function dst_check($stamp, $old_stamp) {
	// strtotime botches things into a DST evaluated date.. so we compensate

	$dst_check = ( ($stamp - $old_stamp) % (24*60*60) );
	if($dst_check == 3600) {
		// 1 hour ahead
		$stamp = $stamp - 3600;
	} elseif ($dst_check == 82800) {
		// 1 hour behind (23h = 82800)
		$stamp = $stamp + 3600;
	}

// CHECK echo "ND: $stamp, CHK: $dst_check\n<br/>";

	return $stamp;
}


// Useful multiple dimension array sort subroutine.
function array_qsort2 (&$array, $column=0, $order=SORT_ASC, $first=0, $last= -2) { 
	// $array  - the array to be sorted 
	// $column - index (column) on which to sort 
	//          can be a string if using an associative array 
	// $order  - SORT_ASC (default) for ascending or SORT_DESC for descending 
	// $first  - start index (row) for partial array sort 
	// $last   - stop index (row) for partial array sort 

	if($last == -2) { 
		$last = count($array) - 1; 
	}
	if($last > $first) { 
		$alpha = $first; 
		$omega = $last; 
		$guess = $array[$alpha][$column]; 
		while($omega >= $alpha) { 
			if($order == SORT_ASC) { 
				while($array[$alpha][$column] < $guess) {
					$alpha++;
				}
				while($array[$omega][$column] > $guess) {
					$omega--;
				}
			} else { 
				while($array[$alpha][$column] > $guess) {
					$alpha++; 
				}
				while($array[$omega][$column] < $guess) {
					$omega--;
				}
			} 
			if($alpha > $omega) { 
				break; 
			}
			$temporary = $array[$alpha]; 
			$array[$alpha++] = $array[$omega]; 
			$array[$omega--] = $temporary; 
		} 
		array_qsort2 ($array, $column, $order, $first, $omega); 
		array_qsort2 ($array, $column, $order, $alpha, $last); 
	}
	return $array; 
} 

function solo_update($r_group_id) {

	global $db;

	// Now find the next non-solo/deleted record in chain
	$sql = "SELECT * FROM ".CAL_TABLE." AS c, ".CAL_RECUR." AS r
		WHERE c.r_group_id = r.r_group_id
		AND r_type = 'R' AND c.r_group_id = '$r_group_id' 
		AND r_iteration > 0 ORDER BY r_iteration ASC";
	$query = do_query($sql, 'SPLIT SOLO: Could not select next valid event');

	// Delete any 'D' marked events before the first valid one
	while (($row = $db->sql_fetchrow($query)) && $row['r_type'] == 'D') {
		$sql_del = "DELETE FROM ".CAL_TABLE." WHERE id = '".$row['id']."'; ";
		$query2 = do_query($sql_del, 'SPLIT SOLO: Could not delete D marked events pre next valid');
	}

	if ($row['id']) {
		// Check that there's more than one iteration left
		if (mysql_num_rows($query) > '1') {
			// There's more than 1 iteration so we maintain the master and associated events

			// Found a valid event in the chain so update the master record
			$sql  = "UPDATE ".CAL_RECUR." SET r_event_begin = '". $row['event_start'] ."'
				WHERE r_group_id = '$r_group_id' AND r_group_id != '0'";
			$query = do_query($sql, 'SPLIT SOLO: Could not update master record with new start date');

			// Update the iterations on the remaining child event records
			$sql = "UPDATE ".CAL_TABLE." SET r_iteration = r_iteration - ". $row['r_iteration'] ."
				WHERE r_group_id = '$r_group_id'";
			$query = do_query($sql, 'SPLIT SOLO: Could not update remaining iterations');
		}
		else {
			// Get rid of the master event as there's no recurring chain left.
			$new_info = defunct_master($r_group_id, $row);
			// Update the remaining single record to make non-recurring
			$sql = "UPDATE ".CAL_TABLE." SET r_group_id='0', r_iteration=NULL, r_type='',
				description = '".$new_info['desc']."', subject = '".$new_info['subject']."'
				WHERE id = ".$row['id'];
			$query = do_query($sql, 'SPLIT SOLO: Could not update remaining single record');
		}
	}
	else {
		// No valid iterations left in this chain so delete the master
		$sql = "DELETE FROM ".CAL_RECUR." WHERE r_group_id = '$r_group_id' AND r_group_id != '0'";	
		$query = do_query($sql, 'SPLIT SOLO: Could not delete master(2)');
			// Update any SOLO records
		$sql .= "UPDATE ".CAL_TABLE." SET r_group_id='0', r_type='' WHERE r_group_id='$r_group_id' AND r_type = 'S';";
		$query = do_query($sql, 'SPLIT SOLO: Could not update remaining solo records(2)');
	}
	return;
}

function defunct_master($r_group_id, $row, $keep_events=0)
{
	// Chain now defunct so delete master and any remaining D marked events
	$sql  = "DELETE FROM ".CAL_RECUR." WHERE r_group_id = '$r_group_id' AND r_group_id != '0'";
	$query = do_query($sql, 'MASTER: Could not delete defunct master record');

	// Update any SOLO records
	$sql = "UPDATE ".CAL_TABLE." SET r_group_id='0', r_iteration=NULL, r_type='' 
		WHERE r_group_id='$r_group_id' AND r_type = 'S'";
	$query = do_query($sql, 'SPLIT SOLO: Could not update remaining solo records');

	if(!$keep_events) {
		$sql_del = "SELECT id FROM ".CAL_TABLE." WHERE r_group_id = '$r_group_id'";
		if(is_array($row)) {
			if($row['id']) {
				$sql_del .= " AND id != '".$row['id']."'";
			}
		}

		del_array($sql_del, 'REMOVE RECUR: Unable to select excess recurring events');

		$sql = "DELETE FROM ".CAL_TABLE." WHERE r_group_id = '$r_group_id' AND r_group_id != 0";
		if(is_array($row)) {
			if($row['id']) {
				$sql .= " AND id != ".$row['id'];
			}
		}
// echo "DM: $row, ID:".$row['id'].", SQL_2: ".$sql;
		$query = do_query($sql, 'MASTER: Could not delete defunct iterations');
	}

	// Combine the old master and this records desc and subject for update to the record
	// ... that will now be a single event
	if(is_array($row)) {
		if($row['id']) {
			$new_info = array();
			if ($row['r_subject'] && $row['subject']) {
				$new_info['subject'] = $row['r_subject'].' : '.$row['subject'];
			}
			else {
				$new_info['subject'] = ($row['r_subject']) ? $row['r_subject'] : $row['subject'];
			}
			if ($row['r_desc'] && $row['description']) {
				$new_info['desc'] = $row['r_desc']. '<br /><br />----------<br />' .$row['description'];
			}
			else {
				$new_info['desc'] = ($row['r_desc']) ? $row['r_desc'] : $row['description'];
			}
			return $new_info;
		}
	}
	else {
		return;
	}
}

function del_array($sql_del, $error='DEL ARRAY: failed') 
{
	global $db;
	$query_del = do_query($sql_del, $error);
	while($row_del = $db->sql_fetchrow($query_del)) {
		$del_ids[] = $row_del['id'];
	}
	// Delete event_group associations related to the events that will be deleted
	event_group_del($del_ids);
	return;
}


function get_subject($event, $subject_length, $surpress_default=FALSE) {
	/*
		Creates an array of:
			subject 		=> just the 'subject' field
			full_subject	=> [Recurring subject data] subject 
			bullet			=> bullet/flag to indicate group, private or default event
	
	
		Note: the default bullet can be supressed from showing.. useful for full event display
	*/
	

	// Get rid of any bbcode
	$event['r_subject'] = cal_strip_bbcode($event['r_subject']);
	$event['subject'] = cal_strip_bbcode($event['subject']);

	$full_subject = '';
	// Compile the subject data and bullets 
	if ($event['r_subject'] && $event['subject']) {
		$full_subject = '[';
	}
	$full_subject .= $event['r_subject'];

	if ($event['r_subject'] && $event['subject']) {
		$full_subject .= '] ';
	}
	$full_subject .= $event['subject'];
	$subject = $event['r_subject'];
	if ($event['subject'] && $event['r_subject']) {
		$subject = '&gt;'.$event['subject'].': '.$event['r_subject'];
	}
	else if ($event['subject']) {
		$subject = $event['subject'];
	}
	$subject = stripslashes($subject);
	$full_subject = stripslashes($full_subject);
	$subjectnum = '';

	// Set $bullet for group or private events to allow easy differentiation.
	$bullet = ($event['event_access'] >= 1) ? (($event['event_access'] == 2) ? BULLET_GROUP : BULLET_PRIVATE) : ($surpress_default ? '' : BULLET_DEFAULT);
	$bullet .= (!defined('BULLET_SPACE') || BULLET_SPACE) ? '&nbsp;' : '';	// Add a space after bullet if required
	
	// Specific UKRag.net function.
	if ( strlen($subject) > $subject_length && !empty($subject_length)) {
	   	if ((substr($subject,-3,1) == '(') && (substr($subject,-1,1) == ')')) {
			// store the number of permits and tack them on the end of the shortened subject
			$subjectnum = substr($subject,-2,1);
			$subject = substr($subject, 0, -3);
		}
	   	$subject = substr($subject, 0, $subject_length);
		$subject .= '..';
	}
	if (!empty($subjectnum)) { 
		$subject .= ' ('.$subjectnum.')'; 
	}
	// End UKRag.net function

	$data['full_subject'] = $full_subject;
	$data['subject'] = $subject;
	$data['bullet'] = $bullet;

	return $data;
}

//#################################
// Variable cleaner 

function clean_me($var, $type) {
	if($type == 'str') {
		return str_replace("\'", "''", $var);
	} elseif($type == 'num') {
		return intval($var);
	} else {
		message_die(GENERAL_ERROR, "No type specified for the var cleaner", "", __LINE__, __FILE__, "Var: $var | Type: $type");
	}
}


//#################################
// Strip BBcode

function cal_strip_bbcode($input) {
	$stripped = preg_replace("/\[(\/)?([a-z\=\"])+(\:[0-9a-z\:]+)?\]/si", "", $input);
	return $stripped;
}

?>