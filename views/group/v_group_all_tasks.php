<?php
include('../../includes/database.php');
$db_user_table = $_SESSION['group_table']; 
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
                    <li><a href="group_all_tasks.php?addtask=1">[+] New Task</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=onhold">On-hold</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=todo">TODO</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=inprogress">In Progress</a></li>
                    <li><a href="group_all_tasks.php?filtertasks=resolved">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <div class="members-body">
                <?php echo $this->displayAlert(); ?>
                <table id="tasks">
                    <?php
                    $offset = 0;
                    $results = 8;
                    $count;
                    $num_tasks;

                    if(isset($_SESSION['offset'])) { $offset = $_SESSION['offset']; }

                    if ($stmt = $conn->prepare("SELECT id, title, status FROM $db_user_table ORDER BY id"))
                    {
                        $stmt->execute();
                        $stmt->store_result();
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
                </table>
                <span class="results"><?php echo "$num_tasks results. Showing 8 results per page."; ?></span>
                <?php
                for($i=1;$i<=$count;$i++)
                {
                    echo "<a class='page-link' href='group_all_tasks.php?page=$i'>$i</a>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>