<?php

require_once __DIR__ . '/fields.php';

if(empty($_POST)) ShowErrorPage();
if(!isset($_POST['requestType'])) ShowErrorPage("Post Error");
switch ($_POST['requestType']) {
	case 'clientType':
		HandleClientTypeRequest();
		break;

	case 'clientDataIndividual':
		HandleCliendIndividualDataRequest();
		break;

	case 'clientDataEntity':
		HandleCliendEntityDataRequest();
		break;

	case 'deliveryType':
		HandleDeliveryTypeRequest();
		break;
	default:
		ShowErrorPage("Post Request not found");
		break;
}
function ShowErrorPage($errorType){
	ShowPage('../error.php?errorType=' . $errorType);
}
function ShowPage($pageName){
	header('Location: ' . $pageName);
	die();
}
function HandleClientTypeRequest(){
	session_start();
	if(!CheckField($_POST['clientType'], true, '/^[1,2]{1}$/')) ShowErrorPage("Wrong ClientType");
	$_SESSION['clientType'] = $_POST['clientType'];
	if($_POST['clientType'] == 1){
		ShowPage('../clientIndividualData.php');
	}
	else{
		ShowPage('../clientEntityData.php');
	}
}
function HandleCliendIndividualDataRequest(){

	session_start();
	if(!CheckField($_SESSION['clientType'], true, '/^[1|2]{1}$/')) ShowErrorPage("ClientType is Not defined");
	if($_SESSION['clientType'] != 1) ShowErrorPage("ClientType Wrong");
	if(!CheckField(trim($_POST['name']), true, null)) ShowErrorPage("Wrong Name");
	if(!CheckField($_POST['phone'], true, '/^[+7]\d{11}$/')) ShowErrorPage("Wrong Phone");
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['phone'] = $_POST['phone'];

	ShowPage('../deliveryType.php');
}
function HandleCliendEntityDataRequest(){

	session_start();
	if(!CheckField($_SESSION['clientType'], true, '/^[1|2]{1}$/')) ShowErrorPage("ClientType is Not defined");
	if($_SESSION['clientType'] != 2) ShowErrorPage("ClientType Wrong");
	if(!CheckField(trim($_POST['name']), true, null)) ShowErrorPage("Wrong Name");
	if(!CheckField(trim($_POST['inn']), true, '/^\d{10}$|^\d{12}$/')) ShowErrorPage("Wrong INN");
	if(!CheckField($_POST['phone'], true, '/^[+7]\d{11}$/')) ShowErrorPage("Wrong Phone");
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['inn'] = $_POST['inn'];
	$_SESSION['phone'] = $_POST['phone'];


	ShowPage('../deliveryType.php');
}
function HandleDeliveryTypeRequest(){
	session_start();
	if(!CheckField($_SESSION['phone'], true, '/^[+7]\d{11}$/')) ShowErrorPage("Wrong Phone");
	if(!CheckField($_POST['deliveryType'], true, '/^[1|2]{1}$/')) ShowErrorPage("Wrong Delivery");
	if($_POST['deliveryType'] == 1){
		if(!CheckField(trim($_POST['adress']), true, null)) ShowErrorPage("Wrong Adress");
		$_SESSION['adress'] = $_POST['adress'];
	}
	else {
		if(!CheckField($_POST['pickupAdress'], true, '/^[1|2|3]{1}$/')) ShowErrorPage("Wrong Pickup Adress");
		$_SESSION['pickupAdress'] = $_POST['pickupAdress'];
	}
	$_SESSION['deliveryType'] = $_POST['deliveryType'];
	
	ShowPage('../results.php');
}
?>