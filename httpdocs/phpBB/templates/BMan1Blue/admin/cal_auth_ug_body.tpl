
<h1>{L_AUTH_TITLE}</h1>

<h2>{L_USER_OR_GROUPNAME}: {USERNAME}</h2>

<form method="post" action="{S_AUTH_ACTION}">

<table cellspacing=0 cellpadding=1 border=0>
<!-- BEGIN switch_user_auth -->
<tr><td class=row1>{USER_CAL_LEVEL}</td><tr>
<tr><td class=row1>{USER_LINKZ_LEVEL}</td><tr>
<tr><td class=row1>{USER_DLMAN_LEVEL}</td><tr>
<tr><td class=row1>{USER_GALLERY_LEVEL}</td><tr>
</table>
<p>{USER_GROUP_MEMBERSHIPS}</p>
<!-- END switch_user_auth -->

<!-- BEGIN switch_group_auth -->
<tr><td class=row1>{GROUP_CAL_LEVEL}</td><tr>
<tr><td class=row1>{GROUP_LINKZ_LEVEL}</td><tr>
<tr><td class=row1>{GROUP_DLMAN_LEVEL}</td><tr>
<tr><td class=row1>{GROUP_GALLERY_LEVEL}</td><tr>
</table>
<p>{GROUP_MEMBERSHIP}</p>
<!-- END switch_group_auth -->

{S_HIDDEN_FIELDS} 
<center>
<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
&nbsp;&nbsp; 
<input type="reset" value="{L_RESET}" class="liteoption" name="reset" />
</center>
</form>
