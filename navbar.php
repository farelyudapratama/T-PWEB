<div class="navbar">
    <a class="name">
        My Notes Space
    </a>
    <div class="search">
        <div class="input__container">
            <input placeholder="Look for your notes" class="input" id="search" name="text" type="text" />
        </div>
    </div>
    <div class="username" id="userBtn">
        <?php
        $user_id = $_SESSION['user_id'];
        $user_query = "SELECT username FROM users WHERE id = '$user_id'";
        $user_result = mysqli_query($con, $user_query);

        $user_data = mysqli_fetch_assoc($user_result);
        $username = $user_data['username'];

        echo '
        <a href="#">' . $username . '</a>
        <div class="user-dropdown" id="userDropdown">
            <a href="logout.php">Logout</a>
            <a href="delete.php" class="userdelete">Delete Account</a>
        </div>
        ';
        ?>
    </div>
</div>
<script>
    document.getElementById('userBtn').addEventListener('click', function () {
        var dropdown = document.getElementById('userDropdown');
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        } else {
            dropdown.style.display = 'block';
        }
    });

    document.addEventListener('click', function (event) {
        var dropdown = document.getElementById('userDropdown');
        var loginBtn = document.getElementById('userBtn');
        if (event.target !== loginBtn && !loginBtn.contains(event.target) && event.target !== dropdown && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>