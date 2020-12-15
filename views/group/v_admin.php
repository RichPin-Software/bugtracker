<?php
include('../../includes/database.php');

$groupname;
$admin = $_SESSION['user'];

if($stmt = $conn->prepare("SELECT groupname FROM users_login WHERE username=?"))
{
    $stmt->bind_param("s", $admin);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($result);
    
    if($stmt->num_rows > 0)
    {
        while($stmt->fetch())
        {
            $groupname = $result;
        }
        $stmt->free_result();
        $stmt->close();
        $conn->close();
    }
    else
    {
        $groupname = "not found";
    }
}
else
{
    die("Error: could not prepare MySQLi statement::groupname");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/style.css">
    <title>Admin</title>
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
                                <p><a href="group_account.php">Account</a></p>
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
                    <td class="task-header">Add New Member</td>
                    <td class="alert-banner"><?php echo $this->displayAlert(); ?></td>
                </tr>
            </table>
            <div class="members-body">
                <div id="admin-container">
                    <div class="form-container">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                            <label id="admin-label-groupname" for="username">Group: </label>
                            <select id="group-name" name="group-name">
                                <option value="<?php echo $groupname; ?>"><?php echo $groupname; ?></option>
                            </select>
                            <br><br>
                            <label id="admin-label-username" for="username">Username:</label><br>
                            <input type="text" name="add-user" id="add-user" placeholder="example: abcd1234" value="<?php echo $this->getData('input_add-user'); ?>">
                            <div class="error"><?php echo $this->getData('error_add-user'); ?></div><br>
                            <label id="admin-label-email" for="email">Email:</label><br>
                            <input type="email" name="add-email" id="add-email" placeholder="example: abcd1234@email.com" value="<?php echo $this->getData('input_add-email'); ?>">
                            <div class="error"><?php echo $this->getData('error_add-email'); ?></div><br>
                            <label id="admin-label-password" for="password">Default Password:</label><br>
                            <input type="text" name="password" id="default-password" value="<?php echo $groupname; ?>" disabled><br>
                            <p>*change default password on first login!</p><br>
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