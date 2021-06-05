<?php
/***************************************************************************
 *                              functions_news.php
 *                            -------------------
 *   begin                : Thursday, Apr 3, 2003
 *   copyright            : (C) 2003 Garold W. Robinson
 *   email                : setheep@hotmail.com
 *
 *
 *
 *
 ***************************************************************************/
  $news_config = array();

       $sql = "SELECT *
	FROM " . NEWS_TABLE;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$news_config[$row['config_name']] = $row['config_value'];
}	



  	
	
	
function ns_select($default, $select_name = 'news_size')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'news_size';
	}
	$ns_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['ns']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$ns_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$ns_select .= '</select>';

	return $ns_select;
}

 function nc_select($default, $select_name = 'news_color')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'news_color';
	}
	$nc_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['nc']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$nc_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$nc_select .= '</select>';

	return $nc_select;
}
 function ssp_select($default, $select_name = 'scroll_speed')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'scroll_speed';
	}
	$ssp_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['ssp']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$ssp_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$ssp_select .= '</select>';

	return $ssp_select;
}
  function sa_select($default, $select_name = 'scroll_action')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'scroll_action';
	}
	$sa_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['sa']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$sa_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$sa_select .= '</select>';

	return $sa_select;
}
  function sb_select($default, $select_name = 'scroll_behavior')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'scroll_behavior';
	}
	$sb_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['sb']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$sb_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$sb_select .= '</select>';

	return $sb_select;
}
  function ss_select($default, $select_name = 'scroll_size')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'scroll_size';
	}
	$ss_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['ss']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$ss_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$ss_select .= '</select>';

	return $ss_select;
}
 function nbs_select($default, $select_name = 'news_bold')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'news_bold';
	}
	$nbs_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['nbs']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$nbs_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$nbs_select .= '</select>';

	return $nbs_select;
}
 function nis_select($default, $select_name = 'news_ital')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'news_ital';
	}
	$nis_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['nis']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$nis_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$nis_select .= '</select>';

	return $nis_select;
}
 function nss_select($default, $select_name = 'news_style')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'news_style';
	}
	$nss_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['nss']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$nss_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$nss_select .= '</select>';

	return $nss_select;
}
 function nus_select($default, $select_name = 'news_under')
{
	global $news_config, $lang;

	if ( !isset($default) )
	{
		$default == 'news_under';
	}
	$nus_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['nus']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$nus_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$nus_select .= '</select>';

	return $nus_select;
}
?>
