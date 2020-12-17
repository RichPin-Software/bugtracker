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
    <title>Task-<?php echo $_SESSION['id']; ?></title>
</head>
<body>
    <div class="container">
        <div class="row-header">
            <table id="header-table">
                <tr>
                    <td id="header-label">myTasks</td>
                    <td id="header-icon">
                        <div class="header-dropdown dropdown">
                            <img src="../../images/list.svg" alt="dropdown">
                            <div class="dropdown-menu-header">
                                <div class="nav-dropdown">
                                    <p><a href="all_tasks.php?addtask=1">New Task</a></p>
                                    <p><a href="all_tasks.php?back=1">All Tasks</a></p>
                                    <p><a href="all_tasks.php?filtertasks=onhold">On-hold</a></p>
                                    <p><a href="all_tasks.php?filtertasks=todo">TODO</a></p>
                                    <p><a href="all_tasks.php?filtertasks=inprogress">In&nbspProgress</a></p>
                                    <p><a href="all_tasks.php?filtertasks=resolved">Resolved</a></p>
                                    <p><hr></p>
                                </div>
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
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/plus-square.svg" alt="new task"></td>
                                    <td>New Task</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?back=1">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/asterisk.svg" alt="all tasks"></td>
                                    <td>All Tasks</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=onhold">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/x-octagon-fill.svg" alt="on-hold"></td>
                                    <td>On-hold</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=todo">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/card-checklist.svg" alt="to do"></td>
                                    <td>TODO</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=inprogress">
                            <table>
                                <tr>
                                    <td><img class="nav-img" src="../../images/hourglass-split.svg" alt="in progress"></td>
                                    <td>In Progress</td>
                                </tr>
                            </table>
                        </a>
                    </li>
                    <li>
                        <a href="all_tasks.php?filtertasks=resolved">
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
                    <td class="task-header">Task-<?php echo $_SESSION['id']; ?></td>
                    <td></td>
                </tr>
            </table>
            <div class="members-body">
                <table class="selected-task-layout">
                    <tr>
                        <td>
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
                                    <th colspan="2"><?php echo $result['title']; ?></th>
                                </tr>
                                <tr></tr><tr></tr><tr></tr><tr></tr>
                                <tr></tr><tr></tr><tr></tr><tr></tr>
                                <tr></tr><tr></tr><tr></tr><tr></tr>
                                <tr>
                                    <td colspan="2" id="description">
                                        <div><?php echo $result['description']; ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="edit-delete">
                                        <a id="edit-task" href="selected_task.php?edittask=true"><img src="../../images/pencil-square.svg" alt="edit"></a>
                                        <a id="delete-task" href="#"><img src="../../images/trash-fill.svg" alt="delete"></a>
                                    </td>
                                </tr>
                            </table><!-- #selected-task -->
                        </td>
                        <td>
                            <table id="selected-task-data-table">
                                <tr>
                                    <td id="author">
                                        <div class="td-content">
                                            <span class="task-suffix">Created by:</span><br>
                                            <span class="display-author"><?php echo $result['author']; ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="status">
                                        <div class="td-content dropdown">
                                            <span class="task-suffix">Status: </span><br>
                                            <div class="selected-task-data-dropdown-container">
                                                <span class="<?php echo "display-$sts"; ?>" id="dropdown-status"><?php echo $result['status']; ?></span>
                                                <img src="../../images/caret-down.svg" alt="dropdown">
                                            </div>
                                            <div id="dropdown-menu-status" class="dropdown-menu">
                                                <p><a href="selected_task.php?status=onhold" id="on-hold">On-hold</a></p>
                                                <p><a href="selected_task.php?status=todo" id="todo">TODO</a></p>
                                                <p><a href="selected_task.php?status=inprogress" id="in-progress">In&nbspProgress</a></p>
                                                <p><a href="selected_task.php?status=resolved" id="resolved">Resolved</a></p>
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
                        </td>
                    </tr>
                </table><!-- .selected-task-layout -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>