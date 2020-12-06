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
    <title><?php echo $_SESSION['filtertasks']; ?></title>
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
                        <a href="group_all_tasks.php?addtask=1">
                            <img class="nav-img" src="../../images/plus-square.svg" alt="new task"><span>New Task</span>
                        </a>
                    </li>
                    <li>
                        <a href="group_all_tasks.php?back=1">
                            <img class="nav-img" src="../../images/asterisk.svg" alt="all tasks"><span>All Tasks</span>
                        </a>
                    </li>
                    <li id="li-onhold">
                        <a href="group_all_tasks.php?filtertasks=onhold">
                            <img class="nav-img"  src="../../images/x-octagon-fill.svg" alt="on-hold"><span>On-hold</span>
                        </a>
                    </li>
                    <li id="li-todo">
                        <a href="group_all_tasks.php?filtertasks=todo">
                            <img class="nav-img"  src="../../images/card-checklist.svg" alt="todo"><span>TODO</span>    
                        </a>
                    </li>
                    <li id="li-inprogress">
                        <a href="group_all_tasks.php?filtertasks=inprogress">
                            <img class="nav-img"  src="../../images/hourglass-split.svg" alt="in progress"><span>In Progress</span>    
                        </a>
                    </li>
                    <li id="li-resolved">
                        <a href="group_all_tasks.php?filtertasks=resolved">
                            <img class="nav-img"  src="../../images/check2-square.svg" alt="resolved"><span>Resolved</span>  
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <h3 class="task-header"><?php echo $_SESSION['filtertasks']; ?></h3>
            <div class="members-body">
                <?php echo $this->displayAlert(); ?>
                <table id="tasks">
                <?php
                $offset = 0;
                $results = 5;
                $status = $_SESSION['filtertasks'];

                if(isset($_SESSION['offset'])) { $offset = $_SESSION['offset']; }

                if ($stmt = $conn->prepare("SELECT id, title FROM $db_user_table WHERE status=? ORDER BY id"))
                {
                    $stmt->bind_param("s", $status);
                    $stmt->execute();
                    $stmt->store_result();

                    // store number of rows in num_tasks to display total results
                    $num_tasks = $stmt->num_rows;
                    $count = ceil($num_tasks/8);

                    $stmt->free_result();
                    $stmt->close();

                    if ($stmt = $conn->prepare("SELECT id, title FROM $db_user_table WHERE status=? ORDER BY id LIMIT ?,?"))
                    {
                        $stmt->bind_param("sii", $status, $offset, $results);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($id, $title);

                        if ($stmt->num_rows > 0)
                        {
                            while($stmt->fetch()) 
                            {
                                // set class name for CSS
                                switch($status)
                                {
                                    case 'On-hold':
                                        $class = 'onhold';
                                        break;
                                    case 'TODO':
                                        $class = 'todo';
                                        break;
                                    case 'In Progress':
                                        $class = 'inprogress';
                                        break;
                                    case 'Resolved':
                                        $class = 'resolved';
                                        break;
                                    default: 
                                        $class = 'todo';
                                }
                                $bug_display = "<tr>
                                                    <td>
                                                        <a href='group_selected_task.php?id=$id'>BUG-$id: $title</a>
                                                        <span class='display-$class'>$status</span>
                                                    </td>
                                                </tr>";

                                echo $bug_display;
                            }
                            $stmt->free_result();
                            $stmt->close();
                            $conn->close();
                        }
                        else
                        {
                            echo "<tr><td>No Data Available</td></tr>";
                        }
                    }
                    if(isset($_SESSION['offset'])) { unset($_SESSION['offset']); }
                }
                else
                {
                    echo "<tr><td>Failure to connect: ($conn->errno) $conn->error</td></tr>";
                }
                ?>
                </table><!-- #tasks -->
                <div class="results">
                    <span><?php echo "$num_tasks results. Showing 8 results per page."; ?></span>
                    <?php
                    // set value for query string
                    switch($status)
                    {
                        case 'On-hold': 
                            $status = 'onhold';
                            break;

                        case 'TODO': 
                            $status = 'todo';
                            break;

                        case 'In Progress': 
                            $status = 'inprogress';
                            break;

                        case 'Resolved': 
                            $status = 'resolved';
                            break;

                        default: 
                            $status = 'todo';
                    }

                    for($i=1;$i<=$count;$i++)
                    {
                        echo "<a class='page-link' href='group_all_tasks.php?page=$i&filtertasks=$status'>$i</a>";
                    }
                    ?>
                </div><!-- .results -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>