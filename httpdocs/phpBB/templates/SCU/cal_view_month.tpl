{CATEGORY_CSS}

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


var cssTextHover=new Array();

function swc(id, fOn) {
	if (document.all) {
		es=document.all[id];
		for(ies=0, esl=es.length; ies<esl; ies++){
			e=es[ies];
			e.runtimeStyle.cssText=(fOn?cssTextHover[e.className]:"");
		}
	}
}

function setup() {
	if (document.all) {
		ss=document.styleSheets;
		for(iss=0, ssl=ss.length; iss<ssl; iss++) {
			rs=ss[iss].rules;
			for(irs=0, rsl=rs.length; irs<rsl; irs++){
				r=rs[irs];
				s=r.selectorText;
				if (s.match(/a.(cal_\d+):hover/i)) {
					cssTextHover[RegExp.$1]=r.style.cssText;
				}
			}
		}
	}
}

setup();
//-->
</script>
 	    	 	 			    	 

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left">{PHPBBHEADER}<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -&gt;
		<a href="{U_CAL_HOME}" class="nav">{CALENDAR}</a></span></td>
		<td align=right class=genmed valign=bottom><span class="nav"><a href="{U_PRINT}"><img src="{PRINT_IMG}" border="0" alt="{L_PRINT}" /></a> </span></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
       <tr>
		<th height="25" class="thLeft" width="95%">
			{CAL_MONTH} {CAL_YEAR}
		</th>
		<th height="25" class="thRight" width="5%" NOWRAP>
				<a href="{U_YEAR}"><img src="{IMG_YEAR}" alt="{L_YEAR_LINK}" border="0"></a>
		</th>

	</tr>
	<tr>
		<td colspan="2" height="10">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
{BUTTON_PREV}
			<td class=gensmall align="center" width="100%">&nbsp;<i>{FILTER}</i>&nbsp;</td>
{BUTTON_NEXT}
			</table>
		</td>
	</tr>
	<tr>
	<td colspan="2">
	<table width=100% cellpadding=1 cellspacing=1 border=0 style="border-collapse: expand; border-color=black;">
	<tr>
	  <td class=cat width=2%><span class=genmed>&nbsp;</span>
          <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_1}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_2}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_3}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_4}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_5}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_6}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_7}</span></b></td>
        </tr>
<!-- BEGIN week_row -->
        <tr>
	  <td align="center" class="row3"><a href="{week_row.U_WEEK}" class="genmed"><i><img src="{IMG_WEEK}" alt="{L_WEEK_LINK}" border="0"></i></a></td>	
<!-- BEGIN last_mon -->
	  <td valign=top {week_row.last_mon.S_CELL}>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 {week_row.last_mon.S_HEAD}><a href='{week_row.last_mon.U_DAY}' class=topictitle>{week_row.last_mon.NUM_DAY}</a></td></tr>
	    <tr><td NOWRAP valign=top {week_row.last_mon.S_DETAILS}>{week_row.last_mon.DAY_EVENT_LIST}</td></tr>
 	    </table>
	  </td>
<!-- END last_mon -->
<!-- BEGIN this_mon -->
	  <td valign=top {week_row.this_mon.S_CELL}>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 {week_row.this_mon.S_HEAD}><a href='{week_row.this_mon.U_DAY}' class=topictitle>{week_row.this_mon.NUM_DAY}</a></td></tr>
	    <tr><td NOWRAP valign=top {week_row.this_mon.S_DETAILS}>{week_row.this_mon.DAY_EVENT_LIST}</td></tr>
 	    </table>
	  </td>
<!-- END this_mon -->
<!-- BEGIN next_mon -->
	  <td valign=top {week_row.next_mon.S_CELL}>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 {week_row.next_mon.S_HEAD}><a href='{week_row.next_mon.U_DAY}' class=topictitle>{week_row.next_mon.NUM_DAY}</a></td></tr>
	    <tr><td NOWRAP valign=top {week_row.next_mon.S_DETAILS}>{week_row.next_mon.DAY_EVENT_LIST}</td></tr>
 	    </table>
	  </td>
<!-- END next_mon -->
	</tr>
<!-- END week_row -->
        </table>
        </td>
     </tr>
</table>
<center>
<table width=100% border=0 cellspacing=0 cellpadding=0>
   <tr>
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

<!-- BEGIN cat_legend --> 
<table border="0" cellspacing="2" cellpadding="2" align="center" class="bodyline"> 
<tr align="left" valign="top"> 
	<td class="genmed" valign="middle"><b>{cat_legend.CAT_LEGEND}</b></td> 
	<td class="gensmall" valign="middle">
<!-- BEGIN cat_colorcode --> 
<span class="cal_{cat_legend.cat_colorcode.ID}">{cat_legend.cat_colorcode.NAME}</span>{cat_legend.cat_colorcode.DIVIDER}
<!-- END cat_colorcode --> 
	</td> 
</tr>
</table> 
<!-- END cat_legend --> 
 	    	 	 			    	 
</center>
