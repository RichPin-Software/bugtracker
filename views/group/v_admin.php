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
                <tr></tr>
                <tr>
                    <td id="header-label">Bug Tracker</td>
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
                    <li>
                        <a href="group_all_tasks.php?addtask=1">
                            <img class="nav-img" src="../../images/plus-square.svg" alt="new task"><span>New Task</span>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?back=1">
                            <img class="nav-img" src="../../images/asterisk.svg" alt="all tasks"><span>All Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=onhold">
                            <img class="nav-img"  src="../../images/x-octagon-fill.svg" alt="on-hold"><span>On-hold</span>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=todo">
                            <img class="nav-img"  src="../../images/card-checklist.svg" alt="todo"><span>TODO</span>    
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=inprogress">
                            <img class="nav-img"  src="../../images/hourglass-split.svg" alt="in progress"><span>In Progress</span>    
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?filtertasks=resolved">
                            <img class="nav-img"  src="../../images/check2-square.svg" alt="resolved"><span>Resolved</span>  
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <h3 class="task-header">Add New Member</h3>
            <div class="members-body">
                <?php echo $this->displayAlert(); ?>
                <div id="admin-container">
                    <div class="form-container">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                            <label id="admin-label-groupname" for="username">Group: </label>
                            <select id="group-name" name="group-name">
                                <option value="<?php echo $groupname; ?>"><?php echo $groupname; ?></option>
                            </select>
                            <br><br><br>
                            <label id="admin-label-username" for="username">Create Username:</label><br>
                            <input type="text" name="add-user" id="add-user" placeholder="Add User (example: abc123)" value="<?php echo $this->getData('input_add-user'); ?>">
                            <div class="error"><?php echo $this->getData('error_add-user'); ?></div><br>
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