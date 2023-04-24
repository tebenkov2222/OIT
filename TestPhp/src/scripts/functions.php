<?php

if(!isset($_POST['requestType'])){
	header('Location: error.php');
}
session_start();
if (in_array($_POST['requestType'], $requests)) {
    echo "$_POST['requestType']";
    return;
}
switch ($_POST['variable']) {
	case 'value':
		// code...
		break;
	
	default:
		// code...
		break;
}
if ($_SESSION['user_type'] == 'individual') {
  $_SESSION['name'] = $_POST['name'];
  $_SESSION['phone'] = preg_replace('/[^0-9]/', '', $_POST['phone']); // убрать не цифры
} else {
  $_SESSION['company_name'] = $_POST['company_name'];
  $_SESSION['inn'] = preg_replace('/[^0-9]/', '', $_POST['inn']); // убрать не цифры
  $_SESSION['phone'] = $_POST['phone'];
}
?>