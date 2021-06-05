<form action="{S_POST_ACTION}" method="post" name="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left">{PHPBBHEADER}<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -&gt;
		<a href="{U_CAL_HOME}" class="nav">{CALENDAR}</a></span></td>
		<td align=right class=genmed valign=bottom></td>
	</tr>
</table>
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
        <tr> 
          <th height=25 class="thHead">{EDIT_OR_DELETE}</th>
        </tr>
        <tr> 
          <td>
	     <center>
	     <table cellpadding=2 cellspacing=0 border=0>
	<!-- BEGIN add -->
	      <tr>
		<td><input type="radio" name="ed_option" value="add_notes" SELECTED /><span class=genmed>{add.ADD_NOTES}</span></td>
	      </tr>
	<!-- END add -->
	      <tr>
		<td><input type="radio" name="ed_option" value="edit_all" /><span class=genmed>{EDIT_ALL}</span></td>
	      </tr>
	<!-- BEGIN future -->
	      <tr>
		<td><input type="radio" name="ed_option" value="split_future" /><span class=genmed>{future.SPLIT_FUTURE}</span></td>
	      </tr>
	<!-- END future -->
	      <tr>
		<td><input type="radio" name="ed_option" value="split_solo" /><span class=genmed>{SPLIT_SOLO}</span></td>
	      </tr>
            </table>
	    </center>
	   </td>
	</tr>
	<tr> 
	  <td class="catBottom" align="center" height="28"><input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" /></td>
	</tr>
</table>
<center>
<BR>
{S_HIDDEN_FORM_FIELDS}
</form>
<table border="0" cellspacing="0" cellpadding="0">
   <tr>
{BUTTON_HOME}
    </tr>
</table>
</center> 