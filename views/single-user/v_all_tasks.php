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
                    <td class="task-header">All Tasks</td>
                    <td class="alert-banner"><?php echo $this->displayAlert(); ?></td>
                </tr>
            </table>
            <div class="members-body">
                <table id="tasks">
                <?php
                $offset = 0;
                $results = 6;
                $_SESSION['results'] = $results;

                if(isset($_SESSION['offset'])) { $offset = $_SESSION['offset']; }

                if ($stmt = $conn->prepare("SELECT id, title, status FROM $db_user_table ORDER BY id"))
                {
                    $stmt->execute();
                    $stmt->store_result();

                    //store number of rows in num_tasks to display total results
                    $num_tasks = $stmt->num_rows;
                    $count = ceil($num_tasks/$results);
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
                                                        <a href='selected_task.php?id=$id'>Task-$id: $title</a>
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
                    <span><?php echo "$num_tasks results. Showing $results results per page."; ?></span>
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