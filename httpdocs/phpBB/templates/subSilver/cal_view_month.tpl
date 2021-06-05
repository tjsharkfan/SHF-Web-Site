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
var cssTextHover, cssTextLink;  
function swc(id,fon) {
   if (document.all) {
     var d=document.all[id];  
     for(var i=0;i<d.length;i++){
	// go through everything of id "cal_id###" 
        d[i].style.cssText=(fon?cssTextHover:cssTextLink);  
     //set the style accordingly
     }  
   }
}  

function setup() { 
   if (document.all) {
     dd=document.styleSheets;  
     for(var j=0; j<dd.length; j++) { 
	var ss=document.styleSheets[j].rules; 
	     for(var i=0;i<ss.length;i++){ 
	     var rr=ss[i]; 
	     strSelector=rr.selectorText; 
	     if(strSelector=="A:hover") cssTextHover=rr.style.cssText; 
	     else if (strSelector=="A:link") cssTextLink=rr.style.cssText; 
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
		<td align=right class=genmed valign=bottom><!-- {CAL_VERSION} --><span class="nav"><a href="{U_PRINT}"><img src="{PRINT_IMG}" border="0" alt="{L_PRINT}" /></a> </span></td>
	</tr>
</table>
 	    	 	 			    	 
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
       <tr>
	<th height="25" class="thHead">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
{BUTTON_PREV}
		<td><center><span class=gen><b><font color=#FFA34F>{CAL_MONTH} {CAL_YEAR} <span class=gensmall>{FILTER}</span></font></b></span></center></td>
{BUTTON_NEXT}
		</table>
	</th>
       </tr>
       <tr>
	<td>
	<table width=100% cellpadding=1 cellspacing=1 border=0 style="border-collapse: expand; border-color=black;">
	<tr>
          <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_1}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_2}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_3}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_4}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_5}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_6}</span></b></td>
	  <td class=cat width=14% align=center><b><span class=genmed>{DAY_HEAD_7}</span></b></td>
        </tr>
        <tr>
<!-- BEGIN last_mon -->
	  <td valign=top {last_mon.S_CELL}>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 {last_mon.S_HEAD}><a href='{last_mon.U_DAY}' class=topictitle>{last_mon.NUM_DAY}</a></td></tr>
	    <tr><td NOWRAP valign=top {last_mon.S_DETAILS}>{last_mon.DAY_EVENT_LIST}</td></tr>
 	    </table>
	  </td>
<!-- END last_mon -->
<!-- BEGIN this_mon -->
	  <td valign=top {this_mon.S_CELL}>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 {this_mon.S_HEAD}><a href='{this_mon.U_DAY}' class=topictitle>{this_mon.NUM_DAY}</a></td></tr>
	    <tr><td NOWRAP valign=top {this_mon.S_DETAILS}>{this_mon.DAY_EVENT_LIST}</td></tr>
 	    </table>
	  </td>{this_mon.WEEK_ROW}
<!-- END this_mon -->
<!-- BEGIN next_mon -->
	  <td valign=top {next_mon.S_CELL}>
	    <table border=0 cellspacing=0 cellpadding=0 width=100%>
	    <tr><td height=15 {next_mon.S_HEAD}><a href='{next_mon.U_DAY}' class=topictitle>{next_mon.NUM_DAY}</a></td></tr>
	    <tr><td NOWRAP valign=top {next_mon.S_DETAILS}>{next_mon.DAY_EVENT_LIST}</td></tr>
 	    </table>
	  </td>
<!-- END next_mon -->
        </tr>
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
</center>
