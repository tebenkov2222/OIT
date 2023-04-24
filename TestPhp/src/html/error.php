 <?php 

  ?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Error</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body> 
	<p class="h1">Что то пошло не по плану</p>
	<p class="h2">
		<?php
		if (isset($_GET['errorType']))
		{
		    $var = $_GET['errorType'];
		}
		echo $var;
		?>
			
		</p>
</body>
</html>
