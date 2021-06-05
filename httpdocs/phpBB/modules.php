<?php
/*
######################################################## 
## Mod Title:   Gallery - phpBB2 Integration 
## Mod Version: g144_pl2b
## Author:       Martin Smallridge < www.snailsource.com > 
## Description:  This MOD integrates Gallery 1.4.4_pl2 with the
##		 current phpBB2 users and usergroups 
##               For more information please check README.txt 
##
## 
## Installation Level:  intermediate 
## Installation Time:   5-15 Minutes 
## Files To Edit:       ? 
## Included Files:      (see README.txt) 
######################################################## 
## 
## Installation Notes: 
## 
## (see README.txt) 
##
######################################################## 
*/
define('MODULES_PATH', './modules/');


$op = ( isset($HTTP_POST_VARS['op']) ) ? $HTTP_POST_VARS['op'] : (isset($HTTP_GET_VARS['op']) ? $HTTP_GET_VARS['op'] : '');
switch ($op)
{
    case 'modload':
	// Added with changes in Security for PhpBB2.
	define('IN_PHPBB', true);
        define ("LOADED_AS_MODULE","1");

	$phpbb_root_path = "./";
	// connect to phpbb
	include_once($phpbb_root_path . 'extension.inc');
	include_once($phpbb_root_path . 'common.'.$phpEx);
	include_once($phpbb_root_path . 'includes/functions.'.$phpEx);

	// Because all extract variables get unset in common.php we must get them AFTER.
	// phpBB2 is translating all the $_POST, $_GET to the older $HTTP_XXX_VAR arrays so we'll use that.

	/*
	** Prevent hackers from overwriting one HTTP_ global using another one.  For example,
	** appending "?HTTP_POST_VARS[gallery]=xxx" to the url would cause extract
	** to overwrite HTTP_POST_VARS when it extracts HTTP_GET_VARS
	*/
	$scrubList = array('HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_POST_FILES');
	if (function_exists("version_compare") && version_compare(phpversion(), "4.1.0", ">=")) {
		array_push($scrubList, "_GET", "_POST", "_COOKIE", "_FILES", "_REQUEST");
	}
	foreach ($scrubList as $outer) {
		foreach ($scrubList as $inner) {
			unset(${$outer}[$inner]);
		}
	}

	if (!empty($HTTP_GET_VARS)) {
		extract($HTTP_GET_VARS);
	}
	if (!empty($HTTP_POST_VARS)) {
		extract($HTTP_POST_VARS);
	}
	if (is_array($HTTP_COOKIE_VARS)) {
		extract($HTTP_COOKIE_VARS);
	}

	foreach($HTTP_POST_FILES as $key => $value) {
		${$key."_name"} = $value["name"];
		${$key."_size"} = $value["size"];
		${$key."_type"} = $value["type"];
		${$key} = $value["tmp_name"];
	}

	// Start session management
	//
	$userdata = session_pagestart($user_ip, PAGE_INDEX);
	init_userprefs($userdata);
	//
	// End session management

        // Security fix
        if (ereg("\.\.",$name) || ereg("\.\.",$file))
        {
            echo 'Nice try :-)';
            break;
        } else {
		include(MODULES_PATH."$name/$file.$phpEx");
        }
        break;

    default:
        die ("Sorry, you can't access this file directly...");
        break;
}
?>