<?php
/*********************************************
*	Calendar Language Pack
*
*	Language:      English
*	Last Updated:  $Date: 2005-03-04 10:02:35 +0000 (Fri, 04 Mar 2005) $
*	Revision No.:  $Revision: 3 $
*
*********************************************/

// Calendar Addon MOD Language fields

$lang['Calendar'] = "Calendar";

$lang['Cal_description'] = "Description";
$lang['Cal_day'] = "Start Date";
$lang['Cal_hour'] = "Time";
$lang['End_day'] = "End Date";
$lang['End_time'] = "End Time";
$lang['Cal_subject'] = "Subject";
$lang['Cal_add_event'] = "Add event";
$lang['Cal_submit_event'] = "Submit event";

$lang['Cal_event_not_add'] = "Event not added...";
$lang['Cal_event_delete'] = "Event Deleted";
$lang['Cal_Del_mod'] = "Delete / Modify";
$lang['Cal_mod_only'] = "Modify";
$lang['Cal_back2cal'] = "Calendar Home";
$lang['Cal_mod_marked'] = "Modify event";
$lang['Cal_del_marked'] = "Delete event";
$lang['Cal_must_sel_event'] = "You must select an event.";
$lang['Cal_edit_own_event'] = "Sorry, you can only modify your own events.";
$lang['Cal_delete_event'] = "Sorry, you don't have permission to delete this event.";
$lang['Cal_not_enough_access'] = "Sorry, Access Denied";
$lang['Cal_must_member'] = "You must be authorised to connect and use this service";
$lang['Cal_alt_event'] = "Current :";
$lang['Validate'] = "Validate Events";
$lang['Cal_event_validated'] = "Event(s) have been Validated/Deleted as specified";
$lang['No events'] = "Currently there are no events for this date";
$lang['No_events_between'] = "There are no events between %s and %s";
$lang['group_event'] = "Group Event";
$lang['private_event'] = "Private Event";

$lang['No records'] = "No events require validation";
$lang['No records modify'] = "No events available to modify";
$lang['No information'] = "Insufficient information. Please fill out all the relevant info";
$lang['Date before today'] = "Sorry, you cannot submit events for dates that have already passed";
$lang['Date before start'] = "Sorry, you cannot submit events that finish before they start";
$lang['No date'] = "You must select a start and end date";
$lang['No time'] = "You must select a start and end time";


// New Version 2.0.0 Additions.
$lang['Config_Calendar'] = "Calendar Configuration";
$lang['Config_Calendar_explain'] = "Set all the necessary variables for your calendar below";
$lang['Cal_event_add'] = "Event Added/Modified...";
$lang['Cal_add4valid'] = "Event submitted for validation by an Administrator";

$lang['week_start'] = "Week start";
$lang['subject_length'] = "Subject length";
$lang['subject_length_explain'] = "Set the length of characters in an event subject(title) for the main month view<br><i>NB: For double-byte languages always select an even number of characters</i>";
$lang['cal_script_path_explain'] = "NOT CURRENTLY IN USE"; 
$lang['allow_anon'] = "Allow anonymous viewing";
$lang['allow_old'] = "Allow old events";
$lang['allow_old_explain'] = "Allow events to be posted for dates in the past";

$lang['show_headers'] = "Show the phpBB2 header info";
$lang['cal_date_explain'] = "Only use if you wish to use a different format from the forum date format <a href='http://www.php.net/date' target='_other'>date()</a>";
$lang['category'] = "Category";

$lang['Cal_config_updated'] = "Calendar Configuration Updated Sucessfully";
$lang['Cal_return_config'] = 'Click %sHere%s to return to Calendar Configuration'; 
$lang['allow_categories'] = "Use categories with events";
$lang['require_categories'] = "Require a category with events:";

$lang['No_cat_selected'] = "No category selected";
$lang['Edit_cat'] = "Edit Category";
$lang['Cats_explain'] = "Use this section to add, edit or delete the categories you use on your database. <br><br><b>NB:</b> Please note that if you delete a category that has been selected for an event it will not delete those records but it will stop users from being able to filter and view a deleted category.";
$lang['Cats_title'] = "Category Admin";
$lang['Must_enter_cat'] = "You must enter a category";
$lang['Cat_updated'] = "Category Updated";
$lang['Cat_added'] = "Category Added";
$lang['cat_removed'] = "Category Removed";
$lang['Add_new_cat'] = "Add new category";
$lang['Click_return_catadmin'] = 'Click %sHere%s to return to Category Administration';
$lang['Must_enter_valid_cat'] = "You must use valid alpha/numeric characters";
$lang['Filter_cats_alt'] = "Show selected category only";
$lang['Filter_cats'] = "View only...";
$lang['Month_jump'] = "Jump to...";

$lang['Recur_apply_to'] = "Changes apply to:";
$lang['Recur_future'] = "Future events";
$lang['Recur_solo'] = "This event only";
$lang['Recur_all'] = "All recurrences";
$lang['Cal_repeats'] = "Repeats every:";
$lang['until'] = "until";
$lang['Earliest recur before today'] = "Sorry, the earliest date in this set cannot be moved before today.\n<BR> Problem event on: ";
$lang['day'] = "day(s)";
$lang['month'] = "month(s)";
$lang['year'] = "year(s)";
$lang['Event_length'] = "Each event lasts:";
$lang['Recur_title'] = "Optional Recurring Info.";
$lang['Event_title'] = "Event Info.";
$lang['Event overlap'] = "Recurring events cannot repeat before the initial event has ended";
$lang['R_period too small'] = "The period available for recurring events is insufficient for any repeats";

// Recurring event failure for 28th - 31st events that span months that don't have that date
// Usage: The recurring event cannot take place on 31-02-2003 (Invalid date)
$lang['recur_no_such_date'] = "The recurring event cannot take place on %s (Invalid date)";

$lang['Add notes'] = "Add additional notes to this entry";
$lang['Add noted title'] = "Add Notes";
$lang['Split solo'] = "Split into 'stand-alone' entry <i>(will no longer update with related events)</i>";
$lang['Split solo title'] = "Split to seperate event";
$lang['Split future'] = "Change all event entries from this point forward";
$lang['Split future title'] = "Change all future events";
$lang['Edit all'] = "Change all related event entries";
$land['Edit all title'] = "Change all related events";
$lang['early_iteration'] = "(Earliest repetition after todays date)";

$lang['global subject'] = "Global subject";
$lang['global desc'] = "Global event info";

$lang['Del future'] = "Delete all events from this point forward";
$lang['Del all'] = "Delete all related event entries <i>(not including split entries)</i>";
$lang['Del this'] = "Delete this single event";

$lang['Event_num'] = "Event number:";
$lang['of'] = "<i>of</i>";

$lang['Additional info'] = "Additional information:";
$lang['Event specific'] = "(specific to 'this' event):";

$lang['allow_user_post_default'] = "Default access level for ALL registered users";

$lang['no_public'] = 'No public access';
$lang['view_only'] = 'View only';
$lang['view_suggest'] = 'View,Suggest Events';
$lang['view_add'] = 'View,Add Events';
$lang['view_edit_own'] = 'View,Add (Edit/Delete own)';
$lang['cal_admin'] = 'Calendar Admin';

$lang['Invalid date'] = "One or both of the dates you have submitted is invalid";
$lang['Empty subject'] = "You must enter a subject for your event";
$lang['Empty description'] = "You must enter a description for your event";
$lang['max'] = "Maximum:";
$lang['Return'] = "Go back to: ";

$lang['View All'] = "View All";
$lang['Calendar_Level'] = "Calendar Level";
$lang['Calendar_Categories'] = "Calendar Categories";
$lang['Calendar Config'] = "Calendar Config";

$lang['days'] = "day(s)";
$lang['weeks'] = "week(s)";
$lang['months'] = "month(s)";
$lang['years'] = "year(s)";

$lang['view_year'] = "Year View";
$lang['view_month'] = "Month View";
$lang['view_week'] = "Week View";
$lang['view_day'] = "Day/Event View";
$lang['view_list'] = "List View";
$lang['view'] = "View";
$lang['printer_friendly_ver'] = "Printer Friendly Version";

$lang['Submitted_by'] = 'Submitted by';

$lang['No_modify_old'] = "Sorry, you can't edit an old event";
$lang['Cat_in_use'] = "This category is linked to existing events and cannot be deleted";

// DEV lang 2.0.25

$lang['require_time'] = "Require start/end times to be entered with new events";
$lang['allow_private_event'] = "Allow registered users to add private events";
$lang['allow_group_event'] = "Allow registered users to limit events to their own groups";

$lang['event_access'] = "Calendar event viewable by:";
$lang['private_event'] = "Yourself only";
$lang['public_event'] = "All EMBA Groups!";
$lang['ug_event'] = "Your EMBA Group(s) only";
$lang['group_select'] = "EMBA Group(s):";

$lang['group_event_explain'] = "<i>Use CTRL to select multiple EMBA Groups.</i>";
$lang['No_private_events'] = "You are not permitted to add private events";
$lang['time_format'] = "Time Format";

// DEV lang 2.0.31

$lang['c_first'] = '1st';
$lang['c_second'] = '2nd';
$lang['c_third'] = '3rd';
$lang['c_fourth'] = '4th';
$lang['c_fifth'] = '5th';
$lang['OR_every'] = 'OR every:';

// DEV 2.0.4
$lang['year_start'] = 'Start Year from...';

// DEV 2.0.35
$lang['admin_private_view'] = 'Allow admins to view private events:';
$lang['admin_private_filter'] = '[Admin] Private Events';

// DEV 2.0.37 
$lang['cat_color'] = 'Link Color Code'; 
$lang['cat_bg_color'] = 'Background Color Code'; 
$lang['cat_hover_color'] = 'Hover Color Code'; 
$lang['cat_hover_bg_color'] = 'Hover Background Color Code'; 
$lang['cat_example'] = 'Example'; 
$lang['example'] = 'Example';


// DEV 2.0.39
$lang['not_logged_in'] = 'Not Logged In';
$lang['Cal_no_recur_access'] = 'You do not have permission to add recurring events';
$lang['Cal_suggest_event'] = 'Suggest Event';
$lang['No_groups_to_mod'] = 'You have no group events to moderate/admin';

// Added 03/03/2005
$lang['all_day_event'] = 'All Day';
$lang['Legend'] = 'Legend:'; 

// Added 13/04/2005
$lang['no_action'] = 'No action selected';

// Added 28/04/2005
$lang['need_r_stop_date'] = 'You must specify a full \'<b>until...</b>\' date for your recurring event chain';
$lang['r_every_x_period_miss'] = 'You must specify a period number AND type (eg: 2 weeks) for recuring event';
$lang['r_every_nth_period_miss'] = 'You must specify a Nth AND xxxday for recurring event';

// Added 13/05/2005
$lang['Date before today_detail'] = "Sorry, you cannot submit events for dates that have already passed <br /><br />Current date/time:<b> %s </b><br/>Submitted date/time: <b> %s </b>";
?>