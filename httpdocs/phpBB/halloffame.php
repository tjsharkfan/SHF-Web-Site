<?php 

// standard hack prevent 
define('IN_PHPBB', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

// standard session management 
$userdata = session_pagestart($user_ip, PAGE_HALLOFFAME); 
init_userprefs($userdata); 

// set page title 
$page_title = 'HALLOFFAME'; 

// standard page header 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

// assign template 
$template->set_filenames(array( 
        'body' => 'halloffame.tpl') 
); 

make_jumpbox('viewforum.'.$phpEx, $forum_id);

$template->pparse('body'); 

// standard page footer 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>