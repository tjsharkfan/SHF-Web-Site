<?php

// $Id: adminbox.inc,v 1.26 2005/02/01 11:36:35 jenst Exp $
// Note that this box is assumed to be attached to a navigator and uses the navigator's
// width parameters .

global $gallery, $adminbox, $navigator;

// If the border color is not passed in, we do a black/white combo
if (isset ($adminbox["bordercolor"])) {
	$borderIn = $adminbox["bordercolor"];
} else {
	$borderIn = "#FFFFFF";
}

$checklist = array('commands', 'text');
foreach ($checklist as $check) {
	if (!isset($adminbox[$check])) {
		$adminbox[$check] = '';
	}
}

$pixelImage = "<img src=\"" . getImagePath('pixel_trans.gif') . "\" width=\"1\" height=\"1\" alt=\"pixel_trans\">";

$width='';
if (isset($navigator["fullWidth"]) && isset($navigator["widthUnits"])) {
        $width=' width="'. $navigator["fullWidth"] . $navigator["widthUnits"] .'" ';
}

// For rtl/ltr stuff
if ($gallery->direction == 'ltr') {
    $left ='left';
    $right = 'right';
} else {
    $left ='right';
    $right = 'left';
}

?>
<table<?php echo $width; ?> cellspacing="0" cellpadding="0" id="adminbox">
  <tr> 
    <td align="<?php echo $left; ?>"><?php echo $adminbox["text"] ?></td>
    <td align="<?php echo $right; ?>">
	<form name="admin_options_form" action="view_album.php">
	<?php echo $adminbox["commands"] ?>
	</form>
    </td>
  </tr>
</table>    
