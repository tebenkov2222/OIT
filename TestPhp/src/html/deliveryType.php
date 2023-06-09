<?php 

require_once __DIR__ . '/scripts/fields.php';
session_start();

if($_SESSION['deliveryData'] == 1)
{
	header('Location: /results.php');
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

 ?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Delivery Type</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top:50px">
    <div id="user-type-form" class="row">
        <div class="col-md-6 offset-md-3">
            <form method="post" action="/scripts/functions.php">	
				<input type="hidden" name="requestType" value="deliveryType">

				<div class="form-check">
            	<input class="form-check-input" type="radio" name="deliveryType" value="1" <?php echo $_SESSION['deliveryType'] == 1?"checked":""; ?> onchange="SetDelivery(1, this.checked);" required checked>
            	  <label class="form-check-label">
				    Доставка
				  </label>
				</div>
				<div style="display: <?php echo $_SESSION['deliveryType'] != 2?"block":"none"; ?>;" id="adress-div" class="form-group">
            	  	<label class="" >
				    	Адрес доставки
				  	</label>
            		<input id="adress-input" class="form-control" type="text" name="adress" required <?php echo $_SESSION['deliveryType'] == 2?"disabled":""; ?>>
            		<?php 
				  		if($_GET['errorType'] == "adress"){
				  			echo '<b class="errorForm">Адрес неверно введен</b><br>';
				  		}
				  	 ?>
            	</div>
				<div class="form-check">
            	<input class="form-check-input" type="radio" name="deliveryType" value="2" <?php echo $_SESSION['deliveryType'] == 2?"checked":""; ?>  onchange="SetDelivery(2, this.checked);" required >
        	  	<label class="form-check-label">
			    	Самовывоз
			  	</label>
			  	</div>
				<div style="display: <?php echo $_SESSION['deliveryType'] == 2?"block":"none"; ?>;" id="pickup-div" class="form-group">
            	  	<label class="" >
				    	Адрес пункта выдачи
				  	</label>
				  	<select id="pickup-input" name="pickupAdress" class="form-select" aria-label="Адрес самовывоза" required <?php echo $_SESSION['deliveryType'] == 1?"disabled":""; ?> >
					  <option selected>Выберите адрес</option>
					  <option value="1">ул. Сталина, 76</option>
					  <option value="2">пр. Славы, 80</option>
					  <option value="3">пер. Гагарина, 29</option>
					</select>
					<?php 
				  		if($_GET['errorType'] == "pickupAdress"){
				  			echo '<b class="errorForm">Адрес неверно введен</b><br>';
				  		}
				  	 ?>
            	</div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
    </div>
<script type="text/javascript">
	function SetDelivery(deliveryType, ischecked){
		if(ischecked){
			adressDiv = document.getElementById('adress-div');
			adressinput = document.getElementById('adress-input');
			pickupDiv = document.getElementById('pickup-div');
			pickupinput = document.getElementById('pickup-input');
			if(deliveryType == 1){
				adressDiv.style.display = 'block';
				pickupDiv.style.display = 'none';
				adressinput.disabled = false;
				pickupinput.disabled = true;
			}
			if(deliveryType == 2){
				adressDiv.style.display = 'none';
				pickupDiv.style.display = 'block';
				adressinput.disabled = true;
				pickupinput.disabled = false;

			}
		}
	}
</script>
</body>
</html>