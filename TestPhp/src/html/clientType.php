<?php 

require_once __DIR__ . '/scripts/fields.php';
session_start();

if($_POST['reset']){
	session_destroy();
}

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
if($_SESSION['clientData'] == 1)
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
	<title>Client Type</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top:50px">
	    <div id="user-type-form" class="row">
	        <div class="col-md-6 offset-md-3">
	            <form method="post" action="scripts/functions.php">	
					<input type="hidden" name="requestType" value="clientType">
					<div class="form-check">
	            		<input class="form-check-input" type="radio" name="clientType" value="1" checked required>
	            	  	<label class="form-check-label">
					    	Физическое лицо
					  	</label>
					</div>
					<div class="form-check">
	            		<input class="form-check-input" type="radio" name="clientType" value="2" required>
	        	  		<label class="form-check-label">
				    		Юридическое лицо
				  		</label>
				  	</div>
				  	<?php 
				  		if($_GET['errorType'] == "clientType"){
				  			echo "<a>Данные введены неверно</a><br>";
				  		}
				  	 ?>
	                <button type="submit" class="btn btn-primary">Submit</button>
            	</form>
	        </div>
	    </div>
    </div>
</body>
</html>