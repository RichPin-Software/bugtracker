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
                <tr>
                    <td id="header-label">myTasks</td>
                    <td id="header-icon">
                        <div class="header-dropdown dropdown">
                            <img src="../../images/list.svg" alt="">
                            <div class="dropdown-menu-header">
                                <div class="nav-dropdown">
                                    <p><a href="group_all_tasks.php?addtask=1">New Task</a></p>
                                    <p><a href="group_all_tasks.php?back=1">All Tasks</a></p>
                                    <p><a href="group_all_tasks.php?filtertasks=onhold">On-hold</a></p>
                                    <p><a href="group_all_tasks.php?filtertasks=todo">TODO</a></p>
                                    <p><a href="group_all_tasks.php?filtertasks=inprogress">In&nbspProgress</a></p>
                                    <p><a href="group_all_tasks.php?filtertasks=resolved">Resolved</a></p>
                                    <p><hr></p>
                                </div>
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
                    <li class="li-remove">
                        <a href="group_all_tasks.php?addtask=1">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/plus-square.svg" alt="new task"></td>
                                    <td>New Task</td>
                                </tr>
                            </table>
                        </a>
                    </li>
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
                            <table id="nav-last">
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
                    <td class="task-header">Change Password</td>
                    <td class="alert-banner"><?php echo $this->displayAlert(); ?></td>
                </tr>
            </table>
            <div class="members-body">
                <div id="admin-container">
                    <div class="form-container">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                            <label id="account-user-label" for="username">Username:</label><br>
                            <select id="username" name="username">
                                <option value="<?php echo $_SESSION['user']; ?>"><?php echo $_SESSION['user']; ?></option>
                            </select>
                            <br><br><br>
                            <label id="account-label-password" for="password">Password</label><br>
                            <input type="password" name="password" id="password" placeholder="Enter new password" value="<?php echo $this->getData('input_pass'); ?>">
                            <div class="error"><?php echo $this->getData('error_pass'); ?></div><br>
                            <label id="account-label-confirm" for="password_confirm">Confirm Password</label><br>
                            <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm new password" value="<?php echo $this->getData('input_pass_confirm'); ?>">
                            <div class="error"><?php echo $this->getData('error_pass_confirm'); ?></div><br>
                            <input type="button" name="cancel" class="cancel cancel-form-group" value="Cancel">
                            <input type="submit" class="submit" value="Submit">
                        </form>
                    </div><!-- .form-container -->
                </div><!-- .admin-container -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>