/**
* Filename.......: calendar.js
* Project........: Popup Calendar
* Last Modified..: $Date: 2005-05-11 15:05:45 +0100 (Wed, 11 May 2005) $
* CVS Revision...: $Revision: 90 $
* Copyright......: 2001, 2002 Richard Heyes
*/

/**
* Global variables
*/
	dynCalendar_layers          = new Array();
	dynCalendar_mouseoverStatus = false;
	dynCalendar_mouseX          = 0;
	dynCalendar_mouseY          = 0;

/**
* The calendar constructor
*
* @access public
* @param string objName      Name of the object that you create
* @param string callbackFunc Name of the callback function
* @param string OPTIONAL     Optional layer name
* @param string OPTIONAL     Optional images path
*/
	function dynCalendar(objName, callbackFunc, s_date, s_month, s_year)
	{
		/**
        * Properties
        */
		// Todays date
		this.today          = new Date();
		if(s_date == '') {
			this.date           = this.today.getDate();
		} else {
			this.date	    = s_date;
		}
		if(s_month == '') {
			this.month          = this.today.getMonth();
		} else {
			this.month	    = s_month - 1;
		}
		if(s_year == '') {
			this.year           = this.today.getFullYear();
		} else {
			this.year 	    = s_year;
		}

		this.objName        = objName;
		this.callbackFunc   = callbackFunc;
		this.imagesPath     = arguments[5] ? arguments[5] : 'images/';
		this.layerID        = arguments[6] ? arguments[6] : 'dynCalendar_layer_' + dynCalendar_layers.length;

		this.offsetX        = 5;
		this.offsetY        = 5;

		this.useMonthCombo  = true;
		this.useYearCombo   = true;
		this.yearComboRange = 5;
		this.yearComboStart = 2;
		this.yearComboEnd   = 5;

		this.currentMonth   = this.month;
		this.currentYear    = this.year;

		/**
        * Public Methods
        */
		this.show              = dynCalendar_show;
		this.writeHTML         = dynCalendar_writeHTML;

		// Accessor methods
		this.setOffset         = dynCalendar_setOffset;
		this.setOffsetX        = dynCalendar_setOffsetX;
		this.setOffsetY        = dynCalendar_setOffsetY;
		this.setImagesPath     = dynCalendar_setImagesPath;
		this.setMonthCombo     = dynCalendar_setMonthCombo;
		this.setYearCombo      = dynCalendar_setYearCombo;
		this.setCurrentMonth   = dynCalendar_setCurrentMonth;
		this.setCurrentYear    = dynCalendar_setCurrentYear;
		this.setYearComboRange = dynCalendar_setYearComboRange;
		this.setYearComboStart = dynCalendar_setYearComboStart;
		this.setYearComboEnd   = dynCalendar_setYearComboEnd;

		/**
        * Private methods
        */
		// Layer manipulation
		this._getLayer         = dynCalendar_getLayer;
		this._hideLayer        = dynCalendar_hideLayer;
		this._showLayer        = dynCalendar_showLayer;
		this._setLayerPosition = dynCalendar_setLayerPosition;
		this._setHTML          = dynCalendar_setHTML;

		// Miscellaneous
		this._getDaysInMonth   = dynCalendar_getDaysInMonth;
		this._mouseover        = dynCalendar_mouseover;

		/**
        * Constructor type code
        */
		dynCalendar_layers[dynCalendar_layers.length] = this;
		this.writeHTML();
	}

/**
* Shows the calendar, or updates the layer if
* already visible.
*
* @access public
* @param integer month Optional month number (0-11)
* @param integer year  Optional year (YYYY format)
*/
	function dynCalendar_show()
	{
		// Variable declarations to prevent globalisation
		var month, year, monthnames, numdays, thisMonth, firstOfMonth;
		var ret, row, i, cssClass, linkHTML, previousMonth, previousYear;
		var nextMonth, nextYear, prevImgHTML, prevLinkHTML, nextImgHTML, nextLinkHTML;
		var monthComboOptions, monthCombo, yearComboOptions, yearCombo, html;
		
		this.currentMonth = month = arguments[0] != null ? arguments[0] : this.currentMonth;
		this.currentYear  = year  = arguments[1] != null ? arguments[1] : this.currentYear;

		monthnames = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		numdays    = this._getDaysInMonth(month, year);

		thisMonth    = new Date(year, month, 1);
		firstOfMonth = thisMonth.getDay();

		// First few blanks up to first day
		ret = new Array(new Array());
		for(i=0; i<firstOfMonth; i++){
			ret[0][ret[0].length] = '<td>&nbsp;</td>';
		}

		// Main body of calendar
		row = 0;
		i   = 1;
		while(i <= numdays){
			if(ret[row].length == 7){
				ret[++row] = new Array();
			}

			/**
            * Generate this cells' HTML
            */
			cssClass = (i == this.date && month == this.month && year == this.year) ? 'dynCalendar_today' : 'dynCalendar_day';
			linkHTML = '<a href="javascript: ' + this.callbackFunc + '(' + i + ', ' + (Number(month) + 1) + ', ' + year + '); ' + this.objName + '._hideLayer()">' + (i++) + '</a>';
			ret[row][ret[row].length] = '<td align="center" class="' + cssClass + '">' + linkHTML + '</td>';
		}

		// Format the HTML
		for(i=0; i<ret.length; i++){
			ret[i] = ret[i].join('\n') + '\n';
		}

		previousYear  = thisMonth.getFullYear();
		previousMonth = thisMonth.getMonth() - 1;
		if(previousMonth < 0){
			previousMonth = 11;
			previousYear--;
		}
		
		nextYear  = thisMonth.getFullYear();
		nextMonth = thisMonth.getMonth() + 1;
		if(nextMonth > 11){
			nextMonth = 0;
			nextYear++;
		}

		prevImgHTML  = '<img src="' + this.imagesPath + '/prev.gif" alt="<<" border="0" />';
		prevLinkHTML = '<a href="javascript: ' + this.objName + '.show(' + previousMonth + ', ' + previousYear + ')">' + prevImgHTML + '</a>';
		nextImgHTML  = '<img src="' + this.imagesPath + '/next.gif" alt="<<" border="0" />';
		nextLinkHTML = '<a href="javascript: ' + this.objName + '.show(' + nextMonth + ', ' + nextYear + ')">' + nextImgHTML + '</a>';

		/**
        * Build month combo
        */
		if (this.useMonthCombo) {
			monthComboOptions = '';
			for (i=0; i<12; i++) {
				selected = (i == thisMonth.getMonth() ? 'selected="selected"' : '');
				monthComboOptions += '<option value="' + i + '" ' + selected + '>' + monthnames[i] + '</option>';
			}
			monthCombo = '<select name="months" onchange="' + this.objName + '.show(this.options[this.selectedIndex].value, ' + this.objName + '.currentYear)">' + monthComboOptions + '</select>';
		} else {
			monthCombo = monthnames[thisMonth.getMonth()];
		}
		
		/**
        * Build year combo
        */
		if (this.useYearCombo) {
			yearComboOptions = '';
			for (i = thisMonth.getFullYear() - this.yearComboStart; i <= (thisMonth.getFullYear() + this.yearComboEnd); i++) {
				selected = (i == thisMonth.getFullYear() ? 'selected="selected"' : '');
				yearComboOptions += '<option value="' + i + '" ' + selected + '>' + i + '</option>';
			}
			yearCombo = '<select style="border: 1px groove" name="years" onchange="' + this.objName + '.show(' + this.objName + '.currentMonth, this.options[this.selectedIndex].value)">' + yearComboOptions + '</select>';
		} else {
			yearCombo = thisMonth.getFullYear();
		}

		html = '<table border="0" bgcolor="#eeeeee">';
		html += '<tr><td class="dynCalendar_header">' + prevLinkHTML + '</td><td colspan="5" align="center" class="dynCalendar_header">' + monthCombo + ' ' + yearCombo + '</td><td align="right" class="dynCalendar_header">' + nextLinkHTML + '</td></tr>';
		html += '<tr>';
		html += '<td class="dynCalendar_dayname">Sun</td>';
		html += '<td class="dynCalendar_dayname">Mon</td>';
		html += '<td class="dynCalendar_dayname">Tue</td>';
		html += '<td class="dynCalendar_dayname">Wed</td>';
		html += '<td class="dynCalendar_dayname">Thu</td>';
		html += '<td class="dynCalendar_dayname">Fri</td>';
		html += '<td class="dynCalendar_dayname">Sat</td></tr>';
		html += '<tr>' + ret.join('</tr>\n<tr>') + '</tr>';
		html += '</table>';

		this._setHTML(html);
		if(is_gecko || (!arguments[0] && !arguments[1])) {
			this._showLayer();
		}
		if (!arguments[0] && !arguments[1]) {
			this._setLayerPosition();
		}
	}

/**
* Writes HTML to document for layer
*
* @access public
*/
	function dynCalendar_writeHTML()
	{
		if (is_ie5up || is_nav6up || is_gecko || is_opera7up) {
			document.write('<a href="javascript: ' + this.objName + '.show()"><img src="' + this.imagesPath + 'dynCalendar.gif" border="0" width="16" height="16" /></a>');
			document.write('<div class="dynCalendar" id="' + this.layerID + '" onmouseover="' + this.objName + '._mouseover(true)" onmouseout="' + this.objName + '._mouseover(false)"></div>');
		}
	}

/**
* Sets the offset to the mouse position
* that the calendar appears at.
*
* @access public
* @param integer Xoffset Number of pixels for vertical
*                        offset from mouse position
* @param integer Yoffset Number of pixels for horizontal
*                        offset from mouse position
*/
	function dynCalendar_setOffset(Xoffset, Yoffset)
	{
		this.setOffsetX(Xoffset);
		this.setOffsetY(Yoffset);
	}

/**
* Sets the X offset to the mouse position
* that the calendar appears at.
*
* @access public
* @param integer Xoffset Number of pixels for horizontal
*                        offset from mouse position
*/
	function dynCalendar_setOffsetX(Xoffset)
	{
		this.offsetX = Xoffset;
	}

/**
* Sets the Y offset to the mouse position
* that the calendar appears at.
*
* @access public
* @param integer Yoffset Number of pixels for vertical
*                        offset from mouse position
*/
	function dynCalendar_setOffsetY(Yoffset)
	{
		this.offsetY = Yoffset;
	}
	
/**
* Sets the images path
*
* @access public
* @param string path Path to use for images
*/
	function dynCalendar_setImagesPath(path)
	{
		this.imagesPath = path;
	}

/**
* Turns on/off the month dropdown
*
* @access public
* @param boolean useMonthCombo Whether to use month dropdown or not
*/
	function dynCalendar_setMonthCombo(useMonthCombo)
	{
		this.useMonthCombo = useMonthCombo;
	}

/**
* Turns on/off the year dropdown
*
* @access public
* @param boolean useYearCombo Whether to use year dropdown or not
*/
	function dynCalendar_setYearCombo(useYearCombo)
	{
		this.useYearCombo = useYearCombo;
	}

/**
* Sets the current month being displayed
*
* @access public
* @param boolean month The month to set the current month to
*/
	function dynCalendar_setCurrentMonth(month)
	{
		this.currentMonth = month;
	}

/**
* Sets the current month being displayed
*
* @access public
* @param boolean year The year to set the current year to
*/
	function dynCalendar_setCurrentYear(year)
	{
		this.currentYear = year;
	}

/**
* Sets the range of the year combo. Displays this number of
* years either side of the year being displayed.
*
* @access public
* @param integer range The range to set
*/
	function dynCalendar_setYearComboRange(range)
	{
		this.yearComboRange = range;
	}

/**
* MOD CalPro
* Sets the start range of the year combo. Displays this number of
* years before the year being displayed.
*
* @access public
* @param integer range The range to set
*/
	function dynCalendar_setYearComboStart(year)
	{
		this.yearComboStart = year-2;
	}

/**
* MOD CalPro
* Sets the end range of the year combo. Displays this number of
* years after the year being displayed.
*
* @access public
* @param integer year The year on which to set the End point
*/
	function dynCalendar_setYearComboEnd(year)
	{
		this.yearComboEnd = year+5;
	}

/**
* Returns the layer object
*
* @access private
*/
	function dynCalendar_getLayer()
	{
		var layerID = this.layerID;

		if (document.getElementById(layerID)) {

			return document.getElementById(layerID);

		} else if (document.all(layerID)) {
			return document.all(layerID);
		}
	}

/**
* Hides the calendar layer
*
* @access private
*/
	function dynCalendar_hideLayer()
	{
		if(this._getLayer().style.visibility == 'visible') {
			// MOD CalPro : Now sets end date when start date is changed
			if(this.objName == 'start_cal') {
				document.post.day_end.value=document.post.day.value;
				document.post.month_end.value=document.post.month.value;
				document.post.year_end.value=document.post.year.value;
			}
		}

		this._getLayer().style.visibility = 'hidden';
	}

/**
* Shows the calendar layer
*
* @access private
*/
	function dynCalendar_showLayer()
	{
		this._getLayer().style.visibility = 'visible';
	}

/**
* Sets the layers position
*
* @access private
*/
	function dynCalendar_setLayerPosition()
	{
		this._getLayer().style.top  = (dynCalendar_mouseY + this.offsetY) + 'px';
		this._getLayer().style.left = (dynCalendar_mouseX + this.offsetX) + 'px';
	}

/**
* Sets the innerHTML attribute of the layer
*
* @access private
*/
	function dynCalendar_setHTML(html)
	{
		this._getLayer().innerHTML = html;
	}

/**
* Returns number of days in the supplied month
*
* @access private
* @param integer month The month to get number of days in
* @param integer year  The year of the month in question
*/
	function dynCalendar_getDaysInMonth(month, year)
	{
		monthdays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		if (month != 1) {
			return monthdays[month];
		} else {
			return ((year % 4 == 0 && year % 100 != 0) || year % 400 == 0 ? 29 : 28);
		}
	}

/**
* onMouse(Over|Out) event handler
*
* @access private
* @param boolean status Whether the mouse is over the
*                       calendar or not
*/
	function dynCalendar_mouseover(status)
	{
		dynCalendar_mouseoverStatus = status;
		return true;
	}

/**
* onMouseMove event handler
*/
	dynCalendar_oldOnmousemove = document.onmousemove ? document.onmousemove : new Function;

	document.onmousemove = function ()
	{
		if (is_ie5up || is_nav6up || is_gecko || is_opera7up) {
			if (arguments[0]) {
				dynCalendar_mouseX = arguments[0].pageX;
				dynCalendar_mouseY = arguments[0].pageY;
			} else {
				dynCalendar_mouseX = event.clientX + document.body.scrollLeft;
				dynCalendar_mouseY = event.clientY + document.body.scrollTop;
				arguments[0] = null;
			}
	
			dynCalendar_oldOnmousemove();
		}
	}

/**
* Callbacks for document.onclick
*/
	dynCalendar_oldOnclick = document.onclick ? document.onclick : new Function;

	document.onclick = function ()
	{
		if (is_ie5up || is_nav6up || is_gecko || is_opera7up) {
			if(!dynCalendar_mouseoverStatus){
				for(i=0; i<dynCalendar_layers.length; ++i){
					dynCalendar_layers[i]._hideLayer();
				}
			}
	
			dynCalendar_oldOnclick(arguments[0] ? arguments[0] : null);
		}
	}