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

// Temp setting
$span_js_on = TRUE;

include_once('cal_constants.inc');
$session_loc = CAL_YEAR_VIEW;

require_once('cal_main.php');
if ($cal_config['allow_anon'] != '1' && $caluser < 1) {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}
$print = ($action == 'print') ? TRUE : FALSE;

if(!$print) {
	include ($cal_file_path . 'includes/page_header.'.$phpEx);
}
$use_template = ($print) ? 'cal_print_year.tpl' : 'cal_view_year.tpl';
$template->set_filenames(array(
	'body' => $use_template)
);
$span_js_on = ($print) ? FALSE : $span_js_on;

$tz_diff = mytime();

$pt = '*';

/*
	If a month & year are passed then we start the year view from that point
	If not then we start from January of the year passed or the current year
*/

$month = (!$month) ? 1 : $month;
$year =  (!$year) ? gmdate( 'Y', (time() + $tz_diff) ) : $year;

// get category list
$category_select = ($cal_config['allow_cat']) ? create_category_drop($category, 1) : '';

// Adjust the week start for Saturday starts from +6 -> -1 for ease of calculation
$wk_start = ($cal_config['week_start'] > 1) ? ($cal_config['week_start'] - 7) : $cal_config['week_start'];

$start_point_gmt = gmmktime(0,0,0,$month,1,$year);			// Get start time for year in GMT

//$end_point_gmt = gmmktime(23,59,59,$month,1,($year+1)) - 86400;		// Not sure why we were deleting a day.
$end_point_gmt = gmmktime(23,59,59,$month,1,($year+1));		// Get end time for year in GMT

// To get the local time we have to subtract the tz_diff from the GMT timestamp
$start_point_local = $start_point_gmt - $tz_diff;
$end_point_local = $end_point_gmt - $tz_diff;

$nextmonth = $month;
$nextyear = $year + 1;

$lastmonth = $month;
$lastyear = $year - 1;

$day_head = (0+$cal_config['week_start'])%7;

$template->assign_vars(array(
	'N_YEAR' => $year,
	'CATEGORY' => $category_select)
);

// MOD group specific and private events - start
$sql = "SELECT *, c.event_start FROM ".CAL_TABLE." AS c 
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
$sql .= 'ORDER BY c.event_start ASC, c.event_time_set ASC';

//CHECK echo "<BR>$sql";

//exit;


if ( !($query = $db->sql_query($sql)) ) {
	message_die(GENERAL_ERROR, 'Could not get months data', '', __LINE__, __FILE__, $sql);
}

$events = array();

//CHECK echo "TZD: ".$tz_diff.", SR: $start_point_local, SRD: ".gmdate("Y-m-d H:i",$start_point_local).", ER: $end_point_local, ERD: ".gmdate("Y-m-d H:i",$end_point_local)."\n\n<br/>";

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

	$ref = (($starting_gmt) - $start_point_local) / (24*60*60);
	$start_ref = ($ref <= 0) ? 0 : intval($ref);

	if($starting_gmt < $ending_gmt) {
		// Determine if the end ref.
		$e_ref = (($ending_gmt) - $start_point_local) / (24*60*60);
		$end_ref = ($e_ref <= 0) ? 0 : intval($e_ref);
	} else {
		$end_ref = $start_ref;
	}

	for($this_ref=$start_ref; $this_ref <= $end_ref ; $this_ref++){
		$events[$this_ref][] = $get_row;
	}
}
/*
print_r($events);
exit;
*/




$end_point = intval( ($end_point_local-$start_point_local) / (24*60*60) );
$day_count = 0;
$current_day = 8;	// Guarantee it'll set a new day label.
$evts = array();


/*
	We need the start column so we can get each event[$ref] in the 
	right row and column.
	This also takes into account the selected "week start" admin option
	Range 0 - 6
*/
//$col = (gmdate('w', $start_point_local) - $cal_config['week_start']) % 7;

$col = (gmdate('w', $start_point_gmt) - $cal_config['week_start']) % 7;
$col = ($col < 0) ? $col + 7 : $col;
$row = 0;
$slot = 1;

// Work out what days are active with what type of events.
for ($doy_ref=0; $doy_ref < $end_point; $doy_ref++) {
	$todays_events = $events[$doy_ref];

	// Work out the current month and year

//	$ts = $start_point_local + ($doy_ref * (24*60*60)) ;

	$ts = $start_point_gmt + ($doy_ref * (24*60*60)) ;
	$t_day = gmdate('j', $ts);

	if(count($todays_events) >= 1) {
		$type = '';
		$grp = $prv = $pub = 0;
		foreach($todays_events AS $this_event) {
			$grp = ($this_event['event_access'] == 2) ? $grp + 1 : $grp;
			$prv = ($this_event['event_access'] == 1) ? $prv + 1 : $prv;
			$pub = ($this_event['event_access'] == 0) ? $pub + 1 : $pub;

			$total = $prv+$grp+$pub;
			if($total == 2) {
				break;
			}
		}
		$type = ($grp == 2 || ($grp == 1 && $total == 1)) ? 'grp' : ($grp == 1 ? 'mix' : $type);
		$type = ($prv == 2 || ($prv == 1 && $total == 1)) ? 'prv' : ($prv == 1 ? 'mix' : $type);
		$type = ($pub == 2 || ($pub == 1 && $total == 1)) ? 'pub' : ($pub == 1 ? 'mix' : $type);
	} else {
		$type = '';
	}
	$evts[$slot][$t_day]['year'] = gmdate('Y', $ts);
	$evts[$slot][$t_day]['month'] = gmdate('n', $ts);
	$evts[$slot][$t_day]['day'] = $t_day;
	$evts[$slot][$t_day]['row'] = $row;
	$evts[$slot][$t_day]['col'] = $col;
	$evts[$slot][$t_day]['type'] = (!empty($type)) ? $type : 'day';

	// Move to next month block if we've hit the end of the month
	if($t_day == gmdate('t',$ts)) {
		$row = 0;
		$slot++;
	}
	// Next column or back to the start of the next row.. Simple! :)
	$col = ($col+1) % 7;
	$row = ($col == 0) ? ($row + 1) : $row;
}
/*
echo "<plaintext>";
print_r($evts);
exit;
*/

// Set the headers here.
$year_header = $evts[1][1]['year'];
$year_header .= ($evts[1][1]['year'] != $evts[12][1]['year']) ? (' - '.$evts[12][1]['year']) : '';

$template->assign_vars(array(
	'N_YEAR' => $year_header
	)
);

// Now loop through the $evts array and create month tables from the data.
for($i=1; $i<=12; $i++) {
	$month_block = $evts[$i];
	$len_month = count($month_block);
	$col = $month_block[1]['col'];
	$row = 0;

	// Initialise the quarter
	if(($i-1) % 4 == 0) {
		$template->assign_block_vars('quarter', array());
	}

	// Initialise the month
	$template->assign_block_vars('quarter.month', array(
		'U_MONTH' => append_sid('cal_view_month.'.$phpEx.'?year='.$month_block[1]['year'].'&month='.$month_block[1]['month'].'&category='.$category),
		'L_MONTH' => $lang['datetime'][date('F', mktime(0,0,0,$month_block[1]['month'],1,$month_block[1]['year']))],
		'N_YEAR' => $month_block[1]['year']
		)
	);

	$day_head = (0 + $cal_config['week_start']) % 7;

	// Initialise the month header
	$template->assign_block_vars('quarter.month.month_header', array(
		'L_DAY_1' => $langday[($day_head)],
		'L_DAY_2' => $langday[($day_head+1)],
		'L_DAY_3' => $langday[($day_head+2)],
		'L_DAY_4' => $langday[($day_head+3)],
		'L_DAY_5' => $langday[($day_head+4)],
		'L_DAY_6' => $langday[($day_head+5)],
		'L_DAY_7' => $langday[($day_head+6)],
		)
	);

	// First week row initialised
	$template->assign_block_vars('quarter.month.week', array(
		'U_WEEK' => append_sid('cal_view_week.'.$phpEx.'?year='.$month_block[1]['year'].'&month='.$month_block[1]['month'].'&day='.$month_block[1]['day'].'&category='.$category)
		)
	);

	if($month_block[1]['col'] >= 1) {
		// Span the empty cells at the start of the month
		$template->assign_block_vars('quarter.month.week.empty_start', array(
			'SPAN' => $col
			)
		);
	}

	for($j=1; $j<=$len_month; $j++) {
		if(($month_block[$j]['col'] % 7) == 0 && $j != 1) {
			$template->assign_block_vars('quarter.month.week', array(
				'U_WEEK' => append_sid('cal_view_week.'.$phpEx.'?year='.$month_block[$j]['year'].'&month='.$month_block[$j]['month'].'&day='.$month_block[$j]['day'].'&category='.$category)
				)
			);
		}

		// Build link to display for that day if type != day ie: isn't empty
		if($month_block[$j]['type'] != 'day') {
			$u_day = append_sid("cal_display.$phpEx".'?year='.$month_block[$j]['year'].'&month='.$month_block[$j]['month'].'&day='.$month_block[$j]['day'].'&category='.$category);
			$n_day = '<a href="'.$u_day.'" class="day">'.$month_block[$j]['day'].'</a>';
		} else {
			$n_day = $month_block[$j]['day'];
		}

		$template->assign_block_vars('quarter.month.week.day', array(
			'C_DAY' => $month_block[$j]['type'],
			'N_DAY' => $n_day
			)
		);
		
	}
	if($month_block[$j]['col'] < 6 && $month_block[$j]['col'] > 0) {
		// Span the empty cells at the end of the month
		$template->assign_block_vars('quarter.month.week.empty_end', array(
			'SPAN' => (6 - $month_block[($j)]['col'])
			)
		);
	}
} // End year loop

/*
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
*/


if ($cal_config['allow_cat']) {
		// Set append_sid( x, true) to stop it escaping the ampersand and screwing up JS call

	$jump_cat = append_sid('cal_view_year.'.$phpEx.'?month='.$month.'&year='.$year , 1) .'&category=';
	$template->assign_block_vars('category_select', array(
		'L_FILTER_CATS_ALT' => $lang['Filter_cats_alt'],
		'L_FILTER_CATS' => $lang['Filter_cats'],
		'S_CATEGORY' => $category_select,
		'S_POST_ACTION' => append_sid('cal_view_year.'.$phpEx.'?&month='.$month.'&year='.$year, 1))
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
	'L_GO' => $lang['Go'],
	'L_BAK2CAL' => $lang['Cal_back2cal'],
	'FILTER' => $filter,
	'U_JUMP_CAT' => $jump_cat,
	'U_JUMP_MONTH' => append_sid('cal_view_year.'.$phpEx.'?year='.$year.'&category='.$category.'&month=', 1),
	'U_JUMP_YEAR' => append_sid('cal_view_year.'.$phpEx.'?month='.$month.'&category='.$category.'&year=', 1),
	'L_YEAR_START' => $lang['year_start'] ? $lang['year_start'] : 'Start Year from...',
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

/*
if(!$print) {
	$template->assign_vars(array(
		'PRINT_IMG' =>  ($images['Print_View']) ? $images['Print_View'] : 'images/icon_print.gif',
		'L_PRINT' => ($lang['Print_View']) ? $lang['Print_View'] : 'Printable version', 
		'U_PRINT' => append_sid('cal_view_month.'.$phpEx.'?&month='.$month.'&year='.$year.'&category='.$category.'&action=print'))
	);
}
*/

if ((($userdata && $userdata['user_id'] != '-1') && ($usersuggest == 'yes')) || ($caluser >= 2))
	{
	// Add Event button
	$button_add = button_add(append_sid('cal_add.'.$phpEx.'?month='.$month.'&year='.$year, 1), $category);
	// Admin Validate button
	$button_validate = button_validate(append_sid('cal_validate.'.$phpEx.'?action=getlist', 1));
	}

// Previous Year button
$url = append_sid('cal_view_year.'.$phpEx.'?month='.$lastmonth.'&year='.$lastyear.'&category='.$category, 1);
$url .= ($category) ? '&category='.$category : '';
$button_prev = button_prev($url);

// Next Year button
$url = append_sid('cal_view_year.'.$phpEx.'?month='.$nextmonth.'&year='.$nextyear.'&category='.$category, 1);
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