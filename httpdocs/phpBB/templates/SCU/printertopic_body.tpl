<a class="maintitle" href="{U_VIEW_TOPIC}"><font color=black>{TOPIC_TITLE}</font></a>
&nbsp;&nbsp;&nbsp;
<a title="{L_PRINT_DESC}" href="javascript:self.print()"><img alt="{L_PRINT_DESC}" src="http://www.scuemba.com/phpBB_shadow/templates/SCU/images/icon_print.gif" border="0" /></a>
<br clear=all>

<table border=0 align=right>
	<tr>
		<td class="gen" nowrap>
			<form action="{U_VIEW_TOPIC}" method="get">
			{L_SELECT_MESSAGES_FROM}
		</td>
		<td class="gen">				
			#<input class="post" type="text" maxlength="5" size="5" name="start_rel" value="{START_REL}">
		</td>
		<td class="gen">
			{L_SELECT_THROUGH}
		</td> 
		<td class="gen" nowrap title="{L_BOX2_DESC}">
			#<input class="post" type="text" maxlength="5" size="5" name="finish_rel" value="{FINISH_REL}">
		</td>	
		<td class="gen">
			<input type="hidden" name="t" value="{TOPIC_ID}">
			<input type="hidden" name="printertopic" value="1">
			<input type="submit" name="submit" value="{L_SHOW}" class="mainoption">
		</td>	
		<td class="gen" >
			<a target=_blank title="see the faq section for more help" href="{U_FAQ}">{L_FAQ}</a>
		</td>
	</tr>	
</table>

<span class="nav">{PAGINATION}</span><br />
<span class="nav"><font color=black><a href="{U_INDEX}" class="nav"><font color=black>{SITENAME}</font></a>
	  -> <a href="{U_VIEW_FORUM}" class="nav"><font color=black>{FORUM_NAME}</font></a></font></span>


	{POLL_DISPLAY} 

	<!-- BEGIN postrow -->
	<center><hr width=80%></center>
<span class="name"><a name="{postrow.U_POST_ID}"></a></span><span class="postdetails">#{postrow.POST_NUMBER}:&nbsp;<font color=black><b>{postrow.POST_SUBJECT}</b> {L_AUTHOR}:&nbsp;<b>{postrow.POSTER_NAME}</b>,&nbsp;</font></span><span class="postdetails"><font color=black>{postrow.POSTER_FROM}</font></span>
<a href="{postrow.U_MINI_POST}"><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="{postrow.L_MINI_POST_ALT}" title="{postrow.L_MINI_POST_ALT}" border="0" /></a><span class="postdetails"><font color=black>{L_POSTED}: {postrow.POST_DATE}</font><span class="gen"><br>
	<span class="gensmall">&nbsp;&nbsp;&nbsp;&nbsp;&#151;</span><br>

<span class="postbody">{postrow.MESSAGE}</span><span class="gensmall">{postrow.EDITED_MESSAGE}{postrow.ATTACHMENTS}</span></td>
	<!-- END postrow -->
	<span class="gensmall"><center><hr width=48%><hr width=16%><hr width=4%></center><span>
<span class="nav"><a href="{U_INDEX}" class="nav"><font color=black>{SITENAME}</font></a> 
	  -> <a href="{U_VIEW_FORUM}" class="nav"><font color=black>{FORUM_NAME}</font></a></span>
<p align=right><br><span class="gensmall">{S_TIMEZONE}</span></p><span class="nav">{PAGINATION}</span>
<center><span class="nav">{PAGE_NUMBER}</span></center>
</form>