<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/style.css">
    <title>New Task</title>
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
                                <p><a href="group_account.php">Account</a></p>
                                <p><a href="../../admin.php" id="admin">Admin</a></p>
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
                    <li><a href="group_all_tasks.php">All Tasks</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=onhold">On-hold</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=todo">TODO</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=inprogress">In Progress</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=resolved">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <div class="members-body">
                <div id="addtask-container">
                    <?php echo $this->displayAlert(); ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                        <input type="text" name="task-title" cols="100" id="task-title" placeholder="New Task Title" value="<?php echo $this->getData('input_title'); ?>">
                        <div class="error"><?php echo $this->getData('error_title'); ?></div><br>
                        <input type="text" name="task-author" id="task-author" value="<?php echo $_SESSION['user']; ?>" disabled>
                        <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                        <textarea type="text" name="task-description" id="task-description" form="task-form" placeholder="Description..."><?php echo $this->getData('input_description'); ?></textarea>
                        <div class="error"><?php echo $this->getData('error_description'); ?></div><br>
                        <input type="button" name="cancel" class="cancel cancel-form" value="Cancel">
                        <input type="submit" class="submit" value="Submit">
                    </form>
                </div><!-- .addtask-container -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/group_app.js"></script>
</body>
</html>