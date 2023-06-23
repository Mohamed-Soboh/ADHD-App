<?php 
$records = getBookingRecords();
$utype = '';
$type = $_SESSION['calendar_fd_user']['type'];
if($type == 'admin') {
	$utype = 'on';
}
?>

<div class="col-md-12">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Tasks table:</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 10px">#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Task</th>
          <th>Date & Time
          </th>
          
          
          <?php if($utype == 'on') { ?>
		  <th >Action</th>
		  <?php } ?>
        </tr>
        <?php
	  $idx = 1;
	  foreach($records as $rec) {
	  	extract($rec);
		$stat = '';
		if($status == "PENDING") {$stat = 'warning';}
		else if ($status == "APPROVED") {$stat = 'success';}
		else if($status == "DENIED") {$stat = 'danger';}
		?>
        <tr>
          <td><?php echo $idx++; ?></td>
          <td><a href="<?php echo WEB_ROOT; ?>views/?v=USER&ID=<?php echo $id; ?>"><?php echo strtoupper($user_name); ?></a></td>
          <td><?php echo $user_email; ?></td>
          <td><?php echo $comments; ?></td>
          <td><?php echo $res_date; ?></td>
         
          
          <?php if($utype == 'on') { ?>
		  <td><?php if($status == "PENDING") {?>
            <a href="javascript:approve('<?php echo $user_id ?>');">Approve</a>&nbsp;/
			&nbsp;<a href="javascript:decline('<?php echo $user_id ?>');">Denied</a>&nbsp;/
			&nbsp;<a href="javascript:deleteUser('<?php echo $user_id ?>');">Delete</a>
            <?php } else { ?>
			<a href="javascript:deleteUser('<?php echo $user_id ?>');">Delete</a>
			<?php }//else ?>
          </td>
		  <?php } ?>
        </tr>
        <?php } ?>
      </table>
    
