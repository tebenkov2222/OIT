<?php 

require_once __DIR__ . '/scripts/fields.php';
session_start();

if(CheckField($_SESSION['deliveryType'], true, '/^[1,2]{1}$/'))
{
	header('Location: /results.php');
	exit();
}
if(CheckField($_SESSION['phone'], true, '/^[+7]\d{11}$/'))
{
	header('Location: /deliveryType.php');
	exit();
}
if(!CheckField($_SESSION['clientType'], true, '/^[1,2]{1}$/'))
{
	header('Location: /clientType.php');
	exit();
}
if($_SESSION['clientType'] == 1)
{
	header('Location: /clientIndividualData.php');
	exit();
} 
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Client Entity Data</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top:50px">
	    <div id="user-type-form" class="row">
	        <div class="col-md-6 offset-md-3">
	            <form method="post" action="scripts/functions.php">	
					<input type="hidden" name="requestType" value="clientDataEntity">
					<div class="form-group">
	            	  	<label class="" >
					    	Название
					  	</label>
	            		<input class="form-control" type="text" name="name" required>
	            	</div>
					<div class="form-group">
	            	  	<label class="" >
					    	ИНН
					  	</label>
	            		<input class="form-control" type="text" name="inn" pattern="^\d{10}$|^\d{12}$" required>
	            	</div>
					<div class="form-group">
	            	  	<label class="" >
					    	Телефон
					  	</label>
	            		<input class="form-control" type="text" name="phone" pattern="^[+7]\d{11}$" required>
	            	</div>
	                <button type="submit" class="btn btn-primary">Submit</button>
            	</form>
	        </div>
	    </div>
    </div>
</body>
</html>