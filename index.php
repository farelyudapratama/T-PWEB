<?php
session_start();

include "./db.php";
include "./edit.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $userId = $_SESSION['user_id'];

    $sql = "INSERT INTO `notes` (`user_id`, `title`, `description`) VALUES ('$userId', '$title', '$desc')";
    $res = mysqli_query($con, $sql);

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
                        <label for="desc" class="form-label">Description</label>
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
            $userId = $_SESSION['user_id'];
            $sql = "SELECT * FROM `notes` WHERE `user_id` = '$userId'";
            $res = mysqli_query($con, $sql);
            $noNotes = true;

            while ($fetch = mysqli_fetch_assoc($res)) {
                $noNotes = false;
                echo '
                <div class="cardBody">
                    <h5>' . $fetch["title"] . '</h5>
                    <p>' . $fetch["description"] . '</p>
                    <button type="button" class="btn edit" onclick="openModal()" id=' . $fetch["sno"] . '>Edit</button>
                    <a href="./delete.php?id=' . $fetch["sno"] . '" class="btn delete">Delete</a>
                </div>';
            }

            if ($noNotes) {
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
        // You can customize this URL based on your search implementation
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