
<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post">
  <table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
    <tr> 
      <th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
    </tr>
    <tr> 
      <td class="row1">{L_WEEK_START}</td>
      <td class="row2">{WEEK_START_SELECT}</td>
    </tr>
    <tr> 
      <td class="row1"><p>{L_SUBJECT_LENGTH}<br>
          <span class="gensmall">{L_SUBJECT_LENGTH_EXPLAIN}</span> </p></td>
      <td class="row2"><input type="text" maxlength="5" size="5" name="subject_length" value="{SUBJECT_LENGTH}" /></td>
    </tr>
    <tr> 
      <td class="row1">{L_SCRIPT_PATH}<br /> <span class="gensmall">{L_SCRIPT_PATH_EXPLAIN}</span></td>
      <td class="row2"><input type="text" maxlength="255" name="cal_script_path" value="{SCRIPT_PATH}" /></td>
    </tr>
    <tr> 
      <td class="row1">{L_ALLOW_ANON}</td>
      <td class="row2"><input type="radio" name="allow_anon" value="1" {S_ALLOW_ANON_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="allow_anon" value="0" {S_ALLOW_ANON_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="row1">{L_ALLOW_USER_DEFAULT}</td>
      <td class="row2">{S_ALLOW_USER_DEFAULT}</td>
    </tr>
    <tr> 
      <td class="row1">{L_ALLOW_OLD}<br>
        <span class="gensmall">{L_ALLOW_OLD_EXPLAIN}</span> </td>
      <td class="row2"><input type="radio" name="allow_old" value="1" {S_ALLOW_OLD_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="allow_old" value="0" {S_ALLOW_OLD_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="row1">{L_SHOW_HEADERS}</td>
      <td class="row2"><input type="radio" name="show_headers" value="1" {S_SHOW_HEADERS_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="show_headers" value="0" {S_SHOW_HEADERS_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="row1">{L_ALLOW_CATEGORIES}</td>
      <td class="row2"><input type="radio" name="allow_cat" value="1" {S_ALLOW_CATEGORIES_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="allow_cat" value="0" {S_ALLOW_CATEGORIES_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="row1">{L_REQUIRE_CATEGORIES}</td>
      <td class="row2"><input type="radio" name="require_cat" value="1" {S_REQUIRE_CATEGORIES_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="require_cat" value="0" {S_REQUIRE_CATEGORIES_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="row1">{L_DATE_FORMAT}</td>
      <td class="row2">{S_DATE_FORMAT}</td>
    </tr>
    <tr> 
      <td class="row1">{L_TIME_FORMAT}</td>
      <td class="row2">{S_TIME_FORMAT}</td>
    </tr>
    <tr> 
      <td class="row1">{L_REQUIRE_TIME}</td>
      <td class="row2"><input type="radio" name="require_time" value="1" {S_REQUIRE_TIME_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="require_time" value="0" {S_REQUIRE_TIME_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="row1">{L_ALLOW_PRIVATE}</td>
      <td class="row2"><input type="radio" name="allow_private" value="1" {S_ALLOW_PRIVATE_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="allow_private" value="0" {S_ALLOW_PRIVATE_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="row1">{L_ALLOW_GRP_EVENTS}</td>
      <td class="row2"><input type="radio" name="allow_group_events" value="1" {S_ALLOW_GRP_EVENTS_YES} />
        {L_YES}&nbsp;&nbsp; <input type="radio" name="allow_group_events" value="0" {S_ALLOW_GRP_EVENTS_NO} />
        {L_NO}</td>
    </tr>
    <tr> 
      <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS} <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /> 
        &nbsp;&nbsp; <input type="reset" value="{L_RESET}" class="liteoption" /> 
      </td>
    </tr>
  </table>
</form>

<br clear="all" />
