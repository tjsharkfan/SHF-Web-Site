<?php

// eXtreme Styles mod cache. Generated on Fri, 30 Oct 2015 13:54:40 -0400 (time=1446227680)

?> 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
    <td align="left" valign="bottom"><span class="maintitle"><?php echo isset($this->vars['L_SEARCH_MATCHES']) ? $this->vars['L_SEARCH_MATCHES'] : $this->lang('L_SEARCH_MATCHES'); ?></span><br /></td>
  </tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="1" align="center">
  <tr> 
    <td align="left"><span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a></span></td>
    <td align="right" nowrap="nowrap"><span class="nav"><?php echo isset($this->vars['PAGINATION']) ? $this->vars['PAGINATION'] : $this->lang('PAGINATION'); ?></span></td>
  </tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline" align="center">
  <tr> 
    <th width="150" height="25" class="thCornerL" nowrap="nowrap"><?php echo isset($this->vars['L_AUTHOR']) ? $this->vars['L_AUTHOR'] : $this->lang('L_AUTHOR'); ?></th>
    <th width="100%" class="thCornerR" nowrap="nowrap"><?php echo isset($this->vars['L_MESSAGE']) ? $this->vars['L_MESSAGE'] : $this->lang('L_MESSAGE'); ?></th>
  </tr>
  <?php

$searchresults_count = ( isset($this->_tpldata['searchresults.']) ) ?  sizeof($this->_tpldata['searchresults.']) : 0;
for ($searchresults_i = 0; $searchresults_i < $searchresults_count; $searchresults_i++)
{
 $searchresults_item = &$this->_tpldata['searchresults.'][$searchresults_i];
 $searchresults_item['S_ROW_COUNT'] = $searchresults_i;
 $searchresults_item['S_NUM_ROWS'] = $searchresults_count;

?>
  <tr> 
    <td class="catHead" colspan="2" height="28"><span class="topictitle"><img src="templates/BMan1Blue/images/folder.gif" align="absmiddle">&nbsp; <?php echo isset($this->vars['L_TOPIC']) ? $this->vars['L_TOPIC'] : $this->lang('L_TOPIC'); ?>:&nbsp;<a href="<?php echo isset($searchresults_item['U_TOPIC']) ? $searchresults_item['U_TOPIC'] : ''; ?>" class="topictitle"><?php echo isset($searchresults_item['TOPIC_TITLE']) ? $searchresults_item['TOPIC_TITLE'] : ''; ?></a></span></td>
  </tr>
  <tr> 
    <td width="150" align="left" valign="top" class="row1" rowspan="2"><span class="name"><b><?php echo isset($searchresults_item['POSTER_NAME']) ? $searchresults_item['POSTER_NAME'] : ''; ?></b></span><br /><br /><span class="postdetails"><?php echo isset($this->vars['L_REPLIES']) ? $this->vars['L_REPLIES'] : $this->lang('L_REPLIES'); ?>: <b><?php echo isset($searchresults_item['TOPIC_REPLIES']) ? $searchresults_item['TOPIC_REPLIES'] : ''; ?></b><br /><?php echo isset($this->vars['L_VIEWS']) ? $this->vars['L_VIEWS'] : $this->lang('L_VIEWS'); ?>: <b><?php echo isset($searchresults_item['TOPIC_VIEWS']) ? $searchresults_item['TOPIC_VIEWS'] : ''; ?></b></span><br /></td>
    <td width="100%" valign="top" class="row1"><img src="<?php echo isset($searchresults_item['MINI_POST_IMG']) ? $searchresults_item['MINI_POST_IMG'] : ''; ?>" width="12" height="9" alt="<?php echo isset($searchresults_item['L_MINI_POST_ALT']) ? $searchresults_item['L_MINI_POST_ALT'] : ''; ?>" title="<?php echo isset($searchresults_item['L_MINI_POST_ALT']) ? $searchresults_item['L_MINI_POST_ALT'] : ''; ?>" border="0" /><span class="postdetails"><?php echo isset($this->vars['L_FORUM']) ? $this->vars['L_FORUM'] : $this->lang('L_FORUM'); ?>:&nbsp;<b><a href="<?php echo isset($searchresults_item['U_FORUM']) ? $searchresults_item['U_FORUM'] : ''; ?>" class="postdetails"><?php echo isset($searchresults_item['FORUM_NAME']) ? $searchresults_item['FORUM_NAME'] : ''; ?></a></b>&nbsp; &nbsp;<?php echo isset($this->vars['L_POSTED']) ? $this->vars['L_POSTED'] : $this->lang('L_POSTED'); ?>: <?php echo isset($searchresults_item['POST_DATE']) ? $searchresults_item['POST_DATE'] : ''; ?>&nbsp; &nbsp;<?php echo isset($searchresults_item['POST_SUBJECT']) ? $searchresults_item['POST_SUBJECT'] : ''; ?></span></td>
  </tr>
  <tr>
    <td valign="top" class="row1"><span class="postbody"><?php echo isset($searchresults_item['MESSAGE']) ? $searchresults_item['MESSAGE'] : ''; ?></span></td>
  </tr>
  <?php

} // END searchresults

if(isset($searchresults_item)) { unset($searchresults_item); } 

?>
  <tr> 
    <td class="catBottom" colspan="2" height="28" align="center">&nbsp; </td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="1" align="center" cellpadding="2">
  <tr> 
    <td align="left" valign="top"><span class="nav"><a href="<?php echo isset($this->vars['U_INDEX']) ? $this->vars['U_INDEX'] : $this->lang('U_INDEX'); ?>" class="nav"><?php echo isset($this->vars['L_INDEX']) ? $this->vars['L_INDEX'] : $this->lang('L_INDEX'); ?></a></span></td>
    <td align="right" valign="top" nowrap="nowrap"><span class="gensmall"><?php echo isset($this->vars['S_TIMEZONE']) ? $this->vars['S_TIMEZONE'] : $this->lang('S_TIMEZONE'); ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="nav"><?php echo isset($this->vars['PAGE_NUMBER']) ? $this->vars['PAGE_NUMBER'] : $this->lang('PAGE_NUMBER'); ?></span></td>
    <td align="right" valign="middle" nowrap="nowrap"><span class="nav"><?php echo isset($this->vars['PAGINATION']) ? $this->vars['PAGINATION'] : $this->lang('PAGINATION'); ?></span></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><?php echo isset($this->vars['JUMPBOX']) ? $this->vars['JUMPBOX'] : $this->lang('JUMPBOX'); ?></td>
  </tr>
</table>