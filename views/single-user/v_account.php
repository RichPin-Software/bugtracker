<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/style.css">
    <title>Account</title>
</head>
<body>
    <div class="container">
        <div class="row-header">
            <table id="header-table">
                <tr></tr>
                <tr>
                    <td id="header-label">Bug Tracker</td>
                    <td id="header-icon">
                        <div class="header-dropdown dropdown">
                            <img src="../../images/list.svg" alt="">
                            <div class="dropdown-menu-header">
                                <p><a id="logout" href="../../logout.php">Logout</a></p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row-nav">
            <div class="nav">
                <ul>
                    <li><a href="all_tasks.php">All Tasks</a></li>
                    <li><a href="all_tasks.php?filtertasks=onhold">On-hold</a></li>
                    <li><a href="all_tasks.php?filtertasks=todo">TODO</a></li>
                    <li><a href="all_tasks.php?filtertasks=inprogress">In Progress</a></li>
                    <li><a href="all_tasks.php?filtertasks=resolved">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <h3 class="task-header">Change Password</h3>
            <div class="members-body">
                <?php echo $this->displayAlert(); ?>
                <div id="admin-container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                        <label id="account-user-label" for="username">Username: </label>
                        <select id="username" name="username">
                            <option value="<?php echo $_SESSION['user']; ?>"><?php echo $_SESSION['user']; ?></option>
                        </select>
                        <br><br>
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter new password" value="<?php echo $this->getData('input_pass'); ?>">
                        <div class="error"><?php echo $this->getData('error_pass'); ?></div><br>
                        <label for="password_confirm">Confirm Password</label>
                        <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm new password" value="<?php echo $this->getData('input_pass_confirm'); ?>">
                        <div class="error"><?php echo $this->getData('error_pass_confirm'); ?></div><br>
                        <input type="button" name="cancel" class="cancel cancel-form" value="Cancel">
                        <input type="submit" class="submit" value="Submit">
                    </form>
                </div><!-- .admin-container -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>