<?php require_once '../library/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
	
	<title>Display All Videos from database using php</title>
</head>
<body>

	<div class="container mt-3 mb-3">
		<h1><b>Relax and Motivation Video </b></h1>
		
		<div class="row">
				<?php
				 
					
				$q = "SELECT * FROM video";
                $query = dbQuery($q);
			//	$query = mysqli_query($conn,$q);
				
				while($row=mysqli_fetch_array($query)) { 

					$name = $row['name'];
					?>

					<div class="col-md-4">
						<video width="100%" controls>
<source src="<?php echo '../upload/'.$name;?>">
</video>
					</div>

				<?php }
?>
</div>
				</div>
</body>
</html>