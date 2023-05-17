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
function ShowErrorPage($errorPage, $errorType){
	ShowPage($errorPage . '?errorType=' . $errorType);
}
function ShowPage($pageName){
	header('Location: ' . $pageName);
	die();
}
function HandleClientTypeRequest(){
	session_start();
	$_SESSION['clientType'] = $_POST['clientType'];
	if(!CheckField($_POST['clientType'], true, '/^[1,2]{1}$/')) ShowErrorPage("../clientType.php","clientType");
	$_SESSION['clientTypeExist'] = 1;
	
	if($_POST['clientType'] == 1){
		ShowPage('../clientIndividualData.php');
	}
	else{
		ShowPage('../clientEntityData.php');
	}

}
function HandleCliendIndividualDataRequest(){

	session_start();
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['phone'] = $_POST['phone'];

	if(!CheckField(trim($_POST['name']), true, null)) ShowErrorPage("../clientIndividualData.php","name");
	if(!CheckField($_POST['phone'], true, '/^[+7]\d{11}$/')) ShowErrorPage("../clientIndividualData.php","phone");

	$_SESSION['clientData'] = 1;

	ShowPage('../deliveryType.php');
}
function HandleCliendEntityDataRequest(){

	session_start();

	$_SESSION['name'] = $_POST['name'];
	$_SESSION['inn'] = $_POST['inn'];
	$_SESSION['phone'] = $_POST['phone'];

	if(!CheckField(trim($_POST['name']), true, null)) ShowErrorPage("../clientEntityData.php","name");
	if(!CheckField(trim($_POST['inn']), true, '/^\d{10}$|^\d{12}$/')) ShowErrorPage("../clientEntityData.php","inn");
	if(!CheckField($_POST['phone'], true, '/^[+7]\d{11}$/')) ShowErrorPage("../clientEntityData.php","phone");
	
	$_SESSION['clientData'] = 1;

	ShowPage('../deliveryType.php');
}
function HandleDeliveryTypeRequest(){
	session_start();

	$_SESSION['deliveryType'] = $_POST['deliveryType'];
	$_SESSION['adress'] = $_POST['adress'];
	$_SESSION['pickupAdress'] = $_POST['pickupAdress'];

	if($_POST['deliveryType'] == 1){
		if(!CheckField(trim($_POST['adress']), true, null)) ShowErrorPage("../deliveryType.php","adress");
		$_SESSION['deliveryData'] = 1;
	}
	else {
		if(!CheckField($_POST['pickupAdress'], true, '/^[1|2|3]{1}$/')) ShowErrorPage("../deliveryType.php","pickupAdress");
		$_SESSION['deliveryData'] = 1;
	}
	
	ShowPage('../results.php');
}
?>