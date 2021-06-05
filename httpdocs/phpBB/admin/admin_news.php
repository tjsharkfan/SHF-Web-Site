<?php
/***************************************************************************
 *                              admin_news.php
 *                            -------------------
 *   begin                : Thursday, Apr 3, 2003
 *   copyright            : (C) 2003 Garold W. Robinson
 *   email                : setheep@hotmail.com
 *
 *
 *
 *
 ***************************************************************************/



if($setmodules == 1)
{
	$file = basename(__FILE__);
	$module['News Bar']['Configuration'] = "$file?mode=config";
	return;
}
define('IN_PHPBB', 1);
//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
include($phpbb_root_path . 'includes/functions_news.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $board_config['default_lang'] . '/lang_admin_news.'.$phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . NEWS_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];
         $new[$config_name]= stripslashes($new[$config_name]);


		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . NEWS_TABLE . " SET
				config_value = '" . addslashes($new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_news_updated'] . "<br /><br />" . sprintf($lang['Click_return_newsadmin'], "<a href=\"" . append_sid("admin_news.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}


$template->set_filenames(array(
	"body" => "admin/board_news_body.tpl")
);

//
// Escape any quotes in the site description for proper display in the text
// box on the admin page 
//
$news_style_select = nss_select($new['news_style'], 'news_style');
$news_bold_select = nbs_select($new['news_bold'], 'news_bold');
$news_ital_select = nis_select($new['news_ital'], 'news_ital');
$news_under_select = nus_select($new['news_under'], 'news_under');
$news_size_select = ns_select($new['news_size'], 'news_size');
$news_color_select = nc_select($new['news_color'], 'news_color');
$scroll_speed_select = ssp_select($new['scroll_speed'], 'scroll_speed');
$scroll_action_select = sa_select($new['scroll_action'], 'scroll_action');
$scroll_behavior_select = sb_select($new['scroll_behavior'], 'scroll_behavior');
$scroll_size_select = ss_select($new['scroll_size'], 'scroll_size');
$template->assign_vars(array(
	"S_NEWS_CONFIG_ACTION" => append_sid("admin_news.$phpEx"),
        "L_NEWS_COLOR" => $lang['News_Color'],
        "L_NEWS_STYLE" => $lang['News_style'],
        "L_NEWS_BOLD" => $lang['News_bold'],
        "L_NEWS_ITAL" => $lang['News_ital'],
        "L_NEWS_UNDER" => $lang['News_under'],
   "L_NEWS_SIZE" => $lang['News_size'],
  "L_NEWS_TITLE" => $lang['News_Title'],

  "L_NEWS_BLOCK" => $lang['News_Block'],
  "L_SCROLL_SPEED" => $lang['scroll_speed'],
  "L_SCROLL_ACTION" => $lang['scroll_action'],
  "L_SCROLL_BEHAVIOR" =>$lang['scroll_behavior'],
  "L_SCROLL_SIZE" => $lang['scroll_size'],
       		"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'],


        "NEWS_TITLE" => $new['news_title'],
        "NEWS_BLOCK" => $new['news_block'],
        "NEWS_STYLE_SELECT" => $news_style_select,
        "NEWS_BOLD_SELECT" => $news_bold_select,
        "NEWS_ITAL_SELECT" => $news_ital_select,
        "NEWS_UNDER_SELECT" => $news_under_select,
        "NEWS_SIZE_SELECT" => $news_size_select,
         "NEWS_COLOR_SELECT" => $news_color_select,
         "SCROLL_SPEED_SELECT" => $scroll_speed_select,
         "SCROLL_ACTION_SELECT" => $scroll_action_select,
         "SCROLL_BEHAVIOR_SELECT" => $scroll_behavior_select,
         "SCROLL_SIZE_SELECT" => $scroll_size_select)
 );



$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
