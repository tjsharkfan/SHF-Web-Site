<form action="{S_POST_ACTION}" method="post" name="post">
<input type='hidden' name='action' value='validevent'>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left">{PHPBBHEADER}<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -&gt;
		<a href="{U_CAL_HOME}" class="nav">{CALENDAR}</a></span></td>
		<td align=right class=genmed valign=bottom>{CAL_VERSION}</td>
	</tr>
</table>
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
        <tr> 
          <th height=25 class="thHead">{VALIDATE}</th>
        </tr>
        <tr> 
          <td>
	     <table cellpadding=2 cellspacing=0 border=0 width=100%>
              <tr> 
		<td width=40  class=row3><span class=genmed><B>{SELECT}</B></span></td>
                <td width=55% class=row3 NOWRAP><span class=genmed><b>{SUBJECT}</b></span><span class=gensmall>{CATEGORY}</span></td>
                <td width=15% class=row3 NOWRAP><span class=genmed><b>{DATE}</b>(<strong>Time</strong>)</span></td>
                <td width=15% class=row3 NOWRAP><span class=genmed><b>{END_DATE}</b></span></td>
                <td width=15% class=row3 NOWRAP><span class=genmed><b>{AUTHOR}</b></span></td>
              </tr>
	<!-- BEGIN no_events -->
	      <tr>
		<td colspan='5'><span class=gen><BR>{no_events.NO_EVENTS}</span></td>
	      </tr>
	<!-- END no_events -->
	<!-- BEGIN event_row -->
              <tr> 
		<td class=row1 rowspan=2><span class=genmed><B>{event_row.SELECT}</B></span></td>
                <td class=row1><span class=genmed><B>{event_row.SUBJECT} {event_row.CATEGORY}</B></span></td>
                <td class=row1 NOWRAP><span class=genmed>{event_row.DATE} {event_row.TIME}</span></td>
                <td class=row1 NOWRAP><span class=genmed>{event_row.END_DATE} {event_row.END_TIME}</span></td>
                <td class=row1 NOWRAP><span class=genmed>{event_row.AUTHOR}</span></td>
              </tr>
              <tr> 
                <td class=row1 colspan=5><span class=genmed>{event_row.DESC}</td>
              </tr>
              <tr> 
                <td colspan='4'><span class=genmed>&nbsp;</span></td>
              </tr>
	<!-- END event_row -->
            </table>
	   </td>
	</tr>
</table>
<center>
<BR>
{SUBMIT}
</form>
<table border="0" cellspacing="0" cellpadding="0">
   <tr>
{BUTTON_HOME}
    </tr>
</table>
</center> 