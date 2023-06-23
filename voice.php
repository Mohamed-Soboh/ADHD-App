<!DOCTYPE html>
<html>
<head>
  <title>Voice Recorder</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h1>Voice Recorder</h1>
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
// Database configuration
$dbHost = '10.0.0.9:4308';
$dbUser = 'root';
$dbPass = '1234';
$dbName = 'recordings';
$audioData = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $audioData = $_FILES['audio']['tmp_name'];

  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser,$dbPass);
  
  // Prepare the INSERT query
  $stmt = $pdo->prepare("INSERT INTO registration (audio_data) VALUES (:audioData)");

  // Bind the audio data as a BLOB parameter
  $stmt->bindParam(':audioData', file_get_contents($audioData), PDO::PARAM_LOB);

  // Execute the query
  if ($stmt->execute()) {
    echo 'Recording saved successfully.';
  } else {
    echo 'Error saving recording.';
  }
}
?>

 