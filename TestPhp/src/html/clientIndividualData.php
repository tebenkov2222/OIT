<?php 

require_once __DIR__ . '/scripts/fields.php';
session_start();

if($_SESSION['deliveryData'] == 1)
{
	header('Location: /results.php');
	exit();
}
if($_SESSION['clientData'] == 1)
{
	header('Location: /deliveryType.php');
	exit();
}
if($_SESSION['clientTypeExist'] != 1)
{
	header('Location: /clientType.php');
	exit();
} 
if($_SESSION['clientType'] == 2)
{
	header('Location: /clientEntityData.php');
	exit();
} 
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Client Individual Data</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top:50px">
	    <div id="user-type-form" class="row">
	        <div class="col-md-6 offset-md-3">
	            <form method="post" action="scripts/functions.php">	
					<input type="hidden" name="requestType" value="clientDataIndividual">
					<div class="form-group">
	            	  	<label class="" >
					    	Имя
					  	</label>
	            		<input class="form-control" type="text" name="name" value="<?php echo $_SESSION['name']; ?>" required>
	            		<?php 
					  		if($_GET['errorType'] == "name"){
					  			echo '<b class="errorForm">Имя неверно введено</b><br>';
					  		}
					  	 ?>
	            	</div>
					<div class="form-group">
	            	  	<label class="" >
					    	Телефон
					  	</label>
	            		<input class="form-control" type="text" name="phone" pattern="^[+7]\d{11}$" value="<?php echo $_SESSION['phone']; ?>" required>
	            		<?php 
					  		if($_GET['errorType'] == "phone"){
					  			echo '<b class="errorForm">Телефон неверно введен</b><br>';
					  		}
					  	 ?>
	            	</div>
	                <button type="submit" class="btn btn-primary">Submit</button>
            	</form>
	        </div>
	    </div>
    </div>
</body>
</html>