<?php 
	require_once __DIR__ . '/scripts/fields.php';
	session_start();
	
	if(!CheckField($_SESSION['clientType'], true, '/^[1,2]{1}$/'))
	{
		header('Location: /clientType.php');
		exit();
	} 
	if(!CheckField($_SESSION['phone'], true, '/^[+7]\d{11}$/'))
	{
		if($_SESSION['clientType'] == 1) header('Location: /clientIndividualData.php');
		else header('Location: /clientEntityData.php');
		exit();
	}
	if(!CheckField($_SESSION['deliveryType'], true, '/^[1,2]{1}$/'))
	{
		header('Location: /deliveryType.php');
		exit();
	}
	if($_SESSION['deliveryData'] != 1)
	{
		header('Location: /deliveryType.php');
		exit();
	}
	if($_SESSION['clientTypeExist'] != 1)
	{
		header('Location: /clientType.php');
		exit();
	} 
	if($_SESSION['clientData'] != 1)
	{
		if($_SESSION['clientType'] == 1) header('Location: /clientIndividualData.php');
		else header('Location: /clientEntityData.php');
		exit();
	} 

	if (isset($_SESSION['clientType']))
	{
	    $clientType = $_SESSION['clientType'];
	}
	if (isset($_SESSION['name']))
	{
	    $name = $_SESSION['name'];
	}
	if (isset($_SESSION['phone']))
	{
	    $phone = $_SESSION['phone'];
	}
	if (isset($_SESSION['inn']))
	{
	    $inn = $_SESSION['inn'];
	}
	if (isset($_SESSION['deliveryType']))
	{
	    $deliveryType = $_SESSION['deliveryType'];
	}
	if (isset($_SESSION['adress']))
	{
	    $adress = $_SESSION['adress'];
	}
	if (isset($_SESSION['pickupAdress']))
	{
	    $pickupAdress = $_SESSION['pickupAdress'];
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<div class="container" style="margin-top:50px">
    <div id="user-type-form" class="row">
        <div class="col-md-6 offset-md-3">
			<p class="h3"><?php echo $clientType == 1?"Физическое лицо" : "Юридическое лицо";?></p>
			<br>
			<?php 
			if($clientType == 1){
				echo '<p class="h3">Имя: ' . $name .' </p>';
				echo '<p class="h3">Телефон: ' . $phone .' </p>';
			}
			else{
				echo '<p class="h3">Название: ' . $name .' </p>';
				echo '<p class="h3">Инн: ' . $inn .' </p>';
				echo '<p class="h3">Телефон: ' . $phone .' </p>';
			}
			?>
			<br>
			<?php  
			if($deliveryType == 1){
				echo '<p class="h3">Способ доставки: Доставка</p>';
				echo '<p class="h3">Адрес доставки: ' . $adress .' </p>';
			}
			else{
				echo '<p class="h3">Способ доставки: Самовывоз</p>';
				if($pickupAdress == 1) $pickupAdressResult = 'ул. Сталина, 76';
				if($pickupAdress == 2) $pickupAdressResult = 'пр. Славы, 80';
				if($pickupAdress == 3) $pickupAdressResult = 'пер. Гагарина, 29';
				echo '<p class="h3">Адрес для самовывоза: ' . $pickupAdressResult .' </p>';
			}
			?>
		</div>
	</div>
	<div id="user-type-form" class="row">
        <div class="col-md-6 offset-md-3">
        	<form method="post" action="clientType.php">	
				<input type="hidden" name="reset" value="true">
                <button type="submit" class="btn btn-primary">Пройти снова</button>
        	</form>
        </div>
    </div>
</div>
</body>
</html>