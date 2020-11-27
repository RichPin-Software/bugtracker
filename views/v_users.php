<?php 
$db_user_table = $_SESSION['user']; 
include('includes/database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>All Tasks</title>
</head>
<body>
    <div class="container">
        <div class="row-header">
            <div class="header">
                <h1>Bug Tracker</h1>
                <div class="header-dropdown dropdown">
                    <img src="images/list.svg" alt="">
                    <div class="dropdown-menu-header">
                        <p><a id="logout" href="login.php?logout=1">Logout</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-nav">
            <div class="nav">
                <ul>
                    <li><a href="users.php?addtask=1">[+] New Task</a></li>
                    <li><a href="users.php?filtertasks=onhold">On-hold</a></li>
                    <li><a href="users.php?filtertasks=todo">TODO</a></li>
                    <li><a href="users.php?filtertasks=inprogress">In Progress</a></li>
                    <li><a href="users.php?filtertasks=resolved">Resolved</a></li>
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
                <span class="results"><?php echo "$num_tasks results. Showing 8 results per page."; ?></span>
                <?php
                for($i=1;$i<=$count;$i++)
                {
                    echo "<a class='page-link' href='users.php?page=$i'>$i</a>";
                }
                ?>
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>