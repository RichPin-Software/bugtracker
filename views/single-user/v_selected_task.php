<?php 
$db_user_table = $_SESSION['user']; 
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
                                <p><a href="account.php">Account</a></p>
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
                        <a href="all_tasks.php?addtask=1">
                            <img class="nav-img" src="../../images/plus-square.svg" alt="new task"><span>New Task</span>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?back=1">
                            <img class="nav-img" src="../../images/asterisk.svg" alt="all tasks"><span>All Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=onhold">
                            <img class="nav-img"  src="../../images/x-octagon-fill.svg" alt="on-hold"><span>On-hold</span>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=todo">
                            <img class="nav-img"  src="../../images/card-checklist.svg" alt="todo"><span>TODO</span>    
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=inprogress">
                            <img class="nav-img"  src="../../images/hourglass-split.svg" alt="in progress"><span>In Progress</span>    
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=resolved">
                            <img class="nav-img"  src="../../images/check2-square.svg" alt="resolved"><span>Resolved</span>  
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <h3 class="task-header">BUG-<?php echo $_SESSION['id']; ?></h3>
            <div class="members-body">
                <table id="selected-task">
                <?php
                if ($stmt = $conn->prepare("SELECT * FROM $db_user_table WHERE id = ?")) // begin if statement
                {
                    $stmt->bind_param("i", $id);
                    $id = $_SESSION['id'];
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
                        <th rowspan="2"><?php echo $result['title']; ?></th>
                        <td id="author">
                            <div class="td-content">
                                <span class="task-suffix">Created by:</span> <?php echo $result['author']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td id="status">
                            <div class="td-content dropdown">
                                <span class="task-suffix">Status: </span> 
                                <span class="<?php echo "display-$sts"; ?>" id="dropdown-status"><?php echo $result['status']; ?></span>
                                <div class="dropdown-menu">
                                    <p><a href="selected_task.php?status=onhold" id="on-hold">On-hold</a></p>
                                    <p><a href="selected_task.php?status=todo" id="todo">TODO</a></p>
                                    <p><a href="selected_task.php?status=inprogress" id="in-progress">In Progress</a></p>
                                    <p><a href="selected_task.php?status=resolved" id="resolved">Resolved</a></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="description">
                            <div><?php echo $result['description']; ?></div>
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
                    <tr>
                        <td colspan="2" id="edit-delete">
                            <a id="edit-task" href="selected_task.php?edittask=true"><img src="../../images/pencil-square.svg" alt="edit"></a>
                            <a id="delete-task" href="#"><img src="../../images/trash-fill.svg" alt="delete"></a>
                        </td>
                    </tr>
                </table><!-- #selected-task -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>