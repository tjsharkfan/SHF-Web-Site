<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left">{PHPBBHEADER}<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -&gt;
		<a href="{U_CAL_HOME}" class="nav">{CALENDAR}</a></span></td>
		<td align=right class=genmed valign=bottom></td>
	</tr>
</table>
 	    	 	 			    	 
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
        <tr> 
          <th height=25 class="thHead"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>{BUTTON_PREV}
                <td nowrap>
		 <center>
		   <table cellpadding=0 border=0 cellspacing=0>
			<tr>
			<td><span class=gen><b><font color=#FFA34F>{CAL_DAY}</font></b>&nbsp;</span></td>
			<td class=row1 align=center><span class=gen>{CAL_MONTH}</span></td>
			<td><span class=gen>&nbsp;<b><font color=#FFA34F>{CAL_YEAR}</font></b></span></td>
			</tr>
		   </table>
		   </center> 
		</td>
{BUTTON_NEXT}
	      </tr>
            </table></th>
        </tr>
        <tr> 
          <td class=row2>
	     <table cellpadding=2 cellspacing=0 border=0 width=100% >
              <tr> 
                <td width=55% class=catHead NOWRAP><span class=genmed><b>{SUBJECT}</b></span><span class=gensmall>{CATEGORY}</span></td>
                <td width=15% class=catHead NOWRAP align="center"><span class=genmed><b>{DATE}</b></span> <span class=gensmall>({TIME})</span></td>
                <td width=15% class=catHead NOWRAP align="center"><span class=genmed><b>{END_DATE}</b> <span class=gensmall>({TIME})</span></td>
                <td width=15% class=catHead NOWRAP colspan="2" align="center"><span class=genmed><b>{AUTHOR}</b></span></td>
              </tr>
	<!-- BEGIN no_events -->
	      <tr>
		<td colspan='4'><span class=gen><BR>{no_events.NO_EVENTS}</span></td>
	      </tr>
	<!-- END no_events -->
	<!-- BEGIN event_row -->
              <tr> 
                <td class=row2 height=25><span class=genmed><B>{event_row.SUBJECT}</B></span><span class=gensmall>{event_row.CATEGORY}</span></td>
                <td class=row2 NOWRAP align="center"><span class=genmed><strong>&nbsp;{event_row.DATE}&nbsp;</strong></span> <span class=gensmall>{event_row.TIME}</span></td>
                <td class=row2 NOWRAP align="center"><span class=genmed><strong>&nbsp;{event_row.END_DATE}&nbsp;</strong></span> <span class=gensmall>{event_row.END_TIME}</span></td>
                <td class=row2 NOWRAP rowspan="2" width="140" valign="top" align="center"><span class=genmed><br /><strong>{event_row.AUTHOR}</strong><br />{event_row.POSTER_ONLINE}</span></td>
                <td class=row2 NOWRAP rowspan="2" width="60" valign="top">{event_row.PROFILE_IMG}<br />{event_row.PM_IMG}<br />{event_row.EMAIL_IMG}<br />{event_row.WWW_IMG}</td>
              </tr>
              <tr> 
                <td class=row1 colspan=3><span class=genmed>{event_row.DESC}<br />&nbsp;</td>
              </tr>
              <tr>
 		<td class=row2 align=left>{event_row.BUTTON_MOD} {event_row.BUTTON_DEL}</td>
 		<td class=row2 colspan=4 align=right>{event_row.AIM_IMG} {event_row.YIM_IMG} {event_row.MSN_IMG} {event_row.ICQ_IMG}</td>
              </tr>
              <tr> 
                <td colspan=5 class="spaceRow" colspan="2" height="1"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
              </tr>
	<!-- END event_row -->
            </table>
	   </td>
	</tr>
</table>
<center>
<BR>&nbsp;
<BR> 	    	 	 			    	 
<table border="0" cellspacing="0" cellpadding="0">
   <tr>
{BUTTON_HOME}
   </tr>
   <tr>
	<td>
	<table>
	   <tr> 
{BUTTON_ADD}
{BUTTON_VAL}
	   </tr>
	</table>
	</td>
    </tr>
</table>
</center> 