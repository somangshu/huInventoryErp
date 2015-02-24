<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php echo $title ?>
	</title>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>
	
	<h2>Data</h2>
	<br />
	<a href="/index.php/site/home">Home</a>
	<br />
	<a href="/index.php/site/about">About</a>
	<br />
	<a href="/index.php/site/data">Data</a>
	
	<?php 
	echo '<br />';
	//print_r($result);
	foreach ($result as $row)
	{
		echo $row->ID." ";
		echo $row->Name." ";
		echo $row->Position." ";
		echo $row->Joiing." ";
		echo '<br />';
	}
	?>
	
</div>

</body>
</html>