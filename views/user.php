

<?php 

$type= $_SESSION['calendar_fd_user']['type'];
require_once 'C:\xampp\htdocs\event-management\event-management\library\config.php';
$userId = (isset($_GET['ID']) && $_GET['ID'] != '') ? $_GET['ID'] : 0;
$usql	= "SELECT * FROM tbl_users u WHERE u.id = $userId";
$res 	= dbQuery($usql);
while($row = dbFetchAssoc($res)) {
	extract($row);
	$stat = '';
	
	if($status == "active") {$stat = 'success';}
	else if($status == "lock") {$stat = 'warning';}
	else if($status == "inactive") {$stat = 'warning';}
	else if($status == "delete") {$stat = 'danger';}
?>

<div class="col-md-9">
  <div class="box box-solid">
    <div class="box-header with-border"> 
      <h3 class="box-title">Add a Massage to the student, and improve his feeling!</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <dl class="dl-horizontal">
        <dt>Username</dt>
        <dd><?php echo $name; ?></dd>
        
	<?php
}
?>
		
        <br>
 
 
<html>
<head>
  <script>
    function printText() {
      var text = document.getElementById("myText").value;
    }
  </script>
</head>
<form method="post" action="">
<body>
    <dt>Write a message</dt>
    &nbsp;&nbsp;&nbsp;&nbsp;
  <input type="text" name ="myText"  id="myText" placeholder="Enter text...">
  <button onclick="printText()">Send!</button>
  <br>
  <dt>or</dt>
  <br>
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  
   
  
</form>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <dt> send a voice massage</dt> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <button id="startButton">Start Recording</button>
  <button id="stopButton" disabled>Stop Recording</button>
  <script>
    let mediaRecorder;
    let chunks = [];

    function startRecording() {
      navigator.mediaDevices.getUserMedia({ audio: true })
        .then(function(stream) {
          mediaRecorder = new MediaRecorder(stream);
          mediaRecorder.start();

          $('#startButton').attr('disabled', true);
          $('#stopButton').attr('disabled', false);

          mediaRecorder.addEventListener('dataavailable', function(e) {
            chunks.push(e.data);
          });
        })
        .catch(function(err) {
          console.log('Error: ' + err);
        });
    }

    function stopRecording() {
      mediaRecorder.stop();

      $('#startButton').attr('disabled', false);
      $('#stopButton').attr('disabled', true);

      mediaRecorder.addEventListener('stop', function() {
        const blob = new Blob(chunks, { type: 'audio/ogg' });
        chunks = [];

        const formData = new FormData();
        formData.append('audio', blob, 'recording.ogg');

        $.ajax({
          url: '',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function() {
            console.log('Recording saved successfully.');
          },
          error: function(err) {
            console.log('Error saving recording: ' + err);
          }
        });
      });
    }

    $(document).ready(function() {
      $('#startButton').on('click', startRecording);
      $('#stopButton').on('click', stopRecording);
    });
  </script>
</body>
</html>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['myText'])) {
    $text = $_POST['myText'];
    $idofuser= $_SESSION['calendar_fd_user']['sonid']; 
    $type= $_SESSION['calendar_fd_user']['type'];
    $name= $_SESSION['calendar_fd_user']['name'];

     $sql    = "INSERT INTO message_table (reid,sender, type, message)VALUES ($userId, '$name', '$type', '$text')";
     $result = dbQuery($sql);


}
else if(isset( $_FILES['audio']['tmp_name'])){
$dbHost = '10.0.0.9:4308';
$dbUser = 'root';
$dbPass = '1234';
$dbName = 'recordings';
$audioData = array();
$userId = (isset($_GET['ID']) && $_GET['ID'] != '') ? $_GET['ID'] : 0;
$idofuser= $_SESSION['calendar_fd_user']['sonid']; 
    $type= $_SESSION['calendar_fd_user']['type'];
    $name= $_SESSION['calendar_fd_user']['name'];
      $audioData = $_FILES['audio']['tmp_name'];
$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser,$dbPass);
  
  // Prepare the INSERT query
  $stmt = $pdo->prepare("INSERT INTO registration (audio_data,sender,type,reid) VALUES (:audioData,'$name', '$type',$userId)");

  // Bind the audio data as a BLOB parameter
  $stmt->bindParam(':audioData', file_get_contents($audioData), PDO::PARAM_LOB);
  $stmt->execute();
}
  }
  ?>
<?php
$idofuser= $_SESSION['calendar_fd_user']['sonid']; 
    $type= $_SESSION['calendar_fd_user']['type'];
    $name= $_SESSION['calendar_fd_user']['name'];


if(isset($_POST['myButton'])) {
    // Button was clicked
$sql    = "INSERT INTO message_table (reid,sender, type,star)VALUES ($userId, '$name', '$type',1)";
$result = dbQuery($sql);

} 
?>
  <body>
    <br>
    <br>
    <?php
      $type= $_SESSION['calendar_fd_user']['type'];
      if ($type == 'teacher')
      {
        ?>
  <h4 class="box-title">🌟You can also send him a star!🌟</h4>
  <br>
    <dt></dt> 
    <form method="post" action="">
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="myButton" value="send🌟">
      <br>
      <?php
      }
      ?>    
  </form>
    </body>
</body>
</html>
 
  
 
<?php

?>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
  
</div>
 