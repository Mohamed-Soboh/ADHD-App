<?php
require_once 'C:\xampp\htdocs\event_management\event-management\library\config.php';

// Core (class)
class Notes {

    private $pdo;
    public static $idofuser;
 
    function __construct() {
        $idofuser= $_SESSION['calendar_fd_user']['id']; 

    }

    public function fetchNotes($id = null ) {
         $idofuser= $_SESSION['calendar_fd_user']['id']; 
            $sql    = "SELECT title, content FROM notes WHERE ids = $idofuser";
            $result = dbQuery($sql);
            //$dbConn=getdbConn();
           // $stmt = $dbConn->prepare("SELECT title, content FROM notes WHERE ids = $idofuser");
            //$stmt->bindParam(':ID', $idofuser);
            //$stmt->execute();
            //$resultSet = $stmt->get_result();
            //$result = $resultSet->fetch(MYSQLI_ASSOC);
            while($row = mysqli_fetch_assoc($result)) {
           
                $title = $row['title'];
                echo "\n<br>";
                echo '<td>'. $row['content'] . '</td>';
                
            }
        } 

    public function create($title, $content) {
         $idofuser= $_SESSION['calendar_fd_user']['id']; 
        $datetime = date('Y-m-d H:i:s');
         $sql    = "INSERT INTO notes (ids,title, content, created)VALUES ($idofuser, '$title', '$content', NOW())";
        $result = dbQuery($sql);
        //$stmt = $dbConn->prepare('INSERT INTO notes (ids,title, content, created) VALUES (:ids,:title, :content, :created)');
        
    }

    public function delete($id) {
        if ($id == 'all') {
            $this->pdo->query('DELETE FROM notes; VACUUM');
        } else {
            $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = :ID');
            $stmt->bindParam(':ID', $id);
            $stmt->execute();
        }
    }

    public function edit($id, $title, $content) {
        $stmt = $this->pdo->prepare('UPDATE notes SET title = :title, content = :content WHERE id = :ID');
        $stmt->bindParam(':ID', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
    }
}

// Init core (class)
$notes = new Notes;

// Actions
if (isset($_POST['new'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $notes->create($title, $content);
    header('Location: .');
    exit();
}
if (isset($_POST['edit'])) {
    $idofuser= $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $notes->edit($idofuser, $title, $content);
    header('Location: .');
    exit();
}
if (!empty($_GET['del'])) {
    $idofuser = $_GET['del'];
    $notes->delete($idofuser);
    header('Location: .');
    exit();
}
if (!empty($_GET['dl'])) {
    $id = $_GET['dl'];
    $notes->fetchNotes($idofuser);
    exit();
}

?>
<!DOCTYPE html>
<html>


<body>
    <div class="col-md-12">
        <div class="page-header">
            <h2> Send a new note </h2>
        </div>
        <form role="form" action="note.php" method="POST">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Title" name="title" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="5" placeholder="What do you have in mind?" name="content" autofocus required></textarea>
            </div>
            <div class="btn-group float-right">
                <button class="btn btn-danger" type="reset"><span class="fa fa-times mr-2"></span>Clear</button>
                <button class="btn btn-success" name="new" type="submit"><span class="fa fa-paper-plane mr-2"></span>Send</button>
            </div>
        </form>
    </div>

    <?php
    $notes->__construct();
    if (!empty($notes->fetchNotes())):
        $notes = $notes->fetchNotes();
    ?>

    <div class="container mt-5" id="notes">
        <div class="page-header">
            <h2>Previously sent</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-right">Time</th>
                            <th class="text-right">Date</th>
                            <th class="text-right">Actions<br></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
<?php foreach ($notes as $row): ?>
                            <td>
                                <?= htmlspecialchars(substr($row['title'], 0, 15), ENT_QUOTES, 'UTF-8') ?>
                            </td>
                            <td class="text-right"><?= date('H:i', strtotime($row['created'])) ?></td>
                            <td class="text-right"><?= date('d/m/Y', strtotime($row['created'])) ?></td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary btn-sm" title="Edit this note" data-toggle="modal" data-target="#edit<?= $row['ID'] ?>"><span class="fa fa-edit"></span></button>
                                    <a class="btn btn-danger btn-sm" title="Delete this note" onclick="deleteNote(<?= $row['ID'] ?>)"><span class="fa fa-trash-alt"></span></a>
                                    <a class="btn btn-info btn-sm" title="Download this note" href="?dl=<?= $row['ID'] ?>" target="_blank"><span class="fa fa-download"></span></a>
                                </div>
                                <div class="modal fade" id="edit<?= $row['ID'] ?>" tabindex="-1" aria-labelledby="edit<?= $row['ID'] ?>" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit note</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" method="POST" id="edit-form-<?= $row['ID'] ?>">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Title" name="title" value="<?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="5" placeholder="What do you have in mind?" name="content" required><?= htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                                                    <input type="hidden" name="edit" value="1">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group pull-right">
                                                    <button class="btn btn-success" name="edit" type="submit" form="edit-form-<?= $row['ID'] ?>">
                                                        <span class="fa fa-save mr-2"></span>
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
            </table>
        </div>
<?php endif; ?>
    </div>

    <script type="text/javascript">
        function deleteNote(id) {
            if (confirm('Are you sure you want to delete this note?')) {
                window.location = '?del=' + id;
            }
        }
    </script>
</body>
</html>