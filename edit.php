<?php
include "./db.php"; // import file db.php
// Edit database
if (isset($_POST["hidden"])) { // Jika formulir ini dikirimkan, maka isi formulir tersebut akan disimpan dalam variabel $_POST.
  // Mengambil nilai dari input formulir edit
  $title = $_POST["editTitle"];
  $desc = $_POST["editDesc"];
  $id= $_POST["hidden"];

  // Membuat query SQL untuk melakukan UPDATE pada tabel 'notes' berdasarkan id ('sno')
  $sql = "UPDATE `notes` SET `sno`='$id',`title`='$title',`description`='$desc'WHERE `sno`='$id'";
  $res = mysqli_query($con, $sql);//mengirimkan perintah SQL ke server database dan mengembalikan hasilnya.
  
  //Setelah perintah SQL berhasil dieksekusi, kode ini mengalihkan browser ke halaman saat ini untuk memastikan data baru tampil.
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