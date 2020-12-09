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
                    <td id="header-label"><span>myTasks</span></td>
                    <td id="header-icon">
                        <div class="header-dropdown dropdown">
                            <img src="../../images/list.svg" alt="">
                            <div class="dropdown-menu-header">
                                <p><a href="group_account.php">Account</a></p>
                                <p><a href="admin.php" id="admin">Admin</a></p>
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
                    <li>
                        <a href="group_all_tasks.php?back=1">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/asterisk.svg" alt="all tasks"></td>
                                    <td>All Tasks</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=onhold">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/x-octagon-fill.svg" alt="on-hold"></td>
                                    <td>On-hold</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=todo">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/card-checklist.svg" alt="to do"></td>
                                    <td>TODO</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=inprogress">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/hourglass-split.svg" alt="in progress"></td>
                                    <td>In Progress</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=resolved">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/check2-square.svg" alt="resolved"></td>
                                    <td>Resolved</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <table class="row-body-header-table">
                <tr>
                    <td class="task-header">New Task</td>
                    <td></td>
                </tr>
            </table>
            <div class="members-body">
                <div id="addtask-container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                        <input type="text" name="task-title" cols="100" id="task-title" placeholder="New Task Title" value="<?php echo $this->getData('input_title'); ?>">
                        <div class="error"><?php echo $this->getData('error_title'); ?></div><br>
                        <input type="text" name="task-author" id="task-author" value="<?php echo $_SESSION['user']; ?>" disabled>
                        <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                        <textarea type="text" name="task-description" id="task-description" form="task-form" placeholder="Description..."><?php echo $this->getData('input_description'); ?></textarea>
                        <div class="error"><?php echo $this->getData('error_description'); ?></div><br>
                        <input type="button" name="cancel" class="cancel cancel-form-group" value="Cancel">
                        <input type="submit" class="submit" value="Submit">
                    </form>
                </div><!-- .addtask-container -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>