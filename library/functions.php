<?php
require_once('mail.php');


function random_string($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return strtoupper($randomString);
}

/*
	Check if a session user id exist or not. If not set redirect
	to login page. If the user session id exist and there's found
	$_GET['logout'] in the query string logout the user
*/
function checkFDUser()
{
	// if the session id is not set, redirect to login page
	if (!isset($_SESSION['calendar_fd_user'])) {
		header('Location: ' . WEB_ROOT . 'login.php');
		exit;
	}
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();
	}
}

function doLogin()
{
	$name 	= $_POST['name'];
	$pwd 	= $_POST['pwd'];
	
	$errorMessage = '';
	
	//$sql 	= "SELECT * FROM tbl_frontdesk_users WHERE username = '$name' AND pwd = PASSWORD('$pwd')";
	$sql 	= "SELECT * FROM tbl_users WHERE name = '$name' AND pwd = '$pwd'";
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 1) {
		$row = dbFetchAssoc($result);
		$_SESSION['calendar_fd_user'] = $row;
		$_SESSION['calendar_fd_user_name'] = $row['username'];
		header('Location: index.php');
		exit();
	}
	else {
		$errorMessage = 'Invalid username / passsword. Please try again or contact to support.';
	}
	return $errorMessage;
}


/*
	Logout a user
*/
function doLogout()
{
	if (isset($_SESSION['calendar_fd_user'])) {
		unset($_SESSION['calendar_fd_user']);
		//session_unregister('hlbank_user');
	}
	header('Location: index.php');
	exit();
}

function getBookingRecords(){
	$per_page = 10;
	$id = $_SESSION['calendar_fd_user']['id']; 
	$type = $_SESSION['calendar_fd_user']['type']; 
	if($type=='student'){
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	$sql 	= "SELECT u.id AS ui , u.name, u.phone, u.email,r.uid,
			   r.ucount, r.rdate, r.status, r.comments   
			   FROM tbl_users u, tbl_reservations r 
			   WHERE u.id = r.ucount  AND r.ucount=$id
			   ORDER BY r.id DESC LIMIT $start, $per_page";
	//echo $sql;
			}
	else if($type=='parent'){
				$idson = $_SESSION['calendar_fd_user']['sonid']; 
$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	$sql 	= "SELECT u.id AS ui, u.name, u.phone, u.email,r.uid,
			   r.ucount, r.rdate, r.status, r.comments   
			   FROM tbl_users u, tbl_reservations r 
			   WHERE u.id = r.ucount  AND r.ucount=$idson
			   ORDER BY r.id DESC LIMIT $start, $per_page";
			}
			else if($type=='teacher')
			{
				$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	             $start 	= ($page-1)*$per_page;
          $sql 	= "SELECT u.id AS ui, u.name, u.phone, u.email,r.uid,
			   r.ucount, r.rdate, r.status, r.comments   
			   FROM tbl_users u, tbl_reservations r 
			   WHERE u.id = r.ucount  
			   ORDER BY r.id DESC LIMIT $start, $per_page";

			}
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("id" => $ui,
							"user_name" => $name,
							"user_phone" => $phone,
							"user_email" => $email,
							"id" => $ucount,
							"res_date" => $rdate,
							"status" => $status,
							"comments" => $uid);	
	}//while
	return $records;
}


function getUserRecords(){
	$per_page = 20;
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'student') {
		$id = $_SESSION['calendar_fd_user']['id'];
		$sql = "SELECT  * FROM tbl_users u WHERE type != 'admin' AND id = $id ORDER BY u.id DESC";
	}
	else if($type == 'parent')
	{
    $id = $_SESSION['calendar_fd_user']['id']; 
    $sonid=$_SESSION['calendar_fd_user']['sonid'];
     $sql = "SELECT  * FROM tbl_users u WHERE type != 'admin' AND id = $id OR id=$sonid ORDER BY u.id DESC";
	}
	else {
		$sql = "SELECT  * FROM tbl_users u WHERE type != 'admin' ORDER BY u.id DESC LIMIT $start, $per_page";
	}
	
	//echo $sql;
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("user_id" => $id,
			"user_name" => $name,
			"user_phone" => $phone,
			"user_email" => $email,
			"type" => $type,
			"status" => $status,
			"sonid" => $sonid,
			
		);	
	}
	return $records;
}
function gettotalstars(){
	$per_page = 20;
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'student') {
		$id = $_SESSION['calendar_fd_user']['id'];
		$sql = "SELECT  SUM(star) AS total_amount FROM message_table WHERE reid = $id; ";

	}
	
	//echo $sql;
	$result = dbQuery($sql);

	$records = array();

	while($row = dbFetchAssoc($result)) {
		extract($row);
		$totalAmount = $row['total_amount'];
			 
		

	}
	return $totalAmount;
}

function getUserVmessage(){
 
  // Database configuration
  $dbHost = '10.0.0.1:4308';
$dbUser = 'root';
$dbPass = '1234';
$dbName = 'recordings';

  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser,$dbPass);
  $id = $_SESSION['calendar_fd_user']['id'];
  // Fetch the recordings from the database
  $stmt = $pdo->query("SELECT * FROM registration where reid = $id");
  $recordings = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($recordings) > 0) {
 
   // echo '<ul>';
    $records = array();
    foreach ($recordings as $recording) {
      extract($recording);
    $records[] = array(
        "user_id" => $reid,
        "sender_name" => $sender,
        "type" => $type,
        "audio_data" => $audio_data
    );
     // echo '<audio controls>';
      //echo '<source src="data:audio/ogg;base64,' . base64_encode($recording['audio_data']) . '" type="audio/ogg">';
      //echo '</audio>';
      
    }
   // echo '</ul>';
 
return $records;
}
}
function getUsermessage(){
	$per_page = 20;
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'student') {
		$id = $_SESSION['calendar_fd_user']['id'];
		$sql = "SELECT  * FROM message_table WHERE reid = $id ";
	}
	
	//echo $sql;
	$result = dbQuery($sql);

	$records = array();

	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("user_id" => $reid,
			"sender_name" => $sender,
			"user_message" => $message,
			"type" => $type,
			"star"=>$star,
			 
		);

	}
	return $records;
}

function getHolidayRecords() {
	$per_page = 10;
	$page 	= (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	$sql 	= "SELECT * FROM tbl_holidays ORDER BY id DESC LIMIT $start, $per_page";
	//echo $sql;
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("hid" => $id, "hdate" => $date,"hreason" => $reason);	
	}//while
	return $records;
}

function generateHolidayPagination() {
	$per_page = 10;
	$sql 	= "SELECT * FROM tbl_holidays";
	$result = dbQuery($sql);
	$count 	= dbNumRows($result);
	$pages 	= ceil($count/$per_page);
	$pageno = '<ul class="pagination pagination-sm no-margin pull-right">';
	for($i=1; $i<=$pages; $i++)	{
		$pageno .= "<li><a href=\"?v=HOLY&page=$i\">".$i."</a></li>";
	}
	$pageno .= 	"</ul>";
	return $pageno;
}

function generatePagination(){
	$per_page = 10;
	$sql 	= "SELECT * FROM tbl_users";
	$result = dbQuery($sql);
	$count 	= dbNumRows($result);
	$pages 	= ceil($count/$per_page);
	$pageno = '<ul class="pagination pagination-sm no-margin pull-right">';
	for($i=1; $i<=$pages; $i++)	{
			$pageno .= "<li><a href=\"?v=USER&page=$i\">".$i."</a></li>";
	}
	$pageno .= 	"</ul>";
	return $pageno;
}

?>