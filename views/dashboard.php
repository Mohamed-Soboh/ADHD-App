<div class="col-md-8">
  <?php include('calendar.php'); ?>
</div>
<!-- /.col -->
<div class="col-md-4">
<?php 
$type = $_SESSION['calendar_fd_user']['type'];
$id=$_SESSION['calendar_fd_user']['id'];
if ($type=='student') {
include('eventform.php');}
	

	echo "&nbsp;";

?>	
</div>
<!-- /.col -->
