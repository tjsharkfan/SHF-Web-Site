
<h1>{L_CATS_TITLE}</h1>

<p>{L_CATS_TEXT}</p>

<script language=JavaScript src="../includes/calpro/picker/picker.js"></script>

<form method="post" action="{S_CATS_ACTION}" name="cat_edit"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2" class="thHead">{L_CAT_EDIT}</th>
	</tr>
	<tr>
		<td class="row1">{L_CAT}</td>
		<td class="row2"><input type="text" name="cat" value="{CAT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_CAT_COLOR}</td>
		<td class="row2"><input type="text" name="cat_color" value="{CAT_COLOR}" />
			<a href="javascript:TCP.popup(document.forms['cat_edit'].elements['cat_color'], 1)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="../includes/calpro/picker/img/sel.gif"></a>
		</td>
	</tr>
	<tr> 
		<td class="row1">{L_CAT_BG_COLOR}</td> 
		<td class="row2"><input type="text" name="cat_bg_color" value="{CAT_BG_COLOR}" /> 
			<a href="javascript:TCP.popup(document.forms['cat_edit'].elements['cat_bg_color'], 1)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="../includes/calpro/picker/img/sel.gif"></a> 
		</td> 
	</tr> 
	<tr> 
		<td class="row1">{L_CAT_HOVER_COLOR}</td> 
		<td class="row2"><input type="text" name="cat_hover_color" value="{CAT_HOVER_COLOR}" /> 
			<a href="javascript:TCP.popup(document.forms['cat_edit'].elements['cat_hover_color'], 1)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="../includes/calpro/picker/img/sel.gif"></a> 
		</td> 
	</tr> 
	<tr> 
		<td class="row1">{L_CAT_HOVER_BG_COLOR}</td> 
		<td class="row2"><input type="text" name="cat_hover_bg_color" value="{CAT_HOVER_BG_COLOR}" /> 
			<a href="javascript:TCP.popup(document.forms['cat_edit'].elements['cat_hover_bg_color'], 1)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="../includes/calpro/picker/img/sel.gif"></a> 
		</td> 
	</tr> 
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="save" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table></form>
