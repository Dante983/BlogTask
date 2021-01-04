<?php if (isset($_SESSION['user']['username'])) { ?>
    <div class="logged_in_info">
        <span>welcome <?php echo $_SESSION['user']['username'] ?></span>
        |
        <span><a href="logout.php">logout</a></span>
    </div>
<?php }else{ ?>
    <div class="banner">
        <div class="welcome_msg">
            <h1>Today's Inspiration</h1>
            <p>
                Nobody exists on purpose. <br>
                Nobody belongs anywhere. <br>
                We’re all going to die. <br>
                <span>~ Morty</span>
            </p>
        </div>

        <div class="login_div" style="width: 150px; padding-top: 230px; padding-left: 300px">
            <a href="register.php" class="btn">Join us!</a>
            <a href="login.php" class="btn">Log in!</a>
        </div>
    </div>
<?php } ?>