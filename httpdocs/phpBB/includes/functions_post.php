<?php
/***************************************************************************
 *                            functions_post.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: functions_post.php,v 1.9.2.34 2003/06/09 15:45:10 psotfx Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;');

$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');

//
// This function will prepare a posted message for
// entry into the database.
//
function prepare_message($message, $html_on, $bbcode_on, $smile_on, $bbcode_uid = 0)
{
	global $board_config, $html_entities_match, $html_entities_replace;

	//
	// Clean up the message
	//
	$message = trim($message);

	if ($html_on)
	{
		$allowed_html_tags = split(',', $board_config['allow_html_tags']);

		$end_html = 0;
		$start_html = 1;
		$tmp_message = '';
		$message = ' ' . $message . ' ';

		while ($start_html = strpos($message, '<', $start_html))
		{
			$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $end_html + 1, ($start_html - $end_html - 1)));

			if ($end_html = strpos($message, '>', $start_html))
			{
				$length = $end_html - $start_html + 1;
				$hold_string = substr($message, $start_html, $length);

				if (($unclosed_open = strrpos(' ' . $hold_string, '<')) != 1)
				{
					$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($hold_string, 0, $unclosed_open - 1));
					$hold_string = substr($hold_string, $unclosed_open - 1);
				}

				$tagallowed = false;
				for ($i = 0; $i < sizeof($allowed_html_tags); $i++)
				{
					$match_tag = trim($allowed_html_tags[$i]);
					if (preg_match('#^<\/?' . $match_tag . '[> ]#i', $hold_string))
					{
						$tagallowed = (preg_match('#^<\/?' . $match_tag . ' .*?(style[ ]*?=|on[\w]+[ ]*?=)#i', $hold_string)) ? false : true;
					}
				}

				$tmp_message .= ($length && !$tagallowed) ? preg_replace($html_entities_match, $html_entities_replace, $hold_string) : $hold_string;

				$start_html += $length;
			}
			else
			{
				$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $start_html, strlen($message)));

				$start_html = strlen($message);
				$end_html = $start_html;
			}
		}

		if ($end_html != strlen($message) && $tmp_message != '')
		{
			$tmp_message .= preg_replace($html_entities_match, $html_entities_replace, substr($message, $end_html + 1));
		}

		$message = ($tmp_message != '') ? trim($tmp_message) : trim($message);
	}
	else
	{
		$message = preg_replace($html_entities_match, $html_entities_replace, $message);
	}

	if($bbcode_on && $bbcode_uid != '')
	{
		$message = bbencode_first_pass($message, $bbcode_uid);
	}

	return $message;
}

function unprepare_message($message)
{
	global $unhtml_specialchars_match, $unhtml_specialchars_replace;

	return preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $message);
}

//
// Prepare a message for posting
// 
function prepare_post(&$mode, &$post_data, &$bbcode_on, &$html_on, &$smilies_on, &$error_msg, &$username, &$bbcode_uid, &$subject, &$message, &$poll_title, &$poll_options, &$poll_length)
{
	global $board_config, $userdata, $lang, $phpEx, $phpbb_root_path;

	// Check username
	if (!empty($username))
	{
		$username = phpbb_clean_username($username);

		if (!$userdata['session_logged_in'] || ($userdata['session_logged_in'] && $username != $userdata['username']))
		{
			include($phpbb_root_path . 'includes/functions_validate.'.$phpEx);

			$result = validate_username($username);
			if ($result['error'])
			{
				$error_msg .= (!empty($error_msg)) ? '<br />' . $result['error_msg'] : $result['error_msg'];
			}
		}
		else
		{
			$username = '';
		}
	}

	// Check subject
	if (!empty($subject))
	{
		$subject = htmlspecialchars(trim($subject));
	}
	else if ($mode == 'newtopic' || ($mode == 'editpost' && $post_data['first_post']))
	{
		$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['Empty_subject'] : $lang['Empty_subject'];
	}

	// Check message
	if (!empty($message))
	{
		$bbcode_uid = ($bbcode_on) ? make_bbcode_uid() : '';
		$message = prepare_message(trim($message), $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
	}
	else if ($mode != 'delete' && $mode != 'poll_delete') 
	{
		$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['Empty_message'] : $lang['Empty_message'];
	}

	//
	// Handle poll stuff
	//
	if ($mode == 'newtopic' || ($mode == 'editpost' && $post_data['first_post']))
	{
		$poll_length = (isset($poll_length)) ? max(0, intval($poll_length)) : 0;

		if (!empty($poll_title))
		{
			$poll_title = htmlspecialchars(trim($poll_title));
		}

		if(!empty($poll_options))
		{
			$temp_option_text = array();
			while(list($option_id, $option_text) = @each($poll_options))
			{
				$option_text = trim($option_text);
				if (!empty($option_text))
				{
					$temp_option_text[$option_id] = htmlspecialchars($option_text);
				}
			}
			$option_text = $temp_option_text;

			if (count($poll_options) < 2)
			{
				$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['To_few_poll_options'] : $lang['To_few_poll_options'];
			}
			else if (count($poll_options) > $board_config['max_poll_options']) 
			{
				$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['To_many_poll_options'] : $lang['To_many_poll_options'];
			}
			else if ($poll_title == '')
			{
				$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['Empty_poll_title'] : $lang['Empty_poll_title'];
			}
		}
	}

	return;
}

//
// Post a new topic/reply/poll or edit existing post/poll
//
function submit_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id, &$topic_type, &$bbcode_on, &$html_on, &$smilies_on, &$attach_sig, &$bbcode_uid, &$post_username, &$post_subject, &$post_message, &$poll_title, &$poll_options, &$poll_length)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;

	include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

	$current_time = time();

	if ($mode == 'newtopic' || $mode == 'reply' || $mode == 'editpost') 
	{
		//
		// Flood control
		//
		$where_sql = ($userdata['user_id'] == ANONYMOUS) ? "poster_ip = '$user_ip'" : 'poster_id = ' . $userdata['user_id'];
		$sql = "SELECT MAX(post_time) AS last_post_time
			FROM " . POSTS_TABLE . "
			WHERE $where_sql";
		if ($result = $db->sql_query($sql))
		{
			if ($row = $db->sql_fetchrow($result))
			{
				if (intval($row['last_post_time']) > 0 && ($current_time - intval($row['last_post_time'])) < intval($board_config['flood_interval']))
				{
					message_die(GENERAL_MESSAGE, $lang['Flood_Error']);
				}
			}
		}
	}

	if ($mode == 'editpost')
	{
		remove_search_post($post_id);
	}

	if ($mode == 'newtopic' || ($mode == 'editpost' && $post_data['first_post']))
	{
		$topic_vote = (!empty($poll_title) && count($poll_options) >= 2) ? 1 : 0;

		$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE . " (topic_title, topic_poster, topic_time, forum_id, topic_status, topic_type, topic_vote) VALUES ('$post_subject', " . $userdata['user_id'] . ", $current_time, $forum_id, " . TOPIC_UNLOCKED . ", $topic_type, $topic_vote)" : "UPDATE " . TOPICS_TABLE . " SET topic_title = '$post_subject', topic_type = $topic_type " . (($post_data['edit_vote'] || !empty($poll_title)) ? ", topic_vote = " . $topic_vote : "") . " WHERE topic_id = $topic_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}

		if ($mode == 'newtopic')
		{
			$topic_id = $db->sql_nextid();
		}
	}

	$edited_sql = ($mode == 'editpost' && !$post_data['last_post'] && $post_data['poster_post']) ? ", post_edit_time = $current_time, post_edit_count = post_edit_count + 1 " : "";
	$sql = ($mode != "editpost") ? "INSERT INTO " . POSTS_TABLE . " (topic_id, forum_id, poster_id, post_username, post_time, poster_ip, enable_bbcode, enable_html, enable_smilies, enable_sig) VALUES ($topic_id, $forum_id, " . $userdata['user_id'] . ", '$post_username', $current_time, '$user_ip', $bbcode_on, $html_on, $smilies_on, $attach_sig)" : "UPDATE " . POSTS_TABLE . " SET post_username = '$post_username', enable_bbcode = $bbcode_on, enable_html = $html_on, enable_smilies = $smilies_on, enable_sig = $attach_sig" . $edited_sql . " WHERE post_id = $post_id";
	if (!$db->sql_query($sql, BEGIN_TRANSACTION))
	{
		message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
	}

	if ($mode != 'editpost')
	{
		$post_id = $db->sql_nextid();
	}

	$sql = ($mode != 'editpost') ? "INSERT INTO " . POSTS_TEXT_TABLE . " (post_id, post_subject, bbcode_uid, post_text) VALUES ($post_id, '$post_subject', '$bbcode_uid', '$post_message')" : "UPDATE " . POSTS_TEXT_TABLE . " SET post_text = '$post_message',  bbcode_uid = '$bbcode_uid', post_subject = '$post_subject' WHERE post_id = $post_id";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
	}

	add_search_words('single', $post_id, stripslashes($post_message), stripslashes($post_subject));

	//
	// Add poll
	// 
	if (($mode == 'newtopic' || ($mode == 'editpost' && $post_data['edit_poll'])) && !empty($poll_title) && count($poll_options) >= 2)
	{
		$sql = (!$post_data['has_poll']) ? "INSERT INTO " . VOTE_DESC_TABLE . " (topic_id, vote_text, vote_start, vote_length) VALUES ($topic_id, '$poll_title', $current_time, " . ($poll_length * 86400) . ")" : "UPDATE " . VOTE_DESC_TABLE . " SET vote_text = '$poll_title', vote_length = " . ($poll_length * 86400) . " WHERE topic_id = $topic_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}

		$delete_option_sql = '';
		$old_poll_result = array();
		if ($mode == 'editpost' && $post_data['has_poll'])
		{
			$sql = "SELECT vote_option_id, vote_result  
				FROM " . VOTE_RESULTS_TABLE . " 
				WHERE vote_id = $poll_id 
				ORDER BY vote_option_id ASC";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain vote data results for this topic', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$old_poll_result[$row['vote_option_id']] = $row['vote_result'];

				if (!isset($poll_options[$row['vote_option_id']]))
				{
					$delete_option_sql .= ($delete_option_sql != '') ? ', ' . $row['vote_option_id'] : $row['vote_option_id'];
				}
			}
		}
		else
		{
			$poll_id = $db->sql_nextid();
		}

		@reset($poll_options);

		$poll_option_id = 1;
		while (list($option_id, $option_text) = each($poll_options))
		{
			if (!empty($option_text))
			{
				$option_text = str_replace("\'", "''", htmlspecialchars($option_text));
				$poll_result = ($mode == "editpost" && isset($old_poll_result[$option_id])) ? $old_poll_result[$option_id] : 0;

				$sql = ($mode != "editpost" || !isset($old_poll_result[$option_id])) ? "INSERT INTO " . VOTE_RESULTS_TABLE . " (vote_id, vote_option_id, vote_option_text, vote_result) VALUES ($poll_id, $poll_option_id, '$option_text', $poll_result)" : "UPDATE " . VOTE_RESULTS_TABLE . " SET vote_option_text = '$option_text', vote_result = $poll_result WHERE vote_option_id = $option_id AND vote_id = $poll_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
				}
				$poll_option_id++;
			}
		}

		if ($delete_option_sql != '')
		{
			$sql = "DELETE FROM " . VOTE_RESULTS_TABLE . " 
				WHERE vote_option_id IN ($delete_option_sql) 
					AND vote_id = $poll_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Error deleting pruned poll options', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">';
	$message = $lang['Stored'] . '<br /><br />' . sprintf($lang['Click_view_message'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');

	return false;
}

//
// Update post stats and details
//
function update_post_stats(&$mode, &$post_data, &$forum_id, &$topic_id, &$post_id, &$user_id)
{
	global $db;

	$sign = ($mode == 'delete') ? '- 1' : '+ 1';
	$forum_update_sql = "forum_posts = forum_posts $sign";
	$topic_update_sql = '';

	if ($mode == 'delete')
	{
		if ($post_data['last_post'])
		{
			if ($post_data['first_post'])
			{
				$forum_update_sql .= ', forum_topics = forum_topics - 1';
			}
			else
			{

				$topic_update_sql .= 'topic_replies = topic_replies - 1';

				$sql = "SELECT MAX(post_id) AS last_post_id
					FROM " . POSTS_TABLE . " 
					WHERE topic_id = $topic_id";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}

				if ($row = $db->sql_fetchrow($result))
				{
					$topic_update_sql .= ', topic_last_post_id = ' . $row['last_post_id'];
				}
			}

			if ($post_data['last_topic'])
			{
				$sql = "SELECT MAX(post_id) AS last_post_id
					FROM " . POSTS_TABLE . " 
					WHERE forum_id = $forum_id"; 
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}

				if ($row = $db->sql_fetchrow($result))
				{
					$forum_update_sql .= ($row['last_post_id']) ? ', forum_last_post_id = ' . $row['last_post_id'] : ', forum_last_post_id = 0';
				}
			}
		}
		else if ($post_data['first_post']) 
		{
			$sql = "SELECT MIN(post_id) AS first_post_id
				FROM " . POSTS_TABLE . " 
				WHERE topic_id = $topic_id";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$topic_update_sql .= 'topic_replies = topic_replies - 1, topic_first_post_id = ' . $row['first_post_id'];
			}
		}
		else
		{
			$topic_update_sql .= 'topic_replies = topic_replies - 1';
		}
	}
	else if ($mode != 'poll_delete')
	{
		$forum_update_sql .= ", forum_last_post_id = $post_id" . (($mode == 'newtopic') ? ", forum_topics = forum_topics $sign" : ""); 
		$topic_update_sql = "topic_last_post_id = $post_id" . (($mode == 'reply') ? ", topic_replies = topic_replies $sign" : ", topic_first_post_id = $post_id");
	}
	else 
	{
		$topic_update_sql .= 'topic_vote = 0';
	}

	$sql = "UPDATE " . FORUMS_TABLE . " SET 
		$forum_update_sql 
		WHERE forum_id = $forum_id";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
	}

	if ($topic_update_sql != '')
	{
		$sql = "UPDATE " . TOPICS_TABLE . " SET 
			$topic_update_sql 
			WHERE topic_id = $topic_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}
	}

	if ($mode != 'poll_delete')
	{
		$sql = "UPDATE " . USERS_TABLE . "
			SET user_posts = user_posts $sign 
			WHERE user_id = $user_id";
		if (!$db->sql_query($sql, END_TRANSACTION))
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}
	}

	return;
}

//
// Delete a post/poll
//
function delete_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;

	if ($mode != 'poll_delete')
	{
		include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

		$sql = "DELETE FROM " . POSTS_TABLE . " 
			WHERE post_id = $post_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . POSTS_TEXT_TABLE . " 
			WHERE post_id = $post_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
		}

		if ($post_data['last_post'])
		{
			if ($post_data['first_post'])
			{
				$forum_update_sql .= ', forum_topics = forum_topics - 1';
				$sql = "DELETE FROM " . TOPICS_TABLE . " 
					WHERE topic_id = $topic_id 
						OR topic_moved_id = $topic_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		remove_search_post($post_id);
	}

	if ($mode == 'poll_delete' || ($mode == 'delete' && $post_data['first_post'] && $post_data['last_post']) && $post_data['has_poll'] && $post_data['edit_poll'])
	{
		$sql = "DELETE FROM " . VOTE_DESC_TABLE . " 
			WHERE topic_id = $topic_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in deleting poll', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . VOTE_RESULTS_TABLE . " 
			WHERE vote_id = $poll_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in deleting poll', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . VOTE_USERS_TABLE . " 
			WHERE vote_id = $poll_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in deleting poll', '', __LINE__, __FILE__, $sql);
		}
	}

	if ($mode == 'delete' && $post_data['first_post'] && $post_data['last_post'])
	{
		$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . '=' . $forum_id) . '">';
		$message = $lang['Deleted'];
	}
	else
	{
		$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $topic_id) . '">';
		$message = (($mode == 'poll_delete') ? $lang['Poll_delete'] : $lang['Deleted']) . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');
	}

	$message .=  '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');

	return;
}

//
// BEGIN CODE - Added by JSLayton for removing BBCode from topic notification
//
function remove_bbcode($text, $post_id)
{
	global $db;

	// Pull bbcode_uid from the database
	$sql = "SELECT bbcode_uid FROM " . POSTS_TEXT_TABLE . " WHERE post_id=$post_id";
	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR,'Error pulling bbcode_uid',__LINE__,__FILE__,$sql);
	}
	$row = $db->sql_fetchrow($result);
	$bbcode_uid = $row['bbcode_uid'];

	// Search message for tags and remove them.
	$text = str_replace("[b:$bbcode_uid]", "", $text);
	$text = str_replace("[/b:$bbcode_uid]", "", $text); // [b][/b] BBCode

	$text = str_replace("[i:$bbcode_uid]", "", $text);
	$text = str_replace("[/i:$bbcode_uid]", "", $text); // [i][/i] BBCode

	$text = str_replace("[u:$bbcode_uid]", "", $text);
	$text = str_replace("[/u:$bbcode_uid]", "", $text); // [u][/u] BBCode

	$text = str_replace("[code:$bbcode_uid]", "", $text);
	$text = str_replace("[/code:$bbcode_uid]", "", $text); // [code][/code] BBCode

	$text = str_replace("[quote:$bbcode_uid]", "", $text);
	$text = str_replace("[/quote:$bbcode_uid]", "", $text); // [quote][/quote] BBCode
	$text = preg_replace("/\[quote:$bbcode_uid=\"(.*?)\"\]/si", "", $text); // [quote=""] BBCode

	$text = str_replace("[list:$bbcode_uid]", "", $text);
	$text = str_replace("[*:$bbcode_uid]", "", $text);
	$text = str_replace("[/list:u:$bbcode_uid]", "", $text);
	$text = str_replace("[/list:o:$bbcode_uid]", "", $text);
	$text = preg_replace("/\[list=([a1]):$bbcode_uid\]/si", "", $text);  // [list][/list] BBCode

	$text = preg_replace("/\[color=(\#[0-9A-F]{6}|[a-z]+):$bbcode_uid\]/si", "", $text);
	$text = str_replace("[/color:$bbcode_uid]", "", $text);

	$text = preg_replace("/\[size=([1-2]?[0-9]):$bbcode_uid\]/si", "", $text);
	$text = str_replace("[/size:$bbcode_uid]", "", $text);

	// Patterns and replacements for URL and email tags..
	$patterns = array();
	$replacements = array();

	// [img]image_url_here[/img] code..
	// This one gets first-passed..
	$patterns[] = "#\[img:$bbcode_uid\](.*?)\[/img:$bbcode_uid\]#si";
	$replacements[] = "";

	// matches a [url]xxxx://www.phpbb.com[/url] code..
	$patterns[] = "#\[url\]([\w]+?://[^ \"\n\r\t<]*?)\[/url\]#is";
	$replacements[] = "";

	// [url]www.phpbb.com[/url] code.. (no xxxx:// prefix).
	$patterns[] = "#\[url\]((www|ftp)\.[^ \"\n\r\t<]*?)\[/url\]#is";
	$replacements[] = "";

	// [url=xxxx://www.phpbb.com]phpBB[/url] code..
	$patterns[] = "#\[url=([\w]+?://[^ \"\n\r\t<]*?)\](.*?)\[/url\]#is";
	$replacements[] = "";

	// [url=www.phpbb.com]phpBB[/url] code.. (no xxxx:// prefix).
	$patterns[] = "#\[url=((www|ftp)\.[^ \"\n\r\t<]*?)\](.*?)\[/url\]#is";
	$replacements[] = "";

	// [email]user@domain.tld[/email] code..
	$patterns[] = "#\[email\]([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#si";
	$replacements[] = "";

	$text = preg_replace($patterns, $replacements, $text);

	return $text;
}
//
// END CODE - Added by JSLayton for removing BBCode from topic notification
//

//
// Handle user notification on new post (including forum notification)
//
function user_notification($mode, &$post_data, &$topic_title, &$forum_id, &$topic_id, &$post_id, &$notify_user)
{
	/***** BEGIN Modification to fix duplicate notification bug - Billy Sauls 4/15/2007 ******/
	//We'll just call our brand new function for now here directly so we can keep
	// the old code.  It is a direct call and forced return, nothing below this area 
	// is still processed.
	user_notification_mod($mode, $post_data, $topic_title, $forum_id, $topic_id, $post_id, $notify_user);
	return;
	/***** END Modification to fix duplicate notification bug - Billy Sauls 4/15/2007 ******/
	
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;

	// BEGIN CODE ADDED BY JSLayton
	global $bbcode_uid;
	include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
	// END CODE ADDED BY JSLayton

	$current_time = time();

	if ($mode == 'delete')
	{
		$delete_sql = (!$post_data['first_post'] && !$post_data['last_post']) ? " AND user_id = " . $userdata['user_id'] : '';
		$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . " WHERE topic_id = $topic_id" . $delete_sql;
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not change topic notify data', '', __LINE__, __FILE__, $sql);
		}
	}
	else 
	{
		if ($mode == 'reply')
		{
			$sql = "SELECT ban_userid 
				FROM " . BANLIST_TABLE;
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain banlist', '', __LINE__, __FILE__, $sql);
			}

			$user_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				if (isset($row['ban_userid']) && !empty($row['ban_userid']))
				{
					$user_id_sql .= ', ' . $row['ban_userid'];
				}
			}

			// ADDED BY JSL - second email field mod
			// added , u.user_email_2 after , u.user_email
			$sql = "SELECT u.user_id, u.user_email, u.user_email_2, u.user_lang, u.username, f.forum_name 
				FROM " . TOPICS_WATCH_TABLE . " tw, " . USERS_TABLE . " u, " . FORUMS_TABLE . " f 
				WHERE tw.topic_id = $topic_id 
					AND tw.user_id NOT IN (" . $userdata['user_id'] . ", " . ANONYMOUS . $user_id_sql . ") 
					AND tw.notify_status = " . TOPIC_WATCH_UN_NOTIFIED . " 
					AND f.forum_id = $forum_id 
					AND u.user_id = tw.user_id";
			// END

			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain list of topic watchers', '', __LINE__, __FILE__, $sql);
			}

			$update_watched_sql = '';
			$bcc_list_ary = array();
			$users_ary = array();
			
			if ($row = $db->sql_fetchrow($result))
			{
				// Sixty second limit
				@set_time_limit(60);

				do
				{
					if ($row['user_email'] != '')
					{
						$bcc_list_ary[$row['user_lang']][] = $row['user_email'];
						$users_ary[$row['user_email']] = $row['username'];
					}

					// ADDED BY JSL - second email field mod
					if ($row['user_email_2'] != '')
					{
						$bcc_list_ary[$row['user_lang']][] = $row['user_email_2'];
						$users_ary[$row['user_email_2']] = $row['username'];
					}
					// END

					$forum_name = $row['forum_name'];
					$update_watched_sql .= ($update_watched_sql != '') ? ', ' . $row['user_id'] : $row['user_id'];
				}
				while ($row = $db->sql_fetchrow($result));

				//
				// Let's do some checking to make sure that mass mail functions
				// are working in win32 versions of php.
				//
				if (preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
				{
					$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';

					// We are running on windows, force delivery to use our smtp functions
					// since php's are broken by default
					$board_config['smtp_delivery'] = 1;
					$board_config['smtp_host'] = @$ini_val('SMTP');
				}

				if (sizeof($bcc_list_ary))
				{
					include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
					$emailer = new emailer($board_config['smtp_delivery']);

					$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
					$script_name = ($script_name != '') ? $script_name . '/viewtopic.'.$phpEx : 'viewtopic.'.$phpEx;
					$server_name = trim($board_config['server_name']);
					$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
					$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';

					$orig_word = array();
					$replacement_word = array();
					obtain_word_list($orig_word, $replacement_word);

					$emailer->from($board_config['board_email']);
					$emailer->replyto($board_config['board_email']);

					$topic_title = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($topic_title)) : unprepare_message($topic_title);
					$post_text = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($post_data['message'])) : unprepare_message($post_data['message']);

					// JSL BEGIN CODE - Changed this line for removing BBCode from topic notification
					$post_text = bbencode_second_pass($post_text, $bbcode_uid);
					$post_text = strip_tags($post_text, '<img>');
					$post_text = str_replace('<img src="', '', $post_text);
					$post_text = str_replace('" border="0" />', '', $post_text);
					$post_text = str_replace($bbcode_uid . "="," ",$post_text);
					$post_text = stripslashes($post_text);  // added by JJ
					// JSL END CODE - Changed this line for removing BBCode from topic notification

					@reset($bcc_list_ary);
					while (list($user_lang, $bcc_list) = each($bcc_list_ary))
					{
						$emailer->use_template('topic_notify', $user_lang);
		
						for ($i = 0; $i < count($bcc_list); $i++)
						{
							$emailer->bcc($bcc_list[$i]);
						}

						// The Topic_reply_notification lang string below will be used
						// if for some reason the mail template subject cannot be read 
						// ... note it will not necessarily be in the posters own language!
						$emailer->set_subject($lang['Topic_reply_notification']); 
						
						// This is a nasty kludge to remove the username var ... till (if?)
						// translators update their templates
						// $emailer->msg = preg_replace('#[ ]?{USERNAME}#', '', $emailer->msg);

						$emailer->assign_vars(array(
							'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
							'SITENAME' => $board_config['sitename'],
							'USERNAME' => $users_ary[$bcc_list['0']],
							'TOPIC_TITLE' => $topic_title, 
							'POST_TEXT' => $post_text, 
							'POSTERNAME' => $post_data['username'], 
							'FORUM_NAME' => $forum_name, 

							'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id",
							'U_STOP_WATCHING_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_TOPIC_URL . "=$topic_id&unwatch=topic")
						);

						$emailer->send();
						$emailer->reset();
					}
				}
			}
			
			$already_mailed = ( trim($update_watched_sql) == '' ) ? "" : "$update_watched_sql, ";
			$db->sql_freeresult($result);

			// start of reply forum notification

			// ADDED BY JSL - second email field mod
			// added , u.user_email_2 after , u.user_email
			$sql = "SELECT u.user_id, u.user_email, u.user_email_2, u.user_lang, f.forum_name
				FROM " . USERS_TABLE . " u, " . FORUMS_WATCH_TABLE . " fw, " . FORUMS_TABLE . " f 
				WHERE fw.forum_id = $forum_id 
					AND fw.user_id NOT IN (" . ANONYMOUS . $user_id_sql . ") 
					AND f.forum_id = $forum_id
					AND f.forum_notify = '1' 
					AND u.user_id = fw.user_id";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain list of topic watchers', '', __LINE__, __FILE__, $sql);
			}

			$bcc_list_ary = array();
			
			$users_ary = array();
			
			if ($row = $db->sql_fetchrow($result))
			{
				// Sixty second limit
				@set_time_limit(60);

				do
				{
					if ($row['user_email'] != '')
					{
						$bcc_list_ary[$row['user_lang']][] = $row['user_email'];
						$users_ary[$row['user_email']] = $row['username'];
					}

					// ADDED BY JSL - second email field mod
					if ($row['user_email_2'] != '')
					{
						$bcc_list_ary[$row['user_lang']][] = $row['user_email_2'];
						$users_ary[$row['user_email_2']] = $row['username'];
					}
					// END

					$forum_name = $row['forum_name'];
				}
				while ($row = $db->sql_fetchrow($result));

				//
				// Let's do some checking to make sure that mass mail functions
				// are working in win32 versions of php.
				//
				if (preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
				{
					$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';

					// We are running on windows, force delivery to use our smtp functions
					// since php's are broken by default
					$board_config['smtp_delivery'] = 1;
					$board_config['smtp_host'] = @$ini_val('SMTP');
				}

				if (sizeof($bcc_list_ary))
				{
					include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
					$emailer = new emailer($board_config['smtp_delivery']);

					$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
					$script_name_forum = ($script_name != '') ? $script_name . '/viewforum.'.$phpEx : 'viewforum.'.$phpEx;
					$script_name = ($script_name != '') ? $script_name . '/viewtopic.'.$phpEx : 'viewtopic.'.$phpEx;
					$server_name = trim($board_config['server_name']);
					$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
					$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';

					$orig_word = array();
					$replacement_word = array();
					obtain_word_list($orig_word, $replacement_word);

					$emailer->from($board_config['board_email']);
					$emailer->replyto($board_config['board_email']);

					$topic_title = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($topic_title)) : unprepare_message($topic_title);
					$post_text = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($post_data['message'])) : unprepare_message($post_data['message']);

					// JSL BEGIN CODE - Changed this line for removing BBCode from topic notification
					$post_text = bbencode_second_pass($post_text, $bbcode_uid);
					$post_text = strip_tags($post_text, '<img>');
					$post_text = str_replace('<img src="', '', $post_text);
					$post_text = str_replace('" border="0" />', '', $post_text);
					$post_text = str_replace($bbcode_uid . "="," ",$post_text);
					$post_text = stripslashes($post_text);  // added by JJ
					// JSL END CODE - Changed this line for removing BBCode from topic notification

					$temp_is_auth = array();
					@reset($bcc_list_ary);
					while (list($user_lang, $bcc_list) = each($bcc_list_ary))
					{
						$temp_userdata = get_userdata($row['user_id']);
						$temp_is_auth = auth(AUTH_ALL, $forum_id, $temp_userdata, -1);
					
						// another security check (i.e. the forum might have become private and 
						// there are still users who have notification activated)
						if( $temp_is_auth['auth_read'] && $temp_is_auth['auth_view'] )
						{
							$emailer->use_template('forum_notify', $user_lang);
			
							for ($i = 0; $i < count($bcc_list); $i++)
							{
								$emailer->bcc($bcc_list[$i]);
							}
	
							// The Topic_reply_notification lang string below will be used
							// if for some reason the mail template subject cannot be read 
							// ... note it will not necessarily be in the posters own language!
							$emailer->set_subject($lang['Topic_reply_notification']); 
							
							// This is a nasty kludge to remove the username var ... till (if?)
							// translators update their templates
							// $emailer->msg = preg_replace('#[ ]?{USERNAME}#', '', $emailer->msg);
	
							$emailer->assign_vars(array(
								'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
								'SITENAME' => $board_config['sitename'],
								'USERNAME' => $users_ary[$bcc_list['0']],
								'TOPIC_TITLE' => $topic_title, 
								'POST_TEXT' => $post_text, 
								'POSTERNAME' => $post_data['username'], 
								'FORUM_NAME' => $forum_name, 
	
								'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id",
								'U_STOP_WATCHING_FORUM' => $server_protocol . $server_name . $server_port . $script_name_forum . "?" . POST_FORUM_URL . "=$forum_id&unwatch=forum")
							);
	
							$emailer->send();
							$emailer->reset();
						}
					}
				}
			}
			// end of forum notification on reply
			
			$db->sql_freeresult($result);
			
			if ($update_watched_sql != '')
			{
				$sql = "UPDATE " . TOPICS_WATCH_TABLE . "
					SET notify_status = " . TOPIC_WATCH_NOTIFIED . "
					WHERE topic_id = $topic_id
						AND user_id IN ($update_watched_sql)";
				$db->sql_query($sql);
			}
			
		}

		//
		// code for newtopic forum notification
		//
		
		if ($mode == 'newtopic')
		{
			$sql = "SELECT ban_userid 
				FROM " . BANLIST_TABLE;
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain banlist', '', __LINE__, __FILE__, $sql);
			}

			$user_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				if (isset($row['ban_userid']) && !empty($row['ban_userid']))
				{
					$user_id_sql .= ', ' . $row['ban_userid'];
				}
			}

			// ADDED BY JSL - second email field mod
			// added , u.user_email_2 after , u.user_email
			$sql = "SELECT u.user_id, u.username, u.user_email, u.user_email_2, u.user_lang, f.forum_name 
				FROM " . FORUMS_WATCH_TABLE . " fw, " . USERS_TABLE . " u, " . FORUMS_TABLE . " f 
				WHERE fw.forum_id = $forum_id 
					AND fw.user_id NOT IN (" . ANONYMOUS . $user_id_sql . ") 
					AND f.forum_id = $forum_id 
					AND f.forum_notify = '1'  
					AND u.user_id = fw.user_id";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain list of forum watchers', '', __LINE__, __FILE__, $sql);
			}

			$bcc_list_ary = array();
			$users_ary = array();
			
			if ($row = $db->sql_fetchrow($result))
			{
				// Sixty second limit
				@set_time_limit(60);

				unset($forum_name);
				do
				{
					if ($row['user_email'] != '')
					{
						$bcc_list_ary[$row['user_lang']][] = $row['user_email'];
						$users_ary[$row['user_email']] = $row['username'];
					}

					// ADDED BY JSL - second email field mod
					if ($row['user_email'] != '')
					{
						$bcc_list_ary[$row['user_lang']][] = $row['user_email_2'];
						$users_ary[$row['user_email_2']] = $row['username'];
					}
					// END

					$forum_name = $row['forum_name'];
				}
				while ($row = $db->sql_fetchrow($result));

				//
				// Let's do some checking to make sure that mass mail functions
				// are working in win32 versions of php.
				//
				if (preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
				{
					$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';

					// We are running on windows, force delivery to use our smtp functions
					// since php's are broken by default
					$board_config['smtp_delivery'] = 1;
					$board_config['smtp_host'] = @$ini_val('SMTP');
				}

				if (sizeof($bcc_list_ary))
				{
					include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
					$emailer = new emailer($board_config['smtp_delivery']);

					$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
					$script_name_forum = ($script_name != '') ? $script_name . '/viewforum.'.$phpEx : 'viewforum.'.$phpEx;
					$script_name = ($script_name != '') ? $script_name . '/viewtopic.'.$phpEx : 'viewtopic.'.$phpEx;
					$server_name = trim($board_config['server_name']);
					$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
					$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';

					$orig_word = array();
					$replacement_word = array();
					obtain_word_list($orig_word, $replacement_word);

					$emailer->from($board_config['board_email']);
					$emailer->replyto($board_config['board_email']);

					$topic_title = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($topic_title)) : unprepare_message($topic_title);
					$post_text = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($post_data['message'])) : unprepare_message($post_data['message']);

					// JSL BEGIN CODE - Changed this line for removing BBCode from topic notification
					$post_text = bbencode_second_pass($post_text, $bbcode_uid);
					$post_text = strip_tags($post_text, '<img>');
					$post_text = str_replace('<img src="', '', $post_text);
					$post_text = str_replace('" border="0" />', '', $post_text);
					$post_text = str_replace($bbcode_uid . "="," ",$post_text);
					$post_text = stripslashes($post_text);  // added by JJ
					// JSL END CODE - Changed this line for removing BBCode from topic notification

					$temp_is_auth = array();
					@reset($bcc_list_ary);
					while (list($user_lang, $bcc_list) = each($bcc_list_ary))
					{
						$temp_userdata = get_userdata($row['user_id']);
						$temp_is_auth = auth(AUTH_ALL, $forum_id, $temp_userdata, -1);
					
						// another security check (i.e. the forum might have become private and 
						// there are still users who have notification activated)
						if( $temp_is_auth['auth_read'] && $temp_is_auth['auth_view'] )
						{
							$emailer->use_template('newtopic_notify', $user_lang);
			
							for ($i = 0; $i < count($bcc_list); $i++)
							{
								$emailer->bcc($bcc_list[$i]);
							}
	
							// The Topic_reply_notification lang string below will be used
							// if for some reason the mail template subject cannot be read 
							// ... note it will not necessarily be in the posters own language!
							$emailer->set_subject($lang['Topic_reply_notification']); 
							
							// This is a nasty kludge to remove the username var ... till (if?)
							// translators update their templates
							// $emailer->msg = preg_replace('#[ ]?{USERNAME}#', '', $emailer->msg);
	
							$emailer->assign_vars(array(
								'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
								'SITENAME' => $board_config['sitename'],
								'USERNAME' => $users_ary[$bcc_list['0']],
								'TOPIC_TITLE' => $topic_title, 
								'POST_TEXT' => $post_text, 
								'POSTERNAME' => $post_data['username'], 
								'FORUM_NAME' => $forum_name, 
								'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id",
								'U_STOP_WATCHING_FORUM' => $server_protocol . $server_name . $server_port . $script_name_forum . "?" . POST_FORUM_URL . "=$forum_id&unwatch=forum")
							);
	
							$emailer->send();
							$emailer->reset();
						}
					}
				}
			}
			
			$db->sql_freeresult($result);
		}
 
		
		$sql = "SELECT topic_id 
			FROM " . TOPICS_WATCH_TABLE . "
			WHERE topic_id = $topic_id
				AND user_id = " . $userdata['user_id'];
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic watch information', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);

		if (!$notify_user && !empty($row['topic_id']))
		{
			$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
				WHERE topic_id = $topic_id
					AND user_id = " . $userdata['user_id'];
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete topic watch information', '', __LINE__, __FILE__, $sql);
			}
		}
		else if ($notify_user && empty($row['topic_id']))
		{
			$sql = "INSERT INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
				VALUES (" . $userdata['user_id'] . ", $topic_id, 0)";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not insert topic watch information', '', __LINE__, __FILE__, $sql);
			}
		}
	}
}

//
// Handle user notification on new post (including forum notification)
// Modified by Billy Sauls on April 15, 2007
// Modified for v4 on 5/18/2007
// Modification Version: 4
//
function user_notification_mod($mode, &$post_data, &$topic_title, &$forum_id, &$topic_id, &$post_id, &$notify_user)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;
	// BEGIN CODE ADDED BY JSLayton
	global $bbcode_uid;
	include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
	// END CODE ADDED BY JSLayton
	
	$current_time = time();

	//This whole function is a mess, rewriting it a little to not be 1000 lines and 
	//work more quickly/optimized.
	
	//On this part, a query was being made to find out if a topic notification existed
	//for the current user_id and topic_id.  This is uneeded for deletes and taken out.
	//This section was also moved to the start of the function intsead of the end for
	//optimization (it was being called every function call).
	if (!$notify_user)
	{
		//No need to actually check if our topic exists here, a delete is a delete in sql
		//even if 0 rows are deleted.
		$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
			WHERE topic_id = $topic_id
				AND user_id = {$userdata['user_id']}";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete topic watch information', '', __LINE__, __FILE__, $sql);
		}
	}
	else
	{
		$sql = "SELECT topic_id 
			FROM " . TOPICS_WATCH_TABLE . "
			WHERE topic_id = $topic_id
				AND user_id = {$userdata['user_id']}";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic watch information', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		
		if (empty($row['topic_id']))
		{
			$sql = "INSERT INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
				VALUES ({$userdata['user_id']}, $topic_id, 0)";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not insert topic watch information', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if ($mode == 'delete')
	{
		$delete_sql = (!$post_data['first_post'] && !$post_data['last_post']) ? " AND user_id = " . $userdata['user_id'] : '';
		$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . " WHERE topic_id = $topic_id" . $delete_sql;
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not change topic notify data', '', __LINE__, __FILE__, $sql);
		}
		return; //We are finished, get out of here
	}
	
	if ($mode == 'reply' || $mode == 'newtopic')
	{
		//Here we are making our ignore list for future selects
		//I went ahead and added in ANONYMOUS and current user_id instead
		//of letting them compile in during the query
		$sql = "SELECT ban_userid FROM " . BANLIST_TABLE;
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain banlist', '', __LINE__, __FILE__, $sql);
		}

		//$user_id_sql = ANONYMOUS . ", {$userdata['user_id']}"; //Removed current user id in new line below for allowing all topic notifications 5/18/2007
		$user_id_sql = ANONYMOUS;
		while ($row = $db->sql_fetchrow($result))
		{
			if (!empty($row['ban_userid']))
			{
				$user_id_sql .= ", {$row['ban_userid']}";
			}
		}
		
		//There is a bug (or feature) in this query that prevents the turning off of notification
		//after a user has already been notified.  In short, a user gets a forum notification
		//after every post/reply regardless if they visit the site to reset it.  Unlike
		//topic notification which notifies only once and then doesn't reset until the user
		//returns to the site.  It was like this in the original, so I've left it for now.
		
		//Note here that selecting nofity status from each table, but as named columns
		//lets me know which table the user has come from.
		// ADDED BY JSL - second email field mod
		// added , u.user_email_2 after , u.user_email
		$sql = "SELECT u.user_id, u.user_email, u.user_email_2, u.user_lang, u.username, f.forum_name, 
			tw.notify_status AS topic_notify, fw.notify_status AS forum_notify
			FROM " . TOPICS_WATCH_TABLE . " tw, " . USERS_TABLE . " u, " . FORUMS_TABLE . " f,
			" . FORUMS_WATCH_TABLE . " fw 
			WHERE (tw.topic_id = $topic_id 
				AND tw.user_id NOT IN ($user_id_sql) 
				AND f.forum_id = $forum_id 
				AND u.user_id = tw.user_id)
				OR (fw.forum_id = $forum_id 
				AND fw.user_id NOT IN ($user_id_sql) 
				AND f.forum_id = $forum_id
				AND f.forum_notify = '1'
				AND u.user_id = fw.user_id)";
				//AND tw.notify_status = " . TOPIC_WATCH_UN_NOTIFIED . "  //Removing this will cause a topic to always send an email upon reply 5/18/2007
				//Resinert the above if needed under the where line, but before the OR line
				
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain list of topic watchers', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			//Moved this stuff in here since we don't need to create it unless we have a valid 
			//record in the first place.
			$update_watched_sql = '';
			$users_ary = array();
			$forum_name = $row['forum_name']; //This var only needs to be set once, not every time		
			
			// Sixty second limit
			@set_time_limit(60);

			do
			{
				if (!empty($row['user_email']) && !isset($users_ary[$row['user_email']]))
				{
					//changed this to include an array with the language
					//and notification type instead of using two arrays
					$users_ary[$row['user_email']] = array(
							'username' => $row['username'],
							'lang' => $row['user_lang'],
							'watch_type' => (isset($row['forum_notify'])) ? 1 : 0);
					//8/21/2007 - Changed watch type to be forum_notify first, not topic nofity - BS
				}
				// ADDED BY JSL - second email field mod
				//Modified by Billy Sauls 4/15/2007 to work with the new function
				if (!empty($row['user_email_2']) && !isset($users_ary[$row['user_email_2']]))
				{
					//changed this to include an array with the language
					//and notification type instead of using two arrays
					$users_ary[$row['user_email_2']] = array(
							'username' => $row['username'],
							'lang' => $row['user_lang'],
							'watch_type' => (isset($row['forum_notify'])) ? 1 : 0);
							//8/21/2007 - Changed watch type to be forum_notify first, not topic nofity - BS
				}
				//$update_watched_sql .= ($update_watched_sql != '') ? ', ' . $row['user_id'] : $row['user_id'];  //No need to keep track of this if topics are going to be sent every time.  5/18/2007
			}
			while ($row = $db->sql_fetchrow($result));

			//
			// Let's do some checking to make sure that mass mail functions
			// are working in win32 versions of php.
			//
			if (preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
			{
				$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';

				// We are running on windows, force delivery to use our smtp functions
				// since php's are broken by default
				$board_config['smtp_delivery'] = 1;
				$board_config['smtp_host'] = @$ini_val('SMTP');
			}

			if (sizeof($users_ary))
			{
				include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
				$emailer = new emailer($board_config['smtp_delivery']);

				$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
				$script_name = ($script_name != '') ? $script_name . '/viewtopic.'.$phpEx : 'viewtopic.'.$phpEx;
				$server_name = trim($board_config['server_name']);
				$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
				$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';

				$orig_word = array();
				$replacement_word = array();
				obtain_word_list($orig_word, $replacement_word);

				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);

				$topic_title = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($topic_title)) : unprepare_message($topic_title);
				$post_text = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($post_data['message'])) : unprepare_message($post_data['message']);
				// JSL BEGIN CODE - Changed this line for removing BBCode from topic notification
				$post_text = bbencode_second_pass($post_text, $bbcode_uid);
				$post_text = strip_tags($post_text, '<img>');
				$post_text = str_replace('<img src="', '', $post_text);
				$post_text = str_replace('" border="0" />', '', $post_text);
				$post_text = str_replace($bbcode_uid . "="," ",$post_text);
				$post_text = stripslashes($post_text);  // added by JJ
				// JSL END CODE - Changed this line for removing BBCode from topic notification

				@reset($users_ary);
				while (list($user_email, $user_info) = each($users_ary))
				{
					//There was a "security" check on this for forum notification, but I deem it
					//as not needed.  It basically just went through and queried the DB for each 
					//user to see if they were still authorized to view the forum.  It isn't needed 
					//and obviously didn't work correctly or I wouldn't have been writing the last mod :)
					//For such an extreme case that this could occur (if even possible now), it isn't 
					//worth querying the DB each and every time a notification is sent, for each and 
					//every user.  Worst case scenario, a user would get a notification of a topic that
					//they can't view, not more than once.
					$emailer->bcc($user_email);
					switch($user_info['watch_type'])
					{
						case 0: //Topic one
							$emailer->use_template('topic_notify', $user_info['lang']);
							$emailer->set_subject($lang['Topic_reply_notification']);
							$emailer->assign_vars(array(
								'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
								'SITENAME' => $board_config['sitename'],
								'USERNAME' => $user_info['username'],
								'TOPIC_TITLE' => $topic_title, 
								'POST_TEXT' => $post_text, 
								'POSTERNAME' => $post_data['username'], 
								'FORUM_NAME' => $forum_name,
								'U_STOP_WATCHING_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_TOPIC_URL . "=$topic_id&unwatch=topic",
								'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id")
							);
							break; 
						case 1: //Forum one
							$templateName = ($mode == 'newtopic') ? 'newtopic_notify' : 'forum_notify';
							$emailer->use_template($templateName, $user_info['lang']);
							$emailer->set_subject($lang['Topic_reply_notification']);
							$emailer->assign_vars(array(
								'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
								'SITENAME' => $board_config['sitename'],
								'USERNAME' => $user_info['username'],
							//	'TOPIC_TITLE' => $topic_title . ' Template:' . $templateName . ' Mode:' . $mode, // Temporarily added these variables to debug 5/18/2007
								'TOPIC_TITLE' => $topic_title,
								'POST_TEXT' => $post_text, 
								'POSTERNAME' => $post_data['username'], 
								'FORUM_NAME' => $forum_name,
								'U_STOP_WATCHING_FORUM' => $server_protocol . $server_name . $server_port . $script_name_forum . "?" . POST_FORUM_URL . "=$forum_id&unwatch=forum",
								'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id")
							);
							break;
					}
					//$emailer->msg = preg_replace('#[ ]?{USERNAME}#', '', $emailer->msg);
					
					$emailer->send();
					$emailer->reset();
				}
			}
			
			/* There is no point in doing this anymore, since notifications should be sent every time.  5/18/2007
			if ($update_watched_sql != '')
			{
				$sql = "UPDATE " . TOPICS_WATCH_TABLE . "
					SET notify_status = " . TOPIC_WATCH_NOTIFIED . "
					WHERE topic_id = $topic_id
						AND user_id IN ($update_watched_sql)";
				$db->sql_query($sql);
			}
			*/
		}
	}
}

//
// Fill smiley templates (or just the variables) with smileys
// Either in a window or inline
//
function generate_smilies($mode, $page_id)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $user_ip, $session_length, $starttime;
	global $userdata;

	$inline_columns = 4;
	$inline_rows = 5;
	$window_columns = 8;

	if ($mode == 'window')
	{
		$userdata = session_pagestart($user_ip, $page_id);
		init_userprefs($userdata);

		$gen_simple_header = TRUE;

		$page_title = $lang['Emoticons'] . " - $topic_title";
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->set_filenames(array(
			'smiliesbody' => 'posting_smilies.tpl')
		);
	}

	$sql = "SELECT emoticon, code, smile_url   
		FROM " . SMILIES_TABLE . " 
		ORDER BY smilies_id";
	if ($result = $db->sql_query($sql))
	{
		$num_smilies = 0;
		$rowset = array();
		while ($row = $db->sql_fetchrow($result))
		{
			if (empty($rowset[$row['smile_url']]))
			{
				$rowset[$row['smile_url']]['code'] = str_replace("'", "\\'", str_replace('\\', '\\\\', $row['code']));
				$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
				$num_smilies++;
			}
		}

		if ($num_smilies)
		{
			$smilies_count = ($mode == 'inline') ? min(19, $num_smilies) : $num_smilies;
			$smilies_split_row = ($mode == 'inline') ? $inline_columns - 1 : $window_columns - 1;

			$s_colspan = 0;
			$row = 0;
			$col = 0;

			while (list($smile_url, $data) = @each($rowset))
			{
				if (!$col)
				{
					$template->assign_block_vars('smilies_row', array());
				}

				$template->assign_block_vars('smilies_row.smilies_col', array(
					'SMILEY_CODE' => $data['code'],
					'SMILEY_IMG' => $board_config['smilies_path'] . '/' . $smile_url,
					'SMILEY_DESC' => $data['emoticon'])
				);

				$s_colspan = max($s_colspan, $col + 1);

				if ($col == $smilies_split_row)
				{
					if ($mode == 'inline' && $row == $inline_rows - 1)
					{
						break;
					}
					$col = 0;
					$row++;
				}
				else
				{
					$col++;
				}
			}

			if ($mode == 'inline' && $num_smilies > $inline_rows * $inline_columns)
			{
				$template->assign_block_vars('switch_smilies_extra', array());

				$template->assign_vars(array(
					'L_MORE_SMILIES' => $lang['More_emoticons'], 
					'U_MORE_SMILIES' => append_sid("posting.$phpEx?mode=smilies"))
				);
			}

			$template->assign_vars(array(
				'L_EMOTICONS' => $lang['Emoticons'], 
				'L_CLOSE_WINDOW' => $lang['Close_window'], 
				'S_SMILIES_COLSPAN' => $s_colspan)
			);
		}
	}

	if ($mode == 'window')
	{
		$template->pparse('smiliesbody');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}

?>