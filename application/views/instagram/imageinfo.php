<?php 
$this->load->view('common/menu'); 
var_dump($info);
die();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		IMAGE!
	</title>
</head>
<body>
 <iframe src=<?php echo $info[0]['imageurl'];?> width="320" height="320" scrolling="no" align="middle"></iframe> 

 <table style="width:100%; " align="left" >
 	<tr>
    	<th>ID</th>
    	<th>LIKES</th>
    	<th>SOURCE</th>
    	<th>USERNAME</th>
    	<th>IMAGEID</th>
    	<th>CREATED AT</th>
        <th>STATUS</th>
        <th>TAGS</th>
    </tr>	
    <br />
    <tr>
    	<td><?php echo $info[0]['id']; ?></td>
    	<td><?php echo $info[0]['likes']; ?></td>
    	<td><?php echo $info[0]['source']; ?></td>
    	<td><?php echo $info[0]['username']; ?></td>
    	<td><?php echo $info[0]['imageid']; ?></td>
    	<td><?php echo $info[0]['createdat']; ?></td>
        <td><?php echo $info[1]['status']; ?></td>
        <!-- <td>
        <?php 
            foreach($info[4] as $tag)
                echo $tag.'<br />'
        ?>
        </td> -->
  </tr>
</table>
</body>
</html> 