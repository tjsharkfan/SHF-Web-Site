<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore,type){ //v3.0
  if (type=='category') myurl = '{U_JUMP_CAT}';
  else if (type=='month') myurl = '{U_JUMP_MONTH}';
  else myurl = '{U_JUMP_YEAR}';
  myurl += selObj.options[selObj.selectedIndex].value; 
  eval(targ+".location='"+myurl+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left">{PHPBBHEADER}<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -&gt;
		<a href="{U_CAL_HOME}" class="nav">{CALENDAR}</a></span></td>
		<td align=right class=genmed valign=bottom>{CAL_VERSION}</td>
	</tr>
</table>
 	    	 	 			    	 
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
<!-- BEGIN no_events -->
	<tr>
		<td colspan='4'><span class=gen><BR>{no_events.NO_EVENTS}</span></td>
	</tr>
<!-- END no_events -->
<!-- BEGIN day_row -->
        <tr> 
          <th height=25 class="thHead" colspan="5">
			{day_row.TODAY_DATE}	
	  </th>
        </tr>
        <tr> 
		<td width=55% class=rowpic NOWRAP><span class=genmed><b>{SUBJECT}</b></span><span class=gensmall>{CATEGORY}</span></td>
		<td width=15% class=rowpic NOWRAP align="center"><span class=genmed><b>{DATE}</b></span> <span class=gensmall>({TIME})</span></td>
		<td width=15% class=rowpic NOWRAP align="center"><span class=genmed><b>{END_DATE}</b> <span class=gensmall>({TIME})</span></td>
		<td width=15% class=rowpic NOWRAP colspan="2" align="center"><span class=genmed><b>{AUTHOR}</b></span></td>
	</tr>
<!-- BEGIN event_row -->
	<tr> 
                <td class=row2 height=25><span class=genmed><B>{day_row.event_row.SUBJECT}</B></span><span class=gensmall>{day_row.event_row.CATEGORY}</span></td>
                <td class=row2 NOWRAP align="center"><span class=genmed><strong>&nbsp;{day_row.event_row.DATE}&nbsp;</strong></span> <span class=gensmall>{day_row.event_row.TIME}</span></td>
                <td class=row2 NOWRAP align="center"><span class=genmed><strong>&nbsp;{day_row.event_row.END_DATE}&nbsp;</strong></span> <span class=gensmall>{day_row.event_row.END_TIME}</span></td>
                <td class=row2 NOWRAP rowspan="2" width="140" valign="top" align="center"><span class=genmed><br /><strong>{day_row.event_row.AUTHOR}</strong><br />{day_row.event_row.POSTER_ONLINE}</span></td>
                <td class=row2 NOWRAP rowspan="2" width="60" valign="top">{day_row.event_row.PROFILE_IMG}<br />{day_row.event_row.PM_IMG}<br />{day_row.event_row.EMAIL_IMG}<br />{day_row.event_row.WWW_IMG}</td>
	</tr>
	<tr> 
                <td class=row1 colspan=3><span class=genmed>{day_row.event_row.DESC}<br />&nbsp;</td>
	</tr>
	<tr>
 		<td class=row2 align=left valign="middle">{day_row.event_row.BUTTON_MOD} {day_row.event_row.BUTTON_DEL} <span class="gensmall">{day_row.event_row.ACCESS}</span></td>
 		<td class=row2 colspan=4 align=right>{day_row.event_row.AIM_IMG} {day_row.event_row.YIM_IMG} {day_row.event_row.MSN_IMG} {day_row.event_row.ICQ_IMG}</td>
	</tr>
	<tr> 
                <td colspan=5 class="spaceRow" colspan="2" height="1"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
<!-- END event_row -->
<!-- END day_row -->
</table>
<BR>&nbsp;<BR>

<center>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
   <tr>
	<td colspan="4" align="center">
	<table>
	   <tr> 
	{BUTTON_PREV}{BUTTON_HOME}{BUTTON_NEXT}
	   </tr>
	</table>
	</td>
   </tr>
	<form action="{category_select.S_POST_ACTION}" method="post" name="post">
	<td width=50% align='left'><span class=gensmall>{L_MONTH_JUMP}</span><br>
	<!-- <SELECT name='month' onChange="MM_jumpMenu('parent',this,1,'month')"> -->
	<!-- <SELECT name='year' onChange="MM_jumpMenu('parent',this,1,'year')"> -->
	<!-- You can use the code above to create instant jumpboxes if you prefer -->
	<SELECT name='month'>
	{S_MONTH}
 	</SELECT><SELECT name='year'> -->
	{S_YEAR}
 	</SELECT><input type="submit" class="liteoption" value="{L_GO}" name="submit2"></td></form>
	{BUTTON_ADD}{BUTTON_VALIDATE}
<!-- BEGIN no_categories -->
	<td width=50% align='right'>&nbsp;</td>
<!-- END no_categories -->
<!-- BEGIN category_select -->
	<form action="{category_select.S_POST_ACTION}" method="post" name="post">
	<td width=50% align='right'><span class=gensmall>{category_select.L_FILTER_CATS}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
	<SELECT name='category' onChange="MM_jumpMenu('parent',this,1,'category')">
	{category_select.S_CATEGORY}
 	</SELECT><input type="submit" class="liteoption" value="{L_GO}" name="submit2"></td></form>
<!-- END category_select -->
   </tr>
</table>
</center>
 	    	 	 			    	 

