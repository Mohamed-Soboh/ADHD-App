<?php 
$records = getUserVmessage();
$utype = '';
$type = $_SESSION['calendar_fd_user']['type'];
if($type == 'admin' || $type == 'teacher') {
	$utype = 'on';
}
?>

<div class="col-md-12">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">User message</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 10px">#</th>
          <th>Name</th>
           <th>User Role</th>
         <th>voice record</th>
        </tr>
        <?php
	  $idx = 1;
    if($records!=null)
	  foreach($records as $rec) {
	  	extract($rec);
		
		?>
        <tr>
          <td><?php echo $idx++; ?></td>
           <td><?php echo $sender_name; ?></td>
           

          <td>
		  <i class="fa <?php echo $type == 'teacher' ? 'fa-user' : 'fa-users' ; ?>" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo strtoupper($type); ?></i></td>
                
        <td> <?php
         echo '<audio controls>';
         echo '<source src="data:audio/ogg;base64,' . base64_encode($audio_data) . '" type="audio/ogg">';
         echo '</audio>';
       ?></td>

          <?php if($utype == 'on') { ?>
		  
		  <?php }?>
       



  <!-- Display the list of recordings -->
   


        </tr>

        <?php } ?>

      </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
	
	<?php 
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'admin') {
	?>
	<button type="button" class="btn btn-info" onclick="javascript:createUserForm();"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;Create a new User</button>
	<?php 
	}
	?>

      <?php echo generatePagination(); ?> </div>
  </div>
</div>

<script language="javascript">
function createUserForm() {
	window.location.href = '<?php echo WEB_ROOT; ?>views/?v=CREATE';
}
function status(userId, status) {
	if(confirm('Are you sure you wants to ' + status+ ' it ?')) {
		window.location.href = '<?php echo WEB_ROOT; ?>views/process.php?cmd=change&action='+ status +'&userId='+userId;
	}
}


</script>
