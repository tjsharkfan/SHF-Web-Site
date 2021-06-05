<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-05-06 10:38:08 +0100 (Fri, 06 May 2005) $
*	$Revision: 82 $
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


define('CAL_CATS', 	($table_prefix . 'cal_categories'));
define('CAL_CONFIG', 	($table_prefix . 'cal_config'));
define('CAL_GROUP_EVENT', ($table_prefix . 'cal_group_event'));
define('CAL_RECUR', 	($table_prefix . 'cal_recur'));
define('CAL_TABLE', 	($table_prefix . 'calendar'));

/* Deprecated to Cal_constant.inc as defined constants
$split_flag = '~';
$recur_flag = '_';
*/

?>