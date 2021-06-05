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

// Temp setting
$span_js_on = TRUE;

include_once('cal_constants.inc');
$session_loc = CAL_MONTH_VIEW;

require_once('cal_main.php');
if ($cal_config['allow_anon'] != '1' && $caluser < 1) {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}
$print = ($action == 'print') ? TRUE : FALSE;

if(!$print) {
	include ($cal_file_path . 'includes/page_header.'.$phpEx);
}
$use_template = ($print) ? 'cal_print_month.tpl' : 'cal_view_month.tpl';
$template->set_filenames(array(
	'body' => $use_template)
);
$span_js_on = ($print) ? FALSE : $span_js_on;

$tz_diff = mytime();

$currentday = gmdate( 'j', (time() + $tz_diff) );
$currentmonth = gmdate( 'n', (time() + $tz_diff) );
$currentyear = gmdate( 'Y', (time() + $tz_diff) );

$lastday = 1;

//$pt = sprintf("%c", 149);
$pt = '*';

$month = (!$month) ? $currentmonth : $month;
$year =  (!$year) ? $currentyear : $year;

// get category list
$category_select = ($cal_config['allow_cat']) ? create_category_drop($category, 1) : '';

// NOTE: $cal_config['week_start'] is config defined 1st day.

$firstday =  (gmdate('w', (gmmktime(0,0,0,$month,1,$year))) - $cal_config['week_start']) % 7;
$firstday = ($firstday < 0) ? ($firstday + 7) : $firstday;

$lastday = gmdate('t',  gmmktime(0,0,0,$month,1,$year));
$end_day = 7-(($firstday + $lastday) % 7);
$end_day = ($end_day == 7) ? 0 : $end_day;	// day 7 same as day 0


// MOD 2.0.36 Get category color codes
$cat_colors = cat_colors();

$cat_colors_css = cat_colors_css(); 
$template->assign_vars(array( 
   'CATEGORY_CSS' => $cat_colors_css) 
); 

$template->assign_block_vars('cat_legend', array( 
   'CAT_LEGEND' => (isset($lang['Legend']) ? $lang['Legend'] : 'Legend:'), 
)); 

$catcolors = cat_colors(true); 
$max = count($catcolors);
$i = 1;
foreach ($catcolors as $k => $v) { 
	$template->assign_block_vars('cat_legend.cat_colorcode', array( 
		'ID' => $v["id"], 
		'NAME' => $v["name"], 
		'COLOR' => $v["color"], 
		'DIVIDER' => ($i < $max) ? ' | ' : ''
	)); 
	$i++;
} 



// MOD NEED TO TIDY THIS UP AFTER TESTING!
// Something wrong with this equation... ???
// $start_point_local = gmmktime(0,0,0,$month,1,$year) - ($firstday * 60 * 60 * 24) + $tz_diff;

// CHECK echo "\n<br /> GM1stDay: ".gmdate("Y-m-d H:i", gmmktime(0,0,0,$month,1,$year)).", FD: $firstday, FDT: ".($firstday * 60 * 60 * 24)."<br />\n";

$start_point_gmt = gmmktime(0,0,0,$month,((-$firstday) + 1),$year);
$start_point_local = $start_point_gmt - $tz_diff;

// CHECK echo "SPU_alt: $start_point_gmt , SPU_alt+tz: ".($start_point_local)." SPU_alt_Date: ".gmdate("Y-m-d H:i", ($start_point_local))." <br /><br /><br />\n";

// END TIDY UP!!

// MOD fix trailing event not being selected for non GMT timezones. ie: ($end_day + 1)
$end_point_local = gmmktime(0,0,0,$month,$lastday,$year) + (($end_day+1) * 60 * 60 * 24) - $tz_diff;

$nextmonth = ($month < 12) ? ($month + 1) : 1;
$nextyear = ($month < 12) ? $year : ($year + 1);

$lastmonth = ($month > 1) ? ($month - 1) : 12;
$lastyear = ($month > 1) ? $year: ($year - 1);

$day_head = (0+$cal_config['week_start'])%7;

$template->assign_vars(array(
	'CAL_MONTH' => $lang['datetime'][date('F', mktime(0,0,0,$month,1,$year))],
	'CAL_YEAR' => $year,
	'DAY_HEAD_1' => $langdays[($day_head)],
	'DAY_HEAD_2' => $langdays[($day_head+1)],
	'DAY_HEAD_3' => $langdays[($day_head+2)],
	'DAY_HEAD_4' => $langdays[($day_head+3)],
	'DAY_HEAD_5' => $langdays[($day_head+4)],
	'DAY_HEAD_6' => $langdays[($day_head+5)],
	'DAY_HEAD_7' => $langdays[($day_head+6)],
	'CATEGORY' => $category_select)
);
$rowrow = 1;





// MOD group specific and private events - start
$sql = "SELECT *, c.event_start FROM ".CAL_TABLE." AS c 
	LEFT JOIN ".CAL_RECUR." AS r ON c.r_group_id = r.r_group_id
	LEFT JOIN ".CAL_GROUP_EVENT." AS ge ON c.id = ge.event_id
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
	$sql .= "c.event_end >= '$start_point_local' AND c.event_start <= '$end_point_local' ";
}
else {
	
	// If time_set is 0 then the time is going to be GMT 12 noon to keep it in the right day. 
	// Timezones >= 12 screw this up so we allow for it with this SQL :)
	$time_adjust = 12 * 60 * 60;
	$sql .= "((c.event_end >= '$start_point_local' AND c.event_start <= '$end_point_local' AND event_time_set >= 1)
		OR (c.event_end >= '". ($start_point_local + $time_adjust) ."' AND c.event_start <= '". ($end_point_local + $time_adjust) ."' AND event_time_set = 0)) ";
}
// MOD end
/*
echo $board_config['board_timezone'];
echo "<BR>SQL ".$sql;
exit;
*/

if ($category) {
	$sql .= ($category != PRIVATE_EVENT && $category != ADMIN_PRIVATE_EVENT) ? "AND c.category = '$category' " : "AND c.event_access = 1 ";
}
$sql .= 'ORDER BY c.event_start';

//CHECK echo "<BR>$sql";
//exit;

if ( !($query = $db->sql_query($sql)) ) {
	message_die(GENERAL_ERROR, 'Could not get months data', '', __LINE__, __FILE__, $sql);
}

$events = array();
$max_slots = array();

//CHECK echo "TZD: ".$tz_diff.", SR: $start_point_local, SRD: ".gmdate("Y-m-d H:i",$start_point_local).", ER: $end_point_local, ERD: ".gmdate("Y-m-d",$end_point_local)."\n\n<br/>";

while($get_row = $db->sql_fetchrow($query)) {
	// Stop repeats of the same event
	/* 	Because the events are in order of date, duplicate events created for users in multiple usergroups
		will follow duplicate events and can be screened out here
	*/
	if($prev_event_id == $get_row['id']) {
		continue;
	}
	$prev_event_id = $get_row['id'];

// MOD MAJOR CHANGE!! Altering the way events are stored in the array.
/*
	By putting the events into an array which matches the date they're on we can do a little more to control
	formatting, improve the way spanning events are shown, etc...
*/

	if(!$get_row['event_time_set'] && $board_config['board_timezone'] >= 12) {
		$get_row['event_start'] -= $time_adjust;
		$get_row['event_end'] -= $time_adjust;
	}

	//MOD 2.0.36 Add in coloured categories.
	if(!empty($get_row['category']) && isset($cat_colors[$get_row['category']])) {
		if(is_numeric($get_row['category'])) {
			$get_row['cat_color'] = $cat_colors[$get_row['category']];
		}
	}

	// Get the standardised date for use in the array.
	$starting_gmt = $get_row['event_start'];
	$ending_gmt = $get_row['event_end'];

//CHECK echo "EVST: ".$get_row['event_start'].", EVSTD:".gmdate("Y-m-d H:i", $get_row['event_start']).", EVEND: ".$get_row['event_end'].", EVENDD: ".gmdate("Y-m-d H:i", $get_row['event_end'])."\n<br />";
//CHECK echo "ID: ". $get_row['id'] .", SP: $start_point_local, ST: $starting_gmt, STD: ".gmdate("Y-m-d H:i", $starting_gmt).", E: $ending_gmt, ED: ".gmdate("Y-m-d H:i", $ending_gmt)."\n\n<br/><br /><br/>";
// PROBLEM TO SOLVE Ref not helping locate correct column for start end...

	// Find starting row/col refs
	/*
		NOTE: We re-add the $tz_diff to the $ref because we've cancelled the others out and created a GMT value again
			when we subtracted $start_point_local from $starting_gmt

		ie: 	12+1 - 5+1 <=> 12 + 5

		Only took 5 hours to work that one out! :-/
	*/

	$ref = ($starting_gmt - $start_point_local) / (24*60*60);
	$start_ref = ($ref < 0) ? 0 : intval($ref);

	$start_row = intval($start_ref/7);
	$start_col = intval($start_ref % 7);

//CHECK echo "REF: $ref, SR: $start_row, SC: $start_col\n\n<br/>";

	if($starting_gmt < $ending_gmt) {
		// If more than one day.
		$ref = ($ending_gmt - $start_point_local) / (24*60*60);
		$end_ref = ($ref < 0) ? 0 : intval($ref);
		$end_row = intval($end_ref/7);
		$end_col = $end_ref % 7;
	} else {
		$end_row = $start_row;
		$end_col = $start_col;
	}
//CHECK echo "REF: $ref, ER: $end_row, EC: $end_col\n\n<br/>";

	for($this_row=$start_row; $this_row <= $end_row ; $this_row++){
		$slot = 0;
		$initial_col = ($this_row == $start_row) ? $start_col : 0;
		for($this_col=$initial_col; $this_col < 7; $this_col++) {
			while($events[$this_row][$this_col][$slot] != '') {
				$slot++;
			}
		}
		$target_col = ($this_row == $end_row) ? $end_col : 6;
		for($this_col=$initial_col; $this_col <= $target_col; $this_col++) {
			$events[$this_row][$this_col][$slot] = $get_row;
		}
		$max_slots[$this_row] = ($max_slots[$this_row] < $slot) ? $slot : $max_slots[$this_row];
	}
	// Ok... $slot should now be set to a $line reference that is free across the current week row.
}
//print_r($events);
//exit;
/*
	Ok, now all events are in an array that uses the start date as the key... 

	The trick now is to look at each weeks events whilst:
	- Slotting each event that spans more than one day into a set slot
	- Dropping single day events into spare slots
	- working out the max number of slots used for any one week
*/

$end_row = intval(($end_point_local-$start_point_local)/(24*60*60)) / 7;
$day_count = 1;
$now_diffed = time() + $tz_diff;
$today_marker = ($month == gmdate("n", $now_diffed) && $year == gmdate("Y", $now_diffed)) ? gmdate("j", $now_diffed) + $firstday : '';
//CHECK echo "ER: $end_row, TM: $today_marker \n<br />";



for ($event_row=0; $event_row < $end_row; $event_row++) {
	if($max_slots[$event_row] < 4) {
		$max_slots[$event_row] = 4;
	}

	// Get the start of the next week ready.
	$wk_day = $day_count - $firstday;
	$wk_day = $wk_day == 0 ? 1 : $wk_day;

	$template->assign_block_vars('week_row', array(
		U_WEEK => append_sid('cal_view_week.'.$phpEx.'?day='.$wk_day.'&month='.$month.'&year='.$year.'&category='.$category)
		)
	);

	for($event_col=0; $event_col <= 6; $event_col++) {
		$today_day = '';
		$today_year = '';
		$today_month = '';

		if($day_count <= $firstday) {
			$use_block = 'last_mon';
			$cellback = 'class=row3';
			$cellhead = 'class=row1';
			$cellbody = 'class=row2';
			$today_year = ($month <= 1) ? $year - 1 : $year;
			$today_month = ($month <= 1) ? 12 : $month - 1;
			$today_day = (gmdate('t', gmmktime(0,0,0,$today_month,1,$today_year)) - $firstday) + $day_count;
		}
		else if ($today_marker && $day_count == $today_marker) {
			// TODAY 
			$use_block = 'this_mon'; 
			$cellback = 'bgcolor=#FFAF5D';  // yellow outline 
			$cellhead = 'bgcolor=#FFAF5D';  // yellow cell head 
			$cellbody = 'class=row2';
		}
		else if ($day_count > ($firstday + $lastday)) {
			// end of the month
			$use_block = 'next_mon';
			$cellback = 'class=row3';
			$cellhead = ($currentmonth == $today_month && $currentday == $thisday) ? 'class=rowpic' : 'class=row1';
			$cellbody = 'class=row2';
			$today_year = ($month >= 12) ? $year + 1 : $year;
			$today_month = ($month >= 12) ? 1 : $month + 1;
			$today_day = $day_count - ($firstday + $lastday);
		}
		else {
			$use_block = 'this_mon';
			$cellback = 'class=row3';
			$cellhead = 'class=row3';
			$cellbody = 'class=row1';
		}

		$today_year = $today_year ? $today_year : $year;
		$today_month = $today_month ? $today_month : $month;
		$today_day = $today_day ? $today_day : $day_count - $firstday;

	/* 
		Print view...
		We need to clear out any trailing and preceding month dates, avoid non-printer friendly layout
	*/
		if($print) {
			$use_block = 'this_mon';
			$cellback = ($day_count <= $firstday || $day_count > ($firstday + $lastday)) ? '' : 'class="bodyline"';
			$cellhead = 'class="genmed"';
			$cellbody = '';
			$today_day = ($day_count <= $firstday || $day_count > ($firstday + $lastday)) ? '' : $today_day;
			$cal_config['subject_length'] = 100;
		}

		$event_lines = "<span class=\"gensmall\">\n";
		//$event_lines = '';
		for($slot=0; $slot <= $max_slots[$event_row]; $slot++) {
			if( !isset($events[$event_row][$event_col][$slot]) || ($print && ($day_count <= $firstday || $day_count > ($firstday + $lastday) ) ) ) {
				/* 
					If PRINT view then we blank out the events for this slot
					OR it's just a default empty event slot so we just plug in a line break
				*/
				$event_lines .= ($print) ? '<span class="gensmall" STYLE="background: #FFFFFF; color: #000000">&nbsp</span>' : '&nbsp;';
			} else {
				// Something in this one so we output the event line
				$event = $events[$event_row][$event_col][$slot];

				unset($full_subject);	// Clear variable
				if ($event['r_subject'] || $event['subject']) {
// MOD
					$temp = get_subject($event, $cal_config['subject_length']);

					$full_subject = $temp['full_subject'];
					$subject = $temp['subject'];
					$bullet = $temp['bullet'];

					$url = append_sid('cal_display.'.$phpEx.'?id='.$event['id'].'&day='.$today_day.'&month='.$today_month.'&year='.$today_year.'&category='.$category, 1);

//###########
// MOD Add times for events in title tool tip
/*
					if($event['event_time_set'] && $cal_config['cal_timeformat']) {
						$event_time_start = '('.mydateformat($event['event_start'], $cal_config['cal_timeformat']).')';

						// event_time_set can be: 1 - both, 2 - start only

						if($event['event_time_set'] == 1) {
							$event_time_end = '('.mydateformat($event['event_end'], $cal_config['cal_timeformat']).')';
						} else {
							$event_time_end = '';
						}

						$full_subject .= ' ['.$lang['Cal_hour'].': '.$event_time_start.' ]';

					} else {
						$event_time_start = '';
						$event_time_end = '';
					}
*/
// MOD End Add times
//###########

					$col_cat = '';
					if(isset($event['cat_color']) && isset($event['category'])) { 
						$col_cat = 'cal_' . $event['category']; 
					} else { 
						$col_cat = 'gensmall'; 
					} 

					if($print) {
						$event_lines .= "<span class=\"gensmall\" STYLE=\"background: #FFFFFF; color: #000000\">$bullet</span><span class=\"$col_cat\">$subject</span>";
					} else {
						// Need to keep the size down
						$span_js = $span_js_on ? "onMouseOver=\"swc('cal_id".$event['id']."',1)\" onMouseOut=\"swc('cal_id".$event['id']."',0)\"" : '';
						$event_lines .= $bullet.'<a href="'.$url.'" id="cal_id'.$event['id'].'" '.$span_js
							.'" title="'.$event['username'].': '.$full_subject.'" class="'.$col_cat.'">'.$subject.'</a>'; 
					}
				}
			}
			$event_lines .= ($slot <  $max_slots[$event_row]) ? "<br />\n" : '';
		} 
		// End of slots for this day
		$event_lines .= "\n</span>\n";

		// if PRINT view then null the url 
		$u_day = ($print && ($day_count <= $firstday || $day_count > ($firstday + $lastday))) ? '' : append_sid('cal_display.'.$phpEx.'?day='.$today_day.'&month='.$today_month.'&year='.$today_year.'&category='.$category, 1);

  		$template->assign_block_vars(('week_row.'.$use_block), array(
			'NUM_DAY' => $today_day,
			'S_CELL' => $cellback,
			'S_HEAD' => $cellhead,
			'S_DETAILS' => $cellbody,
			'U_DAY' => $u_day,
			'DAY_EVENT_LIST' => $event_lines
			)
		);
		$day_count++;
	} 
	// End of this weeks columns
} 
// End of the month..

if($print) {
	$template->assign_vars(array(
		"SITENAME" => $board_config['sitename'],
		"PAGE_TITLE" => $page_title,
		"PHPBB_VERSION" => "2" . $board_config['version'],
		"T_FONTFACE1" => $theme['fontface1'],
		"S_CONTENT_DIRECTION" => $lang['DIRECTION'],
		"S_CONTENT_ENCODING" => $lang['ENCODING'],
		"S_TIMEZONE" => sprintf($lang['All_times'], $lang[number_format($board_config['board_timezone'])]),
		"PRINTER_VER" => $lang['printer_friendly_ver'])
	);
}

if ($cal_config['allow_cat']) {
		// Set append_sid( x, true) to stop it escaping the ampersand and screwing up JS call

	$jump_cat = append_sid('cal_view_month.'.$phpEx.'?month='.$month.'&year='.$year , 1) .'&category=';
	$template->assign_block_vars('category_select', array(
		'L_FILTER_CATS_ALT' => $lang['Filter_cats_alt'],
		'L_FILTER_CATS' => $lang['Filter_cats'],
		'S_CATEGORY' => $category_select,
		'S_POST_ACTION' => append_sid('cal_view_month.'.$phpEx.'?&month='.$month.'&year='.$year, 1))
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
$template->assign_vars(array(
	'IMG_YEAR' => $images['cal_year'],
	'IMG_MONTH' => $images['cal_month'],
	'IMG_WEEK' => $images['cal_week'],
	'L_WEEK_LINK' => $lang['view_week'],
	'L_YEAR_LINK' => $lang['view_year'],
	'U_YEAR' => append_sid('cal_view_year.'.$phpEx.'?month='.$month.'&year='.$year.'&category='.$category),

	'L_GO' => $lang['Go'], 
	'L_BAK2CAL' => $lang['Cal_back2cal'],
	'FILTER' => $filter,
	'U_JUMP_CAT' => $jump_cat,
	'U_JUMP_MONTH' => append_sid('cal_view_month.'.$phpEx.'?year='.$year.'&category='.$category.'&month=', 1),
	'U_JUMP_YEAR' => append_sid('cal_view_month.'.$phpEx.'?month='.$month.'&category='.$category.'&year=', 1),
	'L_MONTH_JUMP' => $lang['Month_jump'],
	'S_MONTH' => create_month_drop($month, $year),
	'S_YEAR' => create_year_drop($year, ''),
	'PHPBBHEADER' => $phpbbheaders,
	'CAL_VERSION' => 'Ver: '.$cal_config['version'],
	'CALENDAR' => $lang['Calendar'],
	'L_CAL_NEW' => $lang['Cal_add_event'],
	'U_INDEX' => append_sid("index.$phpEx", 1),
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'U_CAL_HOME' => $homeurl)
	);

if(!$print) {
	$template->assign_vars(array(
		'PRINT_IMG' =>  ($images['Print_View']) ? $images['Print_View'] : 'images/icon_print.gif',
		'L_PRINT' => ($lang['Print_View']) ? $lang['Print_View'] : 'Printable version', 
		'U_PRINT' => append_sid('cal_view_month.'.$phpEx.'?&month='.$month.'&year='.$year.'&category='.$category.'&action=print'))
	);
}

if ((($userdata && $userdata['user_id'] != '-1') && ($usersuggest == 'yes')) || ($caluser >= 2))
	{
	// Add Event button
	$button_add = button_add(append_sid('cal_add.'.$phpEx.'?month='.$month.'&year='.$year, 1), $category);
	// Admin Validate button
	$button_validate = button_validate(append_sid('cal_validate.'.$phpEx.'?action=getlist', 1));
	}

// Previous Month button
$url = append_sid('cal_view_month.'.$phpEx.'?month='.$lastmonth.'&year='.$lastyear.'&category='.$category, 1);
$url .= ($category) ? '&category='.$category : '';
$button_prev = button_prev($url);

// Next Month button
$url = append_sid('cal_view_month.'.$phpEx.'?month='.$nextmonth.'&year='.$nextyear.'&category='.$category, 1);
$url .= ($category) ? '&category='.$category : '';
$button_next = button_next($url);

$template->assign_vars(array(
	'BUTTON_PREV' => $button_prev,
	'BUTTON_ADD' => $button_add,
	'BUTTON_VALIDATE' => $button_validate,
	'BUTTON_NEXT' => $button_next)
	);
$template->pparse('body');
if(!$print) {
	include_once($cal_file_path . 'includes/page_tail.'.$phpEx);
}
exit;
?>