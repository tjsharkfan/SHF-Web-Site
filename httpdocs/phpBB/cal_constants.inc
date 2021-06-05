<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-05-06 11:03:36 +0100 (Fri, 06 May 2005) $
*	$Revision: 84 $
*
*********************************************/
 
/*###############################################################
## Mod Title: 	phpBB2 Calendar Pro
## Mod Version: 2.0.38
## Author:      WebSnail < http://www.snailsource.com/ >
## Description: Constants for use with Session reporting
##
## NOTE: Please read Calendar-README.txt for version information
###############################################################*/



//###############################################################
// Calendar MOD - SESSION CONSTANTS

define('CAL_DEFAULT', -50);
define('CAL_YEAR_VIEW', -51);
define('CAL_MONTH_VIEW', -52);
define('CAL_WEEK_VIEW', -53);
define('CAL_DAY_VIEW', -54);
define('CAL_LIST_VIEW', -55);
define('CAL_VIEW', -56);
define('CAL_ADD', -57);
define('CAL_MODIFY', -58);
define('CAL_DELETE', -59);
define('CAL_VALIDATE', -60);
define('CAL_INSTALL', -61);

define('BULLET_DEFAULT', '*');		// Regular events
define('BULLET_GROUP', '<font color="red">(G)</font>');		// Group restricted events
define('BULLET_PRIVATE', '<font color="green">(P)</font>');	// Private events
define('BULLET_SPACE', TRUE);		// TRUE/FALSE depending on whether you want a space or not after bullet character(s)

define('INDICATE_SPLIT', '~');		// Indicate this event was split from recurring chain.

?>