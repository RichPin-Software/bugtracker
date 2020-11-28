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
    <title><?php echo $_SESSION['filtertasks']; ?></title>
</head>
<body>
    <div class="container">
        <div class="row-header">
            <div class="header">
                <h1>Bug Tracker</h1>
                <div class="header-dropdown dropdown">
                    <img src="../../images/list.svg" alt="">
                    <div class="dropdown-menu-header">
                        <p><a id="logout" href="../../logout.php">Logout</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-nav">
            <div class="nav">
                <ul>
                    <li><a href="all_tasks.php?addtask=1">[+] New Task</a></li>
                    <li><a href="all_tasks.php">All Tasks</a></li>
                    <li><a href="all_tasks.php?filtertasks=onhold">On-hold</a></li>
                    <li><a href="all_tasks.php?filtertasks=todo">TODO</a></li>
                    <li><a href="all_tasks.php?filtertasks=inprogress">In Progress</a></li>
                    <li><a href="all_tasks.php?filtertasks=resolved">Resolved</a></li>
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

                                    echo "<tr><td><a href='selected_task.php?id=$id'>BUG-$id: $title</a><span class='display-$class'>$status</span></td></tr>";
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
                    // change value for query string
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
                        echo "<a class='page-link' href='all_tasks.php?page=$i&filtertasks=$status'>$i</a>";
                    }
                ?>
            </div>
        </div>
    </div>

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>