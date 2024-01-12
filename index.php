<?php
session_start(); //memulai sesi

include "./db.php";  // import koneksi database di db.php
include "./edit.php"; // import edit.php

if (!isset($_SESSION['user_id'])) { // Jika session tidak ada user_id maka dilempar ke login.php
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) { // meriksa kalo ini requestnya POST dan memastikan kalau elemen itu memiliki submit
    // Pengambilan data dari formulir
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $userId = $_SESSION['user_id'];

    // Query untuk menambahkan catatan baru ke database
    $sql = "INSERT INTO `notes` (`user_id`, `title`, `description`) VALUES ('$userId', '$title', '$desc')";
    $res = mysqli_query($con, $sql);

    // Kembali ke halaman saat ini setelah menambahkan catatan baru
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App</title>
    <link rel="icon" type="image/png" href="image/favicon.png" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include "./navbar.php";
    ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <form class="form" method="POST">
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title ...">
                    </div>
                    <div class="form-group">
                        <label for="desc" class="form-label">Description</label><br>
                        <textarea id="desc" name="desc" class="form-control"
                            placeholder="Enter Description ..."></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn submit">Add Note</button>
                </form>
            </div>
        </div>
    </div>

    <div class="display">
        <h1>Your Notes</h1>
        <div class="cardContainer" id="cardContainer">
            <?php
            $userId = $_SESSION['user_id']; // ambil user id
            $sql = "SELECT * FROM `notes` WHERE `user_id` = '$userId'"; //cari notes(catatan) berdasarkan userId
            $res = mysqli_query($con, $sql);
            $noNotes = true; // Bikin variabel noNotes true agar jika tidak ada notes(catatan) maka dia bernilai true

            // Loop untuk menampilkan setiap catatan
            while ($fetch = mysqli_fetch_assoc($res)) {
                $noNotes = false; // Jika ada catatan maka dia akan menjadi false dan mmenampilkan semua  catatan
                echo '
                <div class="cardBody">
                    <h5>' . htmlspecialchars($fetch["title"]) . '</h5>
                    <p>' . htmlspecialchars($fetch["description"]) . '</p>
                    <button type="button" class="btn edit" onclick="openModal()" id=' . $fetch["sno"] . '>Edit</button>
                    <a href="./deleteNote.php?id=' . $fetch["sno"] . '" class="btn delete">Delete</a>
                </div>';
            }

            if ($noNotes) { // Jika tidak ada catatan maka akan membuat ini
                echo '
                <div class="cardBody">
                    <h5>No notes here, create your notes now</h5>
                </div>';
            }

            echo '</div></div>';
            ?>
        </div>
    </div>

    <script>
        const edit = document.querySelectorAll(".edit");
        const editTitle = document.getElementById("editTitle");
        const editDesc = document.getElementById("editDesc");
        const hiddenInput = document.getElementById("hidden");
        const cardBody = document.querySelectorAll(".cardBody");

        edit.forEach(element => {
            element.addEventListener("click", () => {
                const titleText = element.parentElement.children[0].innerText
                const descText = element.parentElement.children[1].innerText
                editTitle.value = titleText
                editDesc.value = descText
                hiddenInput.value = element.id
            })
        })

        function openModal() {
            document.getElementById("editModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        window.onclick = function (event) {
            var modal = document.getElementById("editModal");
            if (event.target == modal) {
                closeModal();
            }
        };
        function searchNotes() {
            var searchText = document.getElementById("search").value;
            window.location.href = "search.php?query=" + searchText;
        }

        document.getElementById('search').addEventListener('input', function () {
            var searchTerm = this.value.toLowerCase();
            var cardBodies = document.querySelectorAll('.cardBody');

            cardBodies.forEach(function (cardBody) {
                var title = cardBody.querySelector('h5').innerText.toLowerCase();
                var description = cardBody.querySelector('p').innerText.toLowerCase();

                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    cardBody.style.display = 'block';
                } else {
                    cardBody.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>