<?php
/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2004 Bharat Mediratta
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/* This class is written for phpBB2 and provides full integration of the phpbb users database
** Instead of using or duplicating memberships manually in Gallery.
**
** Gallery <-> phpBB2 integration ver. (www.snailsource.com)
** Written by Martin Smallridge       <info@snailsource.com>
**
** This file was modified for official integration into Gallery 1.4.3 by
** Jens Tkotz

** The file was then remodified to re-enable limited permissions through the phpBB2 system
*/

// Added with changes in Security for PhpBB2.
define('IN_PHPBB', true);
if(file_exists('./includes/constants.php')) {
	// Using Gallery through modules we are at phpBB2 root so..

	include_once('./config.php');	
	include_once('./includes/constants.php');	// MOD this as required.

} elseif(file_exists('../../includes/constants.php')) {
	// If we use Gallery remote it'll be from a different path so..

	include_once('../../config.php');	
	include_once('../../includes/constants.php');	// MOD this as required.

} else {
	echo "Unable to access phpBB2 table definitions: Halting";
	exit;
}

class phpbb_User extends Abstract_User {
	var $db;
	

	function phpbb_User() {
		global $gallery, $userdata;
		$this->db = $gallery->database{"phpbb"};
	}

	function loadByUid($uid) {
		$sql = "SELECT username, user_email, user_level FROM ".USERS_TABLE." WHERE user_id='$uid'";
		$results = $this->db->query($sql);
		$row = $this->db->fetch_row($results);
		$this->username = $row[0];
		$this->fullname = $row[0];
		$this->email = $row[1];
		$this->uid = $uid;

		if ($row[2] == '1') {
			$this->isAdmin = 1;
			$this->canCreateAlbums = 1;
		}
		else {
			// Check for gallery permissions according the to the phpBB2 gallery_permission
			$gallery_perm = $this->galleryperm($uid);

			// Defaults
			$this->isAdmin = 0;
			$this->canCreateAlbums = 0;

			if ($gallery_perm == 2) {
				$this->isAdmin = 1;
			}
			if ($gallery_perm >= 1) {
				$this->canCreateAlbums = 1;
			}
		}
	}

	function loadByUserName($uname) {
		$results = $this->db->query("SELECT user_id, user_email, user_level FROM ".USERS_TABLE." WHERE username='$uname'");
		$row = $this->db->fetch_row($results);
		$this->uid = $row[0];
		$uid = $row[0];
		$this->fullname = $uname;
		$this->email = $row[1];
		$this->username = $uname;

		if ($row[2] == '1') {
			$this->isAdmin = 1;
			$this->canCreateAlbums = 1;
		}
		else {
			// Not an Admin so Check if User ID is in the Gallery User Group (ie: can create albums)
			$gallery_perm = $this->galleryperm($row[0]);

			// Defaults
			$this->isAdmin = 0;
			$this->canCreateAlbums = 0;

			if ($gallery_perm == 2) {
				$this->isAdmin = 1;
			}
			if ($gallery_perm >= 1) {
				$this->canCreateAlbums = 1;
			}
		}
	}

	function galleryperm($user_id) {

		$gallery_perm = 0; // Set default
		// Get the user permissions first.
		$sql = "SELECT user_gallery_perm FROM " . USERS_TABLE . " WHERE user_id = '$user_id'";

		if ( !($result = $this->db->query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not select Gallery permission from user table', '', __LINE__, __FILE__, $sql);
		}
		$row = $this->db->fetch_row($result);

		// Get the group permissions second.
		$sql = "SELECT group_gallery_perm FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g 
			WHERE ug.user_id = '$user_id' AND g.group_id = ug.group_id";
		if ( !($result = $this->db->query($sql)) ) {
			message_die(GENERAL_ERROR, 'Could not select Gallery permission from user, usergroup table', '', __LINE__, __FILE__, $sql);
		}
		$max_perm = 0;
		while($rowg = $this->db->fetch_row($result)) {
			if($max_perm < $rowg[0]) {
				$max_perm = $rowg[0]; 
			}
		}

		// Use whichever value is highest.
		if ($max_perm > $row[0]) {
			$gallery_perm = $max_perm;
		}
		else {
			$gallery_perm = $row[0];
		}
		return $gallery_perm;
	}


	function isLoggedIn() {
		if ($this->uid != -1) {
			return true;
		} else {
			return false;
		}
	}
}

?>
