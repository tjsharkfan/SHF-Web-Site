{CATEGORY_CSS}

<h1>{L_CATS_TITLE}</h1>

<P>{L_CATS_TEXT}</p>

<form method="post" action="{S_CATS_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_CAT}</th>
		<th class="thTop">{L_CAT_COLOR}</th>
		<th class="thTop">{L_CAT_BG_COLOR}</th> 
		<th class="thTop">{L_CAT_HOVER_COLOR}</th> 
		<th class="thTop">{L_CAT_HOVER_BG_COLOR}</th> 

		<th class="thTop">{L_CAT_EXAMPLE}</th>
		<th colspan="2" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN cats -->
	<tr>
		<td class="{cats.ROW_CLASS}">{cats.CAT}</td>
		<td class="{cats.ROW_CLASS}" align="center">{cats.CAT_COLOR}</td>
		<td class="{cats.ROW_CLASS}" align="center">{cats.CAT_BG_COLOR}</td> 
		<td class="{cats.ROW_CLASS}" align="center">{cats.CAT_HOVER_COLOR}</td> 
		<td class="{cats.ROW_CLASS}" align="center">{cats.CAT_HOVER_BG_COLOR}</td> 
		<td align="center"><a href="#" class="{cats.CAT_COL_CLASS}">{L_EXAMPLE}</a></td>
		<td class="{cats.ROW_CLASS}"><a href="{cats.U_CAT_EDIT}">{L_EDIT}</a></td>
		<td class="{cats.ROW_CLASS}"><a href="{cats.U_CAT_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END cats -->
	<tr>
		<td colspan="8" align="center" class="catBottom">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_ADD_CAT}" class="mainoption" /></td>
	</tr>
</table></form>
