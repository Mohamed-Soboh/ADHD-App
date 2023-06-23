<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <ul class="sidebar-menu">
    <li class="header">MENU</li>
    <li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=DB"><i class="fa fa-calendar"></i><span>Tasks Calendar</span></a>
	</li>
	 
    <li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=LIST"><i class="fa fa-newspaper-o"></i><span>Task list</span></a>
	<li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=USERS"><i class="fa fa-users"></i><span>Personal Details</span></a>
	</li>
	<?php 
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'student') {
	?>
	<li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=HOLY"><i class="fa fa-plane"></i><span>Holidays</span></a>
	</li>
	 
	</li>
	<li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=talk"><i class="fa fa-users"></i><span>chat</span></a>
	</li>
	<li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=MSG"><i class="fa fa-inbox"></i><span>Message</span></a>
	</li>
	<li class="treeview"><a href="<?php echo WEB_ROOT; ?>views/?v=VMSG"><i class="fa fa-inbox"></i><span>Voice Messages</span></a>
	</li>
	<li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=Stars"><i class="fa fa-star"></i><span>Benefits zone</span></a>
	</li>
	<li class="treeview"> 
		<a href="<?php echo WEB_ROOT; ?>views/?v=RMO"><i class="fa fa-plane"></i><span>Relax&Motivation</span></a>
	</li>
	<?php
	}
	?>
  </ul>
</section>
<!-- /.sidebar -->

<i class="fa-sharp fa-solid fa-notes"></i>