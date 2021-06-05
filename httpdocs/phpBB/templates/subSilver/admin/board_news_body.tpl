
<h1>NEWS CONFIGURATION</h1>

<form action="{S_NEWS_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
<td>	
<tr>
	  <th class="thHead" colspan="2">GENERAL SETTINGS</th>
	</tr>
</td>
	<tr> 
                     <td class="row1">{L_NEWS_TITLE}</td> 
                <td class="row2"><textarea name="news_title" rows="1" cols="60">{NEWS_TITLE}</textarea></td> 
        </tr>    
<table>
<tr>
		<td class="row1">{L_NEWS_STYLE}</td>
		<td class="row2">{NEWS_STYLE_SELECT}</td>
	</tr>
<tr>
		<td class="row1">{L_NEWS_BOLD}</td>
		<td class="row2">{NEWS_BOLD_SELECT}</td>
	</tr>
<tr>
		<td class="row1">{L_NEWS_ITAL}</td>
		<td class="row2">{NEWS_ITAL_SELECT}</td>
	</tr>
<tr>
		<td class="row1">{L_NEWS_UNDER}</td>
		<td class="row2">{NEWS_UNDER_SELECT}</td>
	</tr>
<tr>
		<td class="row1">{L_NEWS_SIZE}</td>
		<td class="row2">{NEWS_SIZE_SELECT}</td>
	</tr>

<tr>
	<td class="row1">{L_NEWS_COLOR}:</td> 
<td class="row2">{NEWS_COLOR_SELECT}</td>
</tr>
<tr>

<td class="row1">{L_SCROLL_SPEED}:</td> 
			<td class="row2">{SCROLL_SPEED_SELECT}</td>
			</tr>		  	
					  
<TR><td class="row1">{L_SCROLL_ACTION}:</td> 
			<td class="row2">{SCROLL_ACTION_SELECT}</td>
</tr>

<TR>
<td class="row1">{L_SCROLL_BEHAVIOR}: 
					<td class="row2">{SCROLL_BEHAVIOR_SELECT}</td
</tr>


								
<TR>
<td class="row1">{L_SCROLL_SIZE}:</td> 
					<td class="row2">{SCROLL_SIZE_SELECT}</td>
			
        <tr> 
                <td class="row1">{L_NEWS_BLOCK}</td> 
                <td class="row2"><textarea name="news_block" rows="5" cols="60">{NEWS_BLOCK}</textarea></td> 
        </tr>  
  <tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>

</form>	

<br clear="all" />
