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
    <title>All Tasks</title>
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
                                <p><a id="account" href="account.php">Account</a></p>
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
            <h3 class="task-header">All Tasks</h3>
            <div class="members-body">
                <div class="alert-banner"><?php echo $this->displayAlert(); ?></div>
                <table id="tasks">
                <?php
                $offset = 0;
                $results = 5;

                if(isset($_SESSION['offset'])) { $offset = $_SESSION['offset']; }

                if ($stmt = $conn->prepare("SELECT id, title, status FROM $db_user_table ORDER BY id"))
                {
                    $stmt->execute();
                    $stmt->store_result();

                    //store number of rows in num_tasks to display total results
                    $num_tasks = $stmt->num_rows;
                    $count = ceil($num_tasks/8);
                    $stmt->free_result();
                    $stmt->close();

                    if ($stmt = $conn->prepare("SELECT id, title, status FROM $db_user_table ORDER BY id LIMIT ?, ?"))
                    {
                        $stmt->bind_param("ii", $offset, $results);
                        $stmt->execute(); 
                        $stmt->store_result();
                        $stmt->bind_result($id, $title, $status);

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
                                                        <a href='selected_task.php?id=$id'>BUG-$id: $title</a>
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
                    for($i=1;$i<=$count;$i++)
                    {
                        echo "<a class='page-link' href='all_tasks.php?page=$i'>$i</a>";
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