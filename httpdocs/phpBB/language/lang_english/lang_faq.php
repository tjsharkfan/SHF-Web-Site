<?php
/***************************************************************************
 *                          lang_faq.php [english]
 *                            -------------------
 *   begin                : Wednesday Oct 3, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: lang_faq.php,v 1.4.2.3 2002/12/18 15:40:20 psotfx Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

/* CONTRIBUTORS:
	2002-12-15	Philip M. White (pwhite@mailhaven.com)
		Fixed many minor grammatical problems.
*/
 
// 
// To add an entry to your FAQ simply add a line to this file in this format:
// $faq[] = array("question", "answer");
// If you want to separate a section enter $faq[] = array("--","Block heading goes here if wanted");
// Links will be created automatically
//
// DO NOT forget the ; at the end of the line.
// Do NOT put double quotes (") in your FAQ entries, if you absolutely must then escape them ie. \"something\"
//
// The FAQ items will appear on the FAQ page in the same order they are listed in this file
//
 
  
$faq[] = array("--","Login and Registration Issues");
$faq[] = array("Why can't I log in?", "Have you registered? Seriously, you must register in order to log in. Have you been banned from the board? (A message will be displayed if you have.) If so, you should contact the webmaster or board administrator to find out why. If you have registered and are not banned and you still cannot log in then check and double-check your username and password. Usually this is the problem; if not, contact the board administrator -- they may have incorrect configuration settings for the board.");
$faq[] = array("Why do I need to register at all?", "Registering allows you post messages under your registered name (instead of Guest), allows you to receive new posted message notifications, and allows you to attach a picture to your name. It only takes a few minutes to register so it is recommended you do so.");
$faq[] = array("Why do I get logged off automatically?", "If you do not check the <i>Log me in automatically</i> box when you log in, the board will only keep you logged in for a preset time. This prevents misuse of your account by anyone else. To stay logged in, check the box during login. This is not recommended if you access the board from a shared computer, e.g. library, internet cafe, university cluster, etc.");
$faq[] = array("How do I prevent my username from appearing in the online user listings?", "In your profile you will find an option <i>Hide your online status</i>; if you switch this <i>on</i> you'll only appear to board administrators or to yourself. You will be counted as a hidden user.");
$faq[] = array("I've lost my password!", "Don't panic! While your password cannot be retrieved it can be reset. To do this go to the login page and click <u>I've forgotten my password</u>. Follow the instructions and you should be back online in no time.");
$faq[] = array("I registered but cannot log in!", "First check that you are entering the correct username and password, then contact the board administrator.");
$faq[] = array("I registered in the past but cannot log in anymore!", "The most likely reasons for this are: you entered an incorrect username or password (check the email you were sent when you first registered) or the administrator has deleted your account for some reason.");


$faq[] = array("--","User Preferences and settings");
$faq[] = array("How do I change my settings?", "All your settings (if you are registered) are stored in the database. To alter them click the <u>Profile</u> link (generally shown at the top of pages but this may not be the case). This will allow you to change all your settings.");
$faq[] = array("The times are not correct!", "The times are almost certainly correct; however, what you may be seeing are times displayed in a timezone different from the one you are in. If this is the case, you should change your profile setting for the timezone to match your particular area, e.g. we are GMT-8 hours or GMT-7 hours depending on whether we are on daylight savings time or not. Please note that changing the timezone, like most settings, can only be done by registered users. So if you are not registered, this is a good time to do so, if you pardon the pun!");
$faq[] = array("I changed the timezone and the time is still wrong!", "If you are sure you have set the timezone correctly and the time is still different, the most likely answer is daylight savings time. The board is not designed to handle the changeovers between standard and daylight time so during summer months the time may be an hour different from the real local time.");
$faq[] = array("My language is not in the list!", "The most likely reasons for this are either the administrator did not install your language or someone has not translated this board into your language. Try asking the board administrator if they can install the language pack you need or if it does not exist, please feel free to create a new translation. More information can be found at the phpBB Group website (see link at bottom of pages)");
$faq[] = array("How do I show an image below my username?", "There may be two images below a username when viewing posts. The first is an image associated with your rank; generally these take the form of stars or blocks indicating how many posts you have made or your status on the forums. Below this may be a larger image known as an avatar; this is generally unique or personal to each user. Avatars are chosen in the Profile page.)");
$faq[] = array("How do I change my rank?", "Your rank, indicated my the number of stars you have is incremented everytime at 25, 50, 75, 100 and 125 posted messages.");
$faq[] = array("When I click the email link for a user it asks me to log in.", "Sorry, but only registered users can send email to people via the built-in email form (if the admin has enabled this feature). This is to prevent malicious use of the email system by anonymous users.");


$faq[] = array("--","Posting Issues");
$faq[] = array("How do I post a topic in a forum?", "Easy -- click the New Topic button on either the forum or topic screens. You will need to register before you can post a message. The facilities available to you are listed at the bottom of the forum and topic screens (the <i>You can post new topics, You can vote in polls, etc.</i> list)");
$faq[] = array("How do I edit or delete a post?", "Unless you are the board admin or forum moderator you can only edit or delete your own posts. You can edit a post by clicking the <i>edit</i> button for the relevant post.  If someone has already replied to the post, you will find a small piece of text output below the post when you return to the topic that lists the number of times you edited it. This will only appear if no one has replied; it also will not appear if moderators or administrators edit the post (they should leave a message saying what they altered and why). Please note that normal users cannot delete a post once someone has replied.");
$faq[] = array("How do I add a signature to my post?", "To add a signature to a post you must first create one; this is done via your profile. Once created you can check the <i>Add Signature</i> box on the posting form to add your signature. You can also add a signature by default to all your posts by checking the appropriate radio box in your profile. You can still prevent a signature being added to individual posts by un-checking the add signature box on the posting form.");
$faq[] = array("How do I create a poll?", "Creating a poll is easy -- when you post a new topic (or edit the first post of a topic, if you have permission) you should see a <i>Add Poll</i> form below the main posting box. If you cannot see this then you probably do not have rights to create polls. You should enter a title for the poll and then at least two options -- to set an option type in the poll question and click the <i>Add option</i> button. You can also set a time limit for the poll, 0 being an infinite amount. There will be a limit to the number of options you can list, which is set by the board administrator");
$faq[] = array("How do I edit or delete a poll?", "As with posts, polls can only be edited by the original poster, a moderator, or board administrator. To edit a poll, click the first post in the topic, which always has the poll associated with it. If no one has cast a vote then users can delete the poll or edit any poll option. However, if people have already placed votes only moderators or administrators can edit or delete it; this is to prevent people rigging polls by changing options mid-way through a poll");
$faq[] = array("Why can't I access a forum?", "Some forums may be limited to certain users. To view, read, post, etc. you may need special authorization which only the forum moderator and board administrator can grant, so you should contact them.");
$faq[] = array("Why can't I vote in polls?", "Only registered users can vote in polls so as to prevent spoofing of results. If you have registered and still cannot vote then you probably do not have appropriate access rights.");


$faq[] = array("--","Formatting and Topic Types");
$faq[] = array("What is BBCode?", "BBCode stands for Bulletin-Board Code is a special implementation of HTML. Whether you can use BBCode is determined by the administrator. You can also disable it on a per post basis from the posting form. BBCode itself is similar in style to HTML: tags are enclosed in square braces [ and ] rather than &lt; and &gt; and it offers greater control over what and how something is displayed. For more information on BBCode see the guide which can be accessed from the posting page.");
$faq[] = array("Can I use HTML?", "That depends on whether the administrator allows you to; they have complete control over it. If you are allowed to use it, you will probably find only certain tags work. This is a <i>safety</i> feature to prevent people from abusing the board by using tags which may destroy the layout or cause other problems. If HTML is enabled you can disable it on a per post basis from the posting form.");
$faq[] = array("What are Smileys?", "Smileys, or Emoticons, are small graphical images which can be used to express some feeling using a short code, e.g. :) means happy, :( means sad. The full list of emoticons can be seen via the posting form.");
$faq[] = array("Can I post Images?", "Images can indeed be shown in your posts. You can post an image by uploading the image as a file attachment or you can create a link to your image on another web server. You cannot link to pictures stored on your own PC (unless it is a publicly accessible server) nor to images stored behind authentication mechanisms such as Hotmail or Yahoo mailboxes, password-protected sites, etc. To display the image inline with your message use either the BBCode [img] tag or appropriate HTML (if allowed). To display the image as an attachment simply upload the image as a file attachment.");
$faq[] = array("What are Announcements?", "Announcements are messages that appear at the top of every page in the forum to which they are posted.");
$faq[] = array("What are Sticky topics?", "Sticky topics are messages that appear below any announcements and only on the first page.");
$faq[] = array("How are topics organized?", "Chronologically. The most recent topic is always displayed at the top of the forum. Likewise, the oldest topic is always at the bottom of the forum. Replying to a topic makes it the 'most recent' sending it to the top. Many people like this method because the most active topics tend to stay at the top of the forum while neglected topics sink to the bottom.");
$faq[] = array("Can I organize my topics any way I want?", "Yes. If you don't like the default chronological ordering you can specify where your topics will be displayed if you are a 'moderator'. A moderator is a user who has additional powers to re-organize, delete, edit and move topics within your forums. If you would like moderator powers please contact the administrator. Good moderaters are people who are fairly computer savvy and organized. Once you're a moderator, you can assign priorities to specific topics by clicking on the 'You can moderate this forum' link found in the bottom right hand corner as you're viewing a list of topics in a forum. By default, all topics have a priority of 0 and are therefor ordered chronologically. You can assign priorities between +10,000 and -10,000 to any topic. Click on the prioritize button to assign your priority.");
$faq[] = array("What are Locked topics?", "Locked topics are set this way by either the forum moderator or board administrator. You cannot reply to locked topics and any poll contained inside is automatically ended. Topics may be locked for many reasons.");


$faq[] = array("--","User Levels and Groups");
$faq[] = array("What are Administrators?", "Administrators are people assigned the highest level of control over the entire board. These people can control all facets of board operation which include setting permissions, banning users, creating usergroups or moderators, etc. They also have full moderator capabilities in all the forums.");
$faq[] = array("What are Moderators?", "Moderators are individuals (or groups of individuals) whose job it is to look after the running of the forums from day to day. They have the power to edit or delete posts and lock, unlock, move, delete and split topics in the forum they moderate.");
$faq[] = array("What are User Groups?", "A Usergroup is a logical grouping of registered users.");
$faq[] = array("How do I join a Usergroup Group?", "To join a group click the Usergroup link in the navigation bar and you can then view all available groups. Not all groups are <i>open access</i> -- some are closed and some may even have hidden memberships. If the group is open then you can request to join it by clicking the appropriate button. The group moderator will need to approve your request.");
$faq[] = array("How do I become a group Moderator?", "Contact the Admin..");


$faq[] = array("--","Printer-Friendly Topic View");
$faq[] = array("What is the :| |: button for? - Cancelling the bulletin board's pagination", "By clicking on this button you can temporarily remove the bulletin board's fixed pagination for the current topic. This will help your web browser do the proper pagination for printing based on actual line spacing, rather than the forum-wide limit for number of messages per page.");
$faq[] = array("What are the boxes on top of the printable output? - Range selection", "There are two boxes on top of the page followed by the Show button. They allow you to select a range of messages to display. Note that every message in the printable view has a number. Use those numbers to fill in the boxes to select the first and the last message you want to be printed. Then click on the Show button to rearrange the messages. Another way to set a range is to put a negative number in the second box. This indicates that you want n messages to be printed. For example, (4, 7) will output messages 4, 5, 6, 7. However if you enter values (4,-7) messages 4, 5, 6, 7, 8, 9, 10 will be shown after you click on the Show button.");
$faq[] = array("How to print only one message? - Advanced range selection", "First, go to the printable view of the topic by clicking on the Printer button in the topic view. Find your message and note the number to the left of it. Type that number into the first box at the top left of the printable view. In the second box put value -1 and click on the Show button. This will output only one message starting from the number in the first box. Another way of getting this result is by putting the same number in both boxes.");


$faq[] = array("--","Private Messaging");
$faq[] = array("I cannot send private messages!", "There are three reasons for this; you are not registered and/or not logged on, the board administrator has disabled private messaging for the entire board, or the board administrator has prevented you individually from sending messages. If it is the latter case you should try asking the administrator why.");
$faq[] = array("I keep getting unwanted private messages!", "In the future we will be adding an ignore list to the private messaging system. For now, though, if you keep receiving unwanted private messages from someone, inform the board administrator -- they have the power to prevent a user from sending private messages at all.");
$faq[] = array("I have received a spamming or abusive email from someone on this board!", "The email form feature of this board includes safeguards to try to track users who send such posts. You should email the board administrator with a full copy of the email you received and it is very important this include the headers (these list details of the user that sent the email). They can then take action.");

//
// These entries should remain in all languages and for all modifications
//
$faq[] = array("--","phpBB 2 Issues");
$faq[] = array("Who wrote this bulletin board?", "This software (in its unmodified form) is produced, released and is copyrighted <a href=\"http://www.phpbb.com/\" target=\"_blank\">phpBB Group</a>. It is made available under the GNU General Public License and may be freely distributed; see link for more details");
$faq[] = array("Why isn't X feature available?", "This software was written by and licensed through phpBB Group. If you believe a feature needs to be added then please visit the phpbb.com website and see what the phpBB Group has to say. Please do not post feature requests to the board at phpbb.com, as the Group uses sourceforge to handle tasking of new features. Please read through the forums and see what, if any, our position may already be for features and then follow the procedure given there.");
$faq[] = array("Whom do I contact about abusive and/or legal matters related to this board?", "You should contact the administrator of this board. If you cannot find who that is, you should first contact one of the forum moderators and ask them who you should in turn contact. If still get no response you should contact the owner of the domain (do a whois lookup) or, if this is running on a free service (e.g. yahoo, free.fr, f2s.com, etc.), the management or abuse department of that service. Please note that phpBB Group has absolutely no control and cannot in any way be held liable over how, where or by whom this board is used. It is absolutely pointless contacting phpBB Group in relation to any legal (cease and desist, liable, defamatory comment, etc.) matter not directly related to the phpbb.com website or the discrete software of phpBB itself. If you do email phpBB Group about any third party use of this software then you should expect a terse response or no response at all.");

//
// This ends the FAQ entries
//

?>