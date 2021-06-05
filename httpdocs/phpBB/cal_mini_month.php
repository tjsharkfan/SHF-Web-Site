<?php
/*********************************************
*	Calendar Pro
*
*	$Author: martin $
*	$Date: 2004/08/25 12:33:45 $
*	$Revision: 1.1 $
*
*********************************************/

/*###############################################################
## Mod Title: 	phpBB2 Calendar
## Mod Version: 2.0.35
## Author:      WebSnail < http://www.snailsource.com/ >
## Description: Variable settings for Calendar.php
##
## NOTE: Please read Calendar-README.txt for version information
###############################################################*/

// Temp setting
$span_js_on = TRUE;

include_once($phpbb_root_path.'cal_constants.inc');
$session_loc = CAL_MONTH_VIEW;
include_once($phpbb_root_path.'cal_main.inc');
if ($cal_config['allow_anon'] != '1' && $caluser < 1) {
	message_die(GENERAL_ERROR, $lang['Cal_not_enough_access']);
}

$base_url = isset($base_url) ? $base_url : './';
$show_months = isset($show_months) ? ($show_months <= 4 ? $show_months : 4 ) : 1;	
//NB We set a hard limit of 4 months to avoid stupid formatting problems later

$template->set_filenames(array(
	'body' => 'cal_mini_month.tpl')
);
$template->assign_vars(array(
	'URL_ROOT' => $base_url)
	);

$tz_diff = mytime();

$pt = '*';

/*
	If a month & year are passed then we start the year view from that point
	If not then we start from January of the year passed or the current year
*/

$month = empty($month) ? gmdate( 'm', (time() + $tz_diff) ) : $month;
$year =  empty($year) ? gmdate( 'Y', (time() + $tz_diff) ) : $year;

// Adjust the week start for Saturday starts from +6 -> -1 for ease of calculation
$wk_start = ($cal_config['week_start'] > 1) ? ($cal_config['week_start'] - 7) : $cal_config['week_start'];

$start_point_gmt = gmmktime(0,0,0,$month,1,$year);			// Get start time for year in GMT

$end_month = $month+$show_months;
$lastday = gmdate('t',  gmmktime(0,0,0,$end_month,1,$year));
$end_point_gmt = gmmktime(23,59,59,$end_month,$lastday,$year);		// Get end time for year in GMT

// To get the local time we have to subtract the tz_diff from the GMT timestamp
$start_point_local = $start_point_gmt - $tz_diff;
$end_point_local = $end_point_gmt - $tz_diff;

$day_head = (0+$cal_config['week_start'])%7;

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




$end_point = intval(($end_point_local-$start_point_local)/(24*60*60));
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

// Now loop through the $evts array and create month tables from the data.
$template->assign_block_vars('set', array());

for($i=1; $i<=$show_months; $i++) {
	$month_block = $evts[$i];
	$len_month = count($month_block);
	$col = $month_block[1]['col'];
	$row = 0;

	// Initialise the month
	$template->assign_block_vars('set.month', array(
		'U_MONTH' => append_sid('cal_view_month.'.$phpEx.'?year='.$month_block[1]['year'].'&month='.$month_block[1]['month'].'&category='.$category),
		'L_MONTH' => $lang['datetime'][date('F', mktime(0,0,0,$month_block[1]['month'],1,$month_block[1]['year']))],
		'N_YEAR' => $month_block[1]['year']
		)
	);

	$day_head = (0 + $cal_config['week_start']) % 7;

	// Initialise the month header
	$template->assign_block_vars('set.month.month_header', array(
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
	$template->assign_block_vars('set.month.week', array(
		'U_WEEK' => append_sid('cal_view_week.'.$phpEx.'?year='.$month_block[1]['year'].'&month='.$month_block[1]['month'].'&day='.$month_block[1]['day'].'&category='.$category)
		)
	);

	if($month_block[1]['col'] >= 1) {
		// Span the empty cells at the start of the month
		$template->assign_block_vars('set.month.week.empty_start', array(
			'SPAN' => $col
			)
		);
	}

	for($j=1; $j<=$len_month; $j++) {
		if(($month_block[$j]['col'] % 7) == 0 && $j != 1) {
			$template->assign_block_vars('set.month.week', array(
				'U_WEEK' => append_sid('cal_view_week.'.$phpEx.'?year='.$month_block[$j]['year'].'&month='.$month_block[$j]['month'].'&day='.$month_block[$j]['day'].'&category='.$category)
				)
			);
		}

		// Build link to display for that day if type != day ie: isn't empty
		if($month_block[$j]['type'] != 'day') {
			$u_day = append_sid("cal_display.$phpEx".'?year='.$month_block[$j]['year'].'&month='.$month_block[$j]['month'].'&day='.$month_block[$j]['day'].'&category='.$category);
			$n_day = '<a href="'.$base_url.$u_day.'" class="day">'.$month_block[$j]['day'].'</a>';
		} else {
			$n_day = $month_block[$j]['day'];
		}

		$template->assign_block_vars('set.month.week.day', array(
			'C_DAY' => $month_block[$j]['type'],
			'N_DAY' => $n_day
			)
		);
		
	}
	if($month_block[$j]['col'] < 6 && $month_block[$j]['col'] > 0) {
		// Span the empty cells at the end of the month
		$template->assign_block_vars('set.month.week.empty_end', array(
			'SPAN' => (6 - $month_block[($j)]['col'])
			)
		);
	}
} // End year loop

$template->pparse('body');
?>