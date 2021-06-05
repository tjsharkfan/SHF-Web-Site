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
$use_template = ($print) ? 'cal_print_week.tpl' : 'cal_view_week.tpl';
$template->set_filenames(array(
	'body' => $use_template)
);
$span_js_on = ($print) ? FALSE : $span_js_on;

$tz_diff = mytime();

$currentday = gmdate( 'j', (time() + $tz_diff) );
$currentmonth = gmdate( 'n', (time() + $tz_diff) );
$currentyear = gmdate( 'Y', (time() + $tz_diff) );

$pt = '*';

$day = (!$day) ? $currentday : $day;
$month = (!$month) ? $currentmonth : $month;
$year =  (!$year) ? $currentyear : $year;
$num_weeks = (!$num_weeks || $num_weeks < 1) ? 1 : $num_weeks;

// get category list
$category_select = ($cal_config['allow_cat']) ? create_category_drop($category, 1) : '';

// Adjust the week start for Saturday starts from +6 -> -1 for ease of calculation
$wk_start = ($cal_config['week_start'] > 1) ? ($cal_config['week_start'] - 7) : $cal_config['week_start'];

$now_gmt = gmmktime(0,0,0,$month,$day,$year);
$start_point_gmt = $now_gmt - (gmdate("w",$now_gmt) * 86400) + ($wk_start*86400);
$start_point_gmt = ($now_gmt >= $start_point_gmt) ? $start_point_gmt : $start_point_gmt - (7*86400);

$start_point_local = $start_point_gmt - $tz_diff;
$end_point_gmt = $start_point_gmt + ($num_weeks * 7 * 86400);
$end_point_local = $end_point_gmt - $tz_diff;


$next_week = inc_event_date(1, 'week', $start_point_gmt, $recur_type, '+');
$prev_week = inc_event_date(1, 'week', $start_point_gmt, $recur_type, '-');

$nextday = gmdate('j', $next_week);
$nextmonth = gmdate('n', $next_week);
$nextyear = gmdate('Y', $next_week);

$lastday = gmdate('j', $prev_week);
$lastmonth = gmdate('n', $prev_week);
$lastyear = gmdate('Y', $prev_week);

$day_head = (0+$cal_config['week_start'])%7;

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


//MOD 2.0.37 Set dates for events not showing.
//$no_events = sprintf($lang['No_events_between'], mydateformat($start_point_gmt, $cal_config['cal_dateformat']), mydateformat(($end_point_gmt-1), $cal_config['cal_dateformat']));
$no_events = $lang['No events'];

$template->assign_vars(array(
	'L_WEEK_VIEW' => $lang['view_week'],
	'CATEGORY' => $category_select,
	'NO_EVENTS' => $no_events)
);

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

if ($category) {
	$sql .= ($category != PRIVATE_EVENT && $category != ADMIN_PRIVATE_EVENT) ? "AND c.category = '$category' " : "AND c.event_access = 1 ";
}
$sql .= 'ORDER BY c.event_time_set ASC, c.event_start ASC';

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

	if(!$get_row['event_time_set'] && $board_config['board_timezone'] >= 12) {
		$get_row['event_start'] -= $time_adjust;
		$get_row['event_end'] -= $time_adjust;
	}

	// Our event dates are left in GMT for now
	$starting_gmt = $get_row['event_start'];
	$ending_gmt = $get_row['event_end'];

	$ref = ($starting_gmt - $start_point_local) / (24*60*60);
	$start_ref = ($ref < 0) ? 0 : intval($ref);

	if($starting_gmt < $ending_gmt) {
		// Determine if the end ref.
		$e_ref = ($ending_gmt - $start_point_local) / (24*60*60);
		$end_ref = ($e_ref < 0) ? 0 : intval($e_ref);
	} else {
		$end_ref = $start_ref;
	}

	for($this_ref=$start_ref; $this_ref <= $end_ref ; $this_ref++){
		$slot = 0;
		while($events[$this_ref][$slot] != '') {
			$slot++;
		}
		$events[$this_ref][$slot] = $get_row;

		$max_slots[$this_ref] = ($max_slots[$this_ref] < $slot) ? $slot : $max_slots[$this_ref];
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

$end_point = intval(($end_point_local - $start_point_local)/(24*60*60));
$day_count = 0;
$current_day = 8;	// Guarantee it'll set a new day label.

for ($event_day = 0; $event_day < $end_point; $event_day++) {
	$todays_events = $events[$event_day];

	$max_slots[$event_day] = count($todays_events);

	$today_gmt = $start_point_gmt + ($event_day*86400);
	$today_local = $today_gmt - $tz_diff;

	$today_day = gmdate('d',($today_local));
	$today_month = gmdate( 'n', ($today_local) );
	$today_year = gmdate( 'Y', ($today_local) );

/* CHECK 
echo "ESTART: ".$todays_events[0]['event_start']. " , ". gmdate("Y-m-d H:i", ($todays_events[0]['event_start']  + $tz_diff)) ."\n\n<br />";
echo "TODAY_GMT: ".gmdate("Y-m-d H:i", $today_gmt).", ED: $event_day\n\n<br />";
exit;
*/

	$end_today_local = $today_local + 86399;

	$start_date = mydateformat($today_local, $cal_config['cal_dateformat']);

//CHECK echo "SD: ".$start_date."\n\n<br />";

	$template->assign_block_vars('new_row', array(
			'DATE' => $start_date
		)
	);

	// If it's the start or a new day then we write the new day in
	if($today_day != $current_day) {
		$dow_num = gmdate('w', $today_gmt);
		$dow_label = $langdays[$dow_num];

		// Write the "header_row"
	  	$template->assign_block_vars('new_row.header_row', array(
			'DAY' => $dow_label,
			)
		);
	}
	$current_day = $today_day;

	if($max_slots[$event_day] <= 0) {
	  	$template->assign_block_vars('new_row.empty_day_row', array(
			)
		);
	} else {
		// Start writing table rows
		for($slot=0; $slot < $max_slots[$event_day]; $slot++) {
			$evt = $todays_events[$slot];

			if($evt['event_time_set'] && $cal_config['cal_timeformat']) {
				$event_time = mydateformat($evt['event_start'], $cal_config['cal_timeformat']);

				// event_time_set can be: 1 - both, 2 - start only

				if($evt['event_time_set'] == 1) {
					$event_time .= '-'.mydateformat($evt['event_end'], $cal_config['cal_timeformat']);
				}
			} else {
				$event_time = $lang['all_day_event'] ? $lang['all_day_event'] : '[All Day]';
			}

			$temp = get_subject($evt, $cal_config['subject_length']);

			if(isset($evt['category'])) { 
				$col_cat = 'class="cal_' . $evt['category'] . '"'; 
			} else { 
				$col_cat = 'class="gensmall"'; 
			} 

		  	$template->assign_block_vars('new_row.event_row', array(
				'SUBJECT' => $temp['subject'],
				'FULL_SUBJECT' => $temp['full_subject'],
				'BULLET' => $temp['bullet'],
				'TIMES' => $event_time,

				'COL_CAT' => $col_cat,

					// Apply intval to '0x' formatted $today_day to avoid it triggering security error
				'U_EVENT' => append_sid('cal_display.'.$phpEx.'?id='.$evt['id'].'&day='.intval($today_day).'&month='.$today_month.'&year='.$today_year.'&category='.$category)
				)
			);

			$this_G_start = gmdate('G',($evt['event_start'] + $tz_diff));
			$this_G_end = gmdate('G',($evt['event_end'] + $tz_diff));

			$es = gmdate('i',($evt['event_start'] + $tz_diff));
			$ee = gmdate('i',($evt['event_end'] + $tz_diff));
			$evt['start_half'] = ($es <= 15) ? 0 : ($es <= 45 ? 1 : 2);
			$evt['end_half']   = ($ee <= 15) ? 0 : ($ee <= 45 ? 1 : 2);

//CHECK echo "ST_LOCAL: ".gmdate("Y-m-d H:i", $today_local). " END_LOCAL: ".gmdate("Y-m-d H:i", $end_today_local)."\n\n<br />";
// exit;
			if(!$evt['event_time_set']) {
				$evt['start_hour'] = 0;
				$evt['end_hour'] = 24;
			} 
			else {
				// Overkill but this will set the start/end time to the start/end of the day if it spans more than one day 

				if($evt['event_start'] >= $today_local && $evt['event_start'] <= $end_today_local) {
					$evt['start_hour'] = $this_G_start;
				}
				else {
					$evt['start_hour'] = 0;
				}

				if($evt['event_end'] >= $today_local && $evt['event_end'] <= $end_today_local) {
					$evt['end_hour'] = $this_G_end;
				}
				else {
					$evt['end_hour'] = 24;
				}
			}
			//$evt['end_hour']++;
/*
echo "TODAY_LOCAL: $today_local (".gmdate("Y-m-d H:i", $today_local).")  END_TODAY_LOCAL: $end_today_local (".gmdate("Y-m-d H:i", $end_today_local).")\n <br />";
echo "EVT_START: ".$evt['event_start']." (".gmdate("Y-m-d H:i", $evt['event_start']).")  EVT_END: ".$evt['event_end']." (".gmdate("Y-m-d H:i", $evt['event_end']).")\n <br />";
echo "Start_hour: ".$evt['start_hour']."    End_hour: ".$evt['end_hour']."\n\n <br /><br />";
*/
			if($evt['r_type']) {
				$span_class = 'recurspan';
			} 
			else {
				$span_class = 'eventspan';
			}

		// MOD half hour adaptation
			$start_span = (2 * $evt['start_hour']) + $evt['start_half'];
			$end_span = (2 * $evt['end_hour'])   + $evt['end_half'];

			$pre_event_time = $mid_event_time = $post_event_time = '';

			if (($evt['end_hour'] - $evt['start_hour']) > 7) {
				$mid_event_time = $event_time;
			} else if($evt['start_hour'] > 7) {
				$pre_event_time = $event_time;
			} else {
				$post_event_time = $event_time;
			}

			if($evt['start_hour'] > 0) {
		  		$template->assign_block_vars('new_row.event_row.start_blank', array(
					'COLSPAN' => $start_span,
					'DATE' => $pre_event_time)
				);
			}
		  	$template->assign_block_vars('new_row.event_row.event_record', array(
				'SPAN_CLASS' => $span_class,
				'COLSPAN' => ($end_span - $start_span),
				'DATE' => $mid_event_time)
			);
			if($evt['end_hour'] <= 23) {
		  		$template->assign_block_vars('new_row.event_row.end_blank', array(
					'COLSPAN' => (48 - $end_span),
					'DATE' => $post_event_time)
				);
			}
		}
	}
	if(($event_day) < $end_point) {
		$template->assign_block_vars('new_row.day_spacer', array());
	}
	// End of Day
	$day_count++;
} 
// End of the Week..

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

	$jump_cat = append_sid('cal_view_week.'.$phpEx.'?day='.$day.'&month='.$month.'&year='.$year , 1) .'&category=';
	$template->assign_block_vars('category_select', array(
		'L_FILTER_CATS_ALT' => $lang['Filter_cats_alt'],
		'L_FILTER_CATS' => $lang['Filter_cats'],
		'S_CATEGORY' => $category_select,
		'S_POST_ACTION' => append_sid('cal_view_week.'.$phpEx.'?day='.$day.'&month='.$month.'&year='.$year, 1))
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
	'L_MONTH_LINK' => $lang['view_month'],
	'L_YEAR_LINK' => $lang['view_year'],
	'U_MONTH' => append_sid('cal_view_month.'.$phpEx.'?month='.$month.'&year='.$year.'&category='.$category),
	'U_YEAR' => append_sid('cal_view_year.'.$phpEx.'?month='.$month.'&year='.$year.'&category='.$category),

	'L_GO' => $lang['Go'],
	'L_BAK2CAL' => $lang['Cal_back2cal'],
	'FILTER' => $filter,
	'U_JUMP_CAT' => $jump_cat,
	'U_JUMP_MONTH' => append_sid('cal_view_month.'.$phpEx.'?day='.$day.'&year='.$year.'&category='.$category.'&month=', 1),
	'U_JUMP_YEAR' => append_sid('cal_view_month.'.$phpEx.'?day='.$day.'&month='.$month.'&category='.$category.'&year=', 1),
	'L_MONTH_JUMP' => $lang['Month_jump'],
	'S_MONTH' => create_month_drop($month, $year),
	'S_YEAR' => create_year_drop($year, ''),
	'PHPBBHEADER' => $phpbbheaders,
	'CAL_VERSION' => 'Ver: '.$cal_config['version'],
	'CALENDAR' => $lang['Calendar'],
	'L_CAL_NEW' => $lang['Cal_add_event'],
	'U_INDEX' => append_sid("index.$phpEx", 1),
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'U_CAL_HOME' => $homeurl,
	'S_POST_ACTION' => append_sid('cal_view_month.'.$phpEx.'?&month='.$month.'&year='.$year.'&category='.$category, 1))
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

// Previous Week button
$url = append_sid('cal_view_week.'.$phpEx.'?day='.$lastday.'&month='.$lastmonth.'&year='.$lastyear.'&category='.$category, 1);
$url .= ($category) ? '&category='.$category : '';
$button_prev = button_prev($url);

// Next Week button
$url = append_sid('cal_view_week.'.$phpEx.'?day='.$nextday.'&month='.$nextmonth.'&year='.$nextyear.'&category='.$category, 1);
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