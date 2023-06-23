<!DOCTYPE html>
<html>
<head>
  <title>Voice Recorder</title>
</head>
<body>
  <h1>Voice Recorder</h1>

  <!-- Display the list of recordings -->
  <?php
  // Database configuration
  $dbHost = '10.0.0.1:4308';
$dbUser = 'root';
$dbPass = '1234';
$dbName = 'recordings';

  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser,$dbPass);

  // Fetch the recordings from the database
  $stmt = $pdo->query("SELECT * FROM registration");
  $recordings = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($recordings) > 0) {
    echo '<ul>';
    foreach ($recordings as $recording) {
      echo '<li>';
      echo '<audio controls>';
      echo '<source src="data:audio/ogg;base64,' . base64_encode($recording['audio_data']) . '" type="audio/ogg">';
      echo '</audio>';
      echo '</li>';
    }
    echo '</ul>';
  } else {
    echo 'No recordings found.';
  }
  ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
