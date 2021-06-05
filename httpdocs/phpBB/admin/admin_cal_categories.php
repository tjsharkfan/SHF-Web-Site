<?php
/*********************************************
*	Calendar Pro
*
*	$Author: Martin $
*	$Date: 2005-04-14 20:50:27 +0100 (Thu, 14 Apr 2005) $
*	$Revision: 63 $
*
*********************************************/

/***************************************************************************
 *                          admin_cal_categories.php
 *                            -------------------
 * Copyright:   (C) 2002 SnailSource.com
 * Mod Title: 	phpBB2 Calendar
 * Mod Version: 2.0.35
 * Author:      WebSnail < http://www.snailsource.com >
 *
 *   BASED ON: admin_words.php  by phpBB Group
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Calendar']['Calendar_Categories'] = "$file";
	return;
}

//
// Load default header
//
$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
require($phpbb_root_path . 'cal_settings.php');

require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_calendar.' . $phpEx);
include_once($phpbb_root_path . 'cal_functions.'.$phpEx); 

$cat_colors_css = cat_colors_css(); 
$template->assign_vars(array( 
   'CATEGORY_CSS' => $cat_colors_css) 
); 


if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}
else 
{
	//
	// These could be entered via a form button
	//
	if( isset($HTTP_POST_VARS['add']) )
	{
		$mode = "add";
	}
	else if( isset($HTTP_POST_VARS['save']) )
	{
		$mode = "save";
	}
	else
	{
		$mode = "";
	}
}

if( $mode != "" )
{
	if($cat_id < 100 && $cat_id != '') {
		message_die(GENERAL_ERROR, "Invalid Category ID", "Error", __LINE__, __FILE__, '');
	}

	if( $mode == "edit" || $mode == "add" )
	{
		$cat_id = ( isset($HTTP_GET_VARS['id']) ) ? $HTTP_GET_VARS['id'] : 0;

		$template->set_filenames(array(
			"body" => "admin/cal_cats_edit_body.tpl")
		);

		$s_hidden_fields = '';

		if( $mode == "edit" )
		{
			if( $cat_id || ($cat_id == '0'))
			{
				$sql = "SELECT * 
					FROM " . CAL_CATS . " 
					WHERE cat_id = $cat_id";
				if(!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not query cat_categories table", "Error", __LINE__, __FILE__, $sql);
				}

				$cat_info = $db->sql_fetchrow($result);
				$s_hidden_fields .= '<input type="hidden" name="id" value="' . $cat_id . '" />';
			}
			else
			{
				message_die(GENERAL_MESSAGE, $lang['No_cat_selected']);
			}
		}

		$template->assign_vars(array(
			"CAT" => stripslashes($cat_info['cat_name']),
			"CAT_COLOR" => test_color($cat_info['cat_color']),
			"CAT_BG_COLOR" => test_color($cat_info['cat_bg_color']), 
			"CAT_HOVER_COLOR" => test_color($cat_info['cat_hover_color']), 
			"CAT_HOVER_BG_COLOR" => test_color($cat_info['cat_hover_bg_color']), 
			"CAT_COL_CLASS" => "cal_".$cat_info['cat_id'],

			"L_CAT_COLOR" => (isset($lang['cat_color']) ? $lang['cat_color'] : "Link Color Code"), 
			"L_CAT_BG_COLOR" => (isset($lang['cat_bg_color']) ? $lang['cat_bg_color'] : "Background Color Code"),
			"L_CAT_HOVER_COLOR" => (isset($lang['cat_hover_color']) ? $lang['cat_hover_color'] : "Hover Color Code"), 
			"L_CAT_HOVER_BG_COLOR" => (isset($lang['cat_hover_bg_color']) ? $lang['cat_hover_bg_color'] : "Hover Background Color Code"),
			"L_CATS_TITLE" => $lang['Cats_title'],
			"L_CATS_TEXT" => $lang['Cats_explain'],
			"L_CAT_EDIT" => $lang['Edit_cat'],
			"L_CAT" => $lang['category'],
			"L_SUBMIT" => $lang['Submit'],

			"S_CATS_ACTION" => append_sid("admin_cal_categories.$phpEx"),
			"S_HIDDEN_FIELDS" => $s_hidden_fields)
		);

		$template->pparse("body");

		include('./page_footer_admin.'.$phpEx);
	}
	else if( $mode == "save" )
	{
		$cat_id = ( isset($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : 0;
		$cat_name = ( isset($HTTP_POST_VARS['cat']) ) ? trim($HTTP_POST_VARS['cat']) : "";
		$cat_color = ( isset($HTTP_POST_VARS['cat_color']) ) ? trim($HTTP_POST_VARS['cat_color']) : "";

		$cat_bg_color = ( isset($HTTP_POST_VARS['cat_bg_color']) ) ? trim($HTTP_POST_VARS['cat_bg_color']) : ""; 
		$cat_hover_color = ( isset($HTTP_POST_VARS['cat_hover_color']) ) ? trim($HTTP_POST_VARS['cat_hover_color']) : ""; 
		$cat_hover_bg_color = ( isset($HTTP_POST_VARS['cat_hover_bg_color']) ) ? trim($HTTP_POST_VARS['cat_hover_bg_color']) : "";

		// Test for a valid Hex color code
		$cat_color = test_color($cat_color);

		$cat_bg_color = test_color($cat_bg_color); 
		$cat_hover_color = test_color($cat_hover_color); 
		$cat_hover_bg_color = test_color($cat_hover_bg_color); 

		if($cat_name == "")
		{
			message_die(GENERAL_MESSAGE, $lang['Must_enter_cat']);
		}
		if( $cat_id )
		{
			$sql = "UPDATE " . CAL_CATS . " 
				SET cat_name = '" . addslashes($cat_name) . "', cat_color = '$cat_color', 
					cat_bg_color = '$cat_bg_color', cat_hover_color = '$cat_hover_color', 
					cat_hover_bg_color = '$cat_hover_bg_color' 
				WHERE cat_id = $cat_id";
			$message = $lang['Cat_updated'];
		}
		else
		{
			$sql = 'SELECT cat_id FROM '.CAL_CATS.' ORDER BY cat_id DESC';
			if(!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, "Could not insert data into cal_category table", $lang['Error'], __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$new_id = $row['cat_id'] >= 100 ? $row['cat_id']+1 : 100;

			$sql = "INSERT INTO " . CAL_CATS . " (cat_id, cat_name, cat_color, cat_bg_color, cat_hover_color, cat_hover_bg_color) 
				VALUES (".$new_id.", '" . addslashes($cat_name) . "', '$cat_color', '$cat_bg_color', '$cat_hover_color', '$cat_hover_bg_color')"; 
			$message = $lang['Cat_added'];
		}

		if(!$result = $db->sql_query($sql))
		{
			// echo mysql_error(); echo ": ".$sql; exit;
			message_die(GENERAL_ERROR, "Could not insert data into cal_category table", $lang['Error'], __LINE__, __FILE__, $sql);
		}

		$message .= "<br /><br />" . sprintf($lang['Click_return_catadmin'], "<a href=\"" . append_sid("admin_cal_categories.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
	else if( $mode == "delete" )
	{
		if( isset($HTTP_POST_VARS['id']) ||  isset($HTTP_GET_VARS['id']) )
		{
			$cat_id = ( isset($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];
		}
		else
		{
			$cat_id = 0;
		}

		if( $cat_id || ($cat_id == '0'))
		{
			$sql_chk = "SELECT * FROM ".CAL_TABLE." WHERE category = $cat_id";
			if(!$result = $db->sql_query($sql_chk))
			{
				message_die(GENERAL_ERROR, "Could not check for categories in  ".CAL_TABLE." table", $lang['Error'], __LINE__, __FILE__, $sql);
			}
			else {
				if($db->sql_numrows($result) >= 1) {
					message_die(GENERAL_ERROR, $lang['Cat_in_use'], $lang['Error'], __LINE__, __FILE__, '');
				}
			}
			$sql = "DELETE FROM ".CAL_CATS." WHERE cat_id = $cat_id";

			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not remove data from ".CAL_CATS." table", $lang['Error'], __LINE__, __FILE__, $sql);
			}

			$message = $lang['cat_removed'] . "<br /><br />" . sprintf($lang['Click_return_catadmin'], "<a href=\"" . append_sid("admin_cal_categories.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_cat_selected']);
		}
	}
}
else
{
	$template->set_filenames(array(
		"body" => "admin/cal_cats_list_body.tpl")
	);

	$sql = "SELECT * 
		FROM " . CAL_CATS . " WHERE cat_id >= 100
		ORDER BY cat_name";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Could not query cal_categories table", $lang['Error'], __LINE__, __FILE__, $sql);
	}

	$cat_rows = $db->sql_fetchrowset($result);
	$cat_count = count($cat_rows);

	$template->assign_vars(array(
		"L_CATS_TITLE" => $lang['Cats_title'],
		"L_CATS_TEXT" => $lang['Cats_explain'],
		"L_CAT" => $lang['category'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ADD_CAT" => $lang['Add_new_cat'],
		"L_ACTION" => $lang['Action'],

		"L_CAT_COLOR" => $lang['cat_color'],
		"L_CAT_BG_COLOR" => $lang['cat_bg_color'], 
		"L_CAT_HOVER_COLOR" => $lang['cat_hover_color'], 
		"L_CAT_HOVER_BG_COLOR" => $lang['cat_hover_bg_color'],

		"L_CAT_EXAMPLE" => $lang['cat_example'],
		"L_EXAMPLE" => $lang['example'],

		"S_CATS_ACTION" => append_sid("admin_cal_categories.$phpEx"),
		"S_HIDDEN_FIELDS" => '')
	);

	for($i = 0; $i < $cat_count; $i++)
	{
		$cat_name = $cat_rows[$i]['cat_name'];
		$cat_id = $cat_rows[$i]['cat_id'];
		$cat_color = $cat_rows[$i]['cat_color'];

		$cat_bg_color = $cat_rows[$i]['cat_bg_color']; 
		$cat_hover_color = $cat_rows[$i]['cat_hover_color']; 
		$cat_hover_bg_color = $cat_rows[$i]['cat_hover_bg_color'];

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("cats", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"CAT" => stripslashes($cat_name),
			"CAT_COLOR" => !empty($cat_color) ? $cat_color : '',

			"CAT_BG_COLOR" => !empty($cat_bg_color) ? $cat_bg_color : '', 
			"CAT_HOVER_COLOR" => !empty($cat_hover_color) ? $cat_hover_color : '', 
			"CAT_HOVER_BG_COLOR" => !empty($cat_hover_bg_color) ? $cat_hover_bg_color : '', 
			"CAT_COL_CLASS" => "cal_".$cat_id, 

			"U_CAT_EDIT" => append_sid("admin_cal_categories.$phpEx?mode=edit&amp;id=$cat_id"),
			"U_CAT_DELETE" => append_sid("admin_cal_categories.$phpEx?mode=delete&amp;id=$cat_id"))
		);
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);
exit;

function test_color($color) {
	if(empty($color)) {
		return '';
	}
	$color = preg_replace("/\#/", "", $color);
	// Test color code is hex

	$testcolor = preg_replace("/\#/", "", $color); 
	$testcolor = trim(strtolower($testcolor)); 
	if(strlen($testcolor)!=6) { 
		message_die(GENERAL_ERROR, "Color Hex code invalid for category", $lang['Error'], __LINE__, __FILE__); 
	} 
	$validhex = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 
	// Test color code is hex 
	for($j = 0; $j < strlen($testcolor); $j++) { 
		if(!(in_array($testcolor[$j], $validhex))) { 
			message_die(GENERAL_ERROR, "Color Hex code invalid for category", $lang['Error'], __LINE__, __FILE__); 
		} 
	} 
	return $testcolor;
}

?>