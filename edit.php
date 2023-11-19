<?php
include "./db.php";
// Edit database
if (isset($_POST["hidden"])) {
  $title = $_POST["editTitle"];
  $desc = $_POST["editDesc"];
  $id= $_POST["hidden"];
  $sql = "UPDATE `notes` SET `sno`='$id',`title`='$title',`description`='$desc'WHERE `sno`='$id'";
  $res = mysqli_query($con, $sql);
  header("Location: " . $_SERVER["PHP_SELF"]);
  exit();
}

echo '
<div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form method="POST">
            <input type="hidden" name="hidden" id="hidden">
                <div class="form-group">
                    <label for="editTitle">Title</label>
                    <input type="text" id="editTitle" name="editTitle" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editDesc">Description</label>
                    <textarea id="editDesc" name="editDesc" class="form-control"></textarea>
                </div>
                <input type="hidden" id="editId" name="editId">
                <button type="submit" name="editSubmit" class="btn editform">Save Changes</button>
            </form>
        </div>
    </div>
';
?>