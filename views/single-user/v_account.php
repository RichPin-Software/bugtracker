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
            <div class="members-body">
                <?php echo $this->displayAlert(); ?>
                <div id="admin-container">
                    <h2>Change Password</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                        <label for="username">Username: </label><br>
                        <select id="username" name="username">
                            <option value="<?php echo $_SESSION['user']; ?>"><?php echo $_SESSION['user']; ?></option>
                        </select>
                        <br><br>
                        <label for="password">New Password</label>
                        <input type="text" name="password" id="password" placeholder="Enter new password" value="<?php echo $this->getData('input_user'); ?>">
                        <div class="error"><?php echo $this->getData('error_pass'); ?></div><br>
                        <button class="cancel"><a href="all_tasks.php">Cancel</a></button>
                        <input type="submit" class="submit" value="Submit">
                    </form>
                </div><!-- .admin-container -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/group_app.js"></script>
</body>
</html>