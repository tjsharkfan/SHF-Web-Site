//
// These functions addded by Jeff
//

function makeArray() {
     for (i = 0; i<makeArray.arguments.length; i++)
         this[i] = makeArray.arguments[i];
}

function getFullYear(d) {
    var y = d.getYear();
    if (y < 1000) {y += 1900};
    return y;
}

function format_time(t) {
    var day = t.getDay();
    var dt = t.getDate();
    var mo = t.getMonth();
    var yr = getFullYear(t);
    timeString = days[day]+", "+months[mo]+" "+dt+", "+yr;
	return timeString;
 }
 
// from http://www.w3schools.com/js/js_form_validation.asp
// generic required field checker (used to validate if form field is null)
function validate_required(field,alerttxt)	{
	with (field)
	{
	if (value==null||value=="")
  		{alert(alerttxt);return false}
	else {return true}
	}
}

// email address checker
function validate_email(field,alerttxt) {
	with (field)
	{
	apos=value.indexOf("@")
	dotpos=value.lastIndexOf(".")
	if (apos<1||dotpos-apos<2) 
  		{alert(alerttxt);return false}
	else {return true}
	}
}

// used to validate form fields
function validate_form(thisform) {
	with (thisform)
	{
	if (getSelectedRadio(radioset,"Please select a board member.")==-1)
  		{return false}		
	else if (validate_required(name,"Please provide a name.")==false)
  		{name.focus();return false}
	else if (validate_email(email,"Please provide a valid email address.")==false)
  		{email.focus();return false}
	else if (validate_required(message,"Please provide a message.")==false)
  		{message.focus();return false}	
	}
}

function getSelectedRadio(buttonGroup,alerttxt) {
   // returns the array number of the selected radio button or -1 if no button is selected
   if (buttonGroup[0]) { // if the button group is an array (one button is not an array)
      for (var i=0; i<buttonGroup.length; i++) {
         if (buttonGroup[i].checked) {
            return i
         }
      }
   } else {
      if (buttonGroup.checked) { return 0; } // if the one button is checked, return zero
   }
   // if we get to this point, no radio button is selected
   { alert(alerttxt);return -1; }
} // Ends the "getSelectedRadio" function
