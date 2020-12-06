<?php 
$db_user_table = $_SESSION['group_table'];
include('../../includes/database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/style.css">
    <title>BUG-<?php echo $_SESSION['id']; ?></title>
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
                            <img src="../../images/list.svg" alt="dropdown">
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
        <div class="row-nav" id="row-nav-selected-task">
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
        <div class="row-body" id="selected-task-row-body-container">
            <h3 class="task-header" id="selected-task-task-header">BUG-<?php echo $_SESSION['id']; ?></h3>
            <div class="members-body" id="selected-task-members-body-container">
                <div class="selected-task-container">
                    <table id="selected-task">
                        <?php
                        if ($stmt = $conn->prepare("SELECT * FROM $db_user_table WHERE id = ?")) // begin if statement
                        {
                            $id = $_SESSION['id'];
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result(
                                $result['id'], 
                                $result['title'], 
                                $result['author'], 
                                $result['assignee'], 
                                $result['status'], 
                                $result['description']
                            );

                            if ($stmt->num_rows > 0)
                            {
                                $stmt->fetch();
                                // set class name for CSS
                                switch($result['status'])
                                {
                                    case 'On-hold':
                                        $sts = 'onhold';
                                        break;
                                    case 'TODO':
                                        $sts = 'todo';
                                        break;
                                    case 'In Progress':
                                        $sts = 'inprogress';
                                        break;
                                    case 'Resolved':
                                        $sts = 'resolved';
                                        break;
                                    default: 
                                        $sts = 'todo';
                                }
                        ?>
                        <tr>
                            <th><div class="title"><?php echo $result['title']; ?></div></th>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><td colspan="2" id="description"><div><?php echo $result['description']; ?></div></td></tr>
                        <tr>
                            <td colspan="2" id="edit-delete">
                                <a id="edit-task" href="group_selected_task.php?edittask=true"><img src="../../images/pencil-square.svg" alt="edit"></a>
                                <a id="delete-task-group" href="#"><img src="../../images/trash-fill.svg" alt="delete"></a>
                            </td>
                        </tr>
                    </table>
                </div><!-- .selected-task-container -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
        <div class="row2-body">
            <table id="selected-task-data-table">
                <tr>
                    <td id="author">
                        <div class="td-content">
                            <span class="task-suffix">Created by: </span><br><?php echo $result['author']; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="assignee">
                        <div class="td-content dropdown">
                            <span class="task-suffix">Assigned to:</span><br>
                            <span class="display-assignee" id="assignee-dropdown-sts"><?php echo $result['assignee']; ?></span>
                            <div class="dropdown-menu" id="dropdown-menu-assignee">
                        <?php
                        // Assignee dropdown
                        $groupname = '';
                        
                        if($stmt = $conn->prepare("SELECT groupname FROM users_login WHERE username = ?"))
                        {
                            $username = $_SESSION['user'];
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($group_name);

                            if ($stmt->num_rows > 0)
                            {
                                while($stmt->fetch()) 
                                {
                                    $groupname = $group_name;
                                }

                                $stmt->free_result();
                            }
                            else
                            {
                                die("Error: No Group");
                            }
                        }
                        else
                        {
                            die("Failure to connect: ($conn->errno) $conn->error");
                        }

                        if($groupname != '' || $groupname != null)
                        {
                            if ($stmt = $conn->prepare("SELECT username FROM users_login WHERE groupname = ?"))
                            {
                                $stmt->bind_param("s", $groupname);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($username);
    
                                if ($stmt->num_rows > 0)
                                {
                                    while($stmt->fetch()) 
                                    {
                                        echo "<p><a class='assignee' href='group_selected_task.php?assign=$username'>$username</a></p>";
                                    }

                                    $stmt->free_result();
                                }
                                else
                                {
                                    die("Error: No Users");
                                }
                            }
                            else
                            {
                                die("Failure to connect: ($conn->errno) $conn->error");
                            }
                        }
                        else
                        {
                            echo "<p><a href='#'>".$_SESSION['user']."</a></p>";
                        }  
                        ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="status">
                        <div class="td-content dropdown">
                            <span class="task-suffix">Status: </span><br>
                            <span class="<?php echo "display-$sts"; ?>" id="dropdown-status"><?php echo $result['status']; ?></span>
                            <div id="dropdown-menu-status" class="dropdown-menu">
                                <p><a href="group_selected_task.php?status=onhold" id="on-hold">On-hold</a></p>
                                <p><a href="group_selected_task.php?status=todo" id="todo">TODO</a></p>
                                <p><a href="group_selected_task.php?status=inprogress" id="in-progress">In Progress</a></p>
                                <p><a href="group_selected_task.php?status=resolved" id="resolved">Resolved</a></p>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                        $stmt->close();
                        $conn->close();
                    }
                    else
                    {
                        echo "<tr><th>No Data Available</th></tr>";
                    }
                } // end if statement
                else
                {
                    echo "<tr><th>Failure to connect: ($conn->errno) $conn->error</th></tr>";
                }
                ?>
            </table><!-- #selected-task-data-table -->
        </div><!--.row2-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>