<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkFDUser();

$view = (isset($_GET['v']) && $_GET['v'] != '') ? $_GET['v'] : '';

switch ($view) {
	case 'LIST' :
		$content 	= 'eventlist.php';		
		$pageTitle 	= 'View Event Details';
		break;

	case 'USERS' :
		$content 	= 'userlist.php';		
		$pageTitle 	= 'View User Details';
		break;
	case 'NOTE' :
		$content 	= 'note.php';		
		$pageTitle 	= 'View User note';
		break;	
		case 'MSG' :
		$content 	= 'messagelist.php';		
		$pageTitle 	= 'View User message';
		break;
	case 'VMSG' :
		$content 	= 'voicemessagelist.php';		
		$pageTitle 	= 'View User Voice message';
	break;		
		case 'talk' :
		$content 	= 'C:\xampp\htdocs\event-management\event-management\chat.html';		
		$pageTitle 	= 'chat';
		break;	
	case 'CREATE' :
		$content 	= 'userform.php';		
		$pageTitle 	= 'Create New User';
		break;
		case 'Stars' :
		$content 	= 'C:\xampp\htdocs\event-management\event-management\store.php';		
		$pageTitle 	= 'Stars';
		break;
	case 'USER' :
		$content 	= 'user.php';		
		$pageTitle 	= 'View User Details';
		break;
	
	case 'HOLY' :
		$content 	= 'holidays.php';		
		$pageTitle 	= 'Holidays';
		break;	
	case 'RMO' :
		$content 	= 'video.php';		
		$pageTitle 	= 'Motivaton and R';
		break;	
	default :
		$content 	= 'dashboard.php';		
		$pageTitle 	= 'Calendar Dashboard';
}

require_once '../include/template.php';
?>
