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
	
	<h2>Images</h2>
	<br />
	
	<?php 
	echo '<br />';
	
	for($i = 0; $i < $count;$i = $i + 1)
		echo $images[$i];
	?>
	
	<br />
	<a href="/index.php/site/home">Home</a>
	<br />
	<a href="/index.php/site/about">About</a>
	<br />
	<a href="/index.php/site/data">Data</a>
	
</div>

</body>
</html>