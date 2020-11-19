<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        window.history.forward();
    </script>
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
                <a href="login.php?logout=1">Logout</a>
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
                <?php
                    echo $this->displayAlert();
                ?>
                <table id="tasks">
                    <?php
                        include('includes/database.php');

                        $offset = 0;
                        $results = 8;

                        if(isset($_SESSION['offset']))
                        {
                            $offset = $_SESSION['offset'];
                        }

                        if ($stmt = $conn->prepare("SELECT id, title, status FROM tasks ORDER BY id"))
                        {
                            $stmt->execute();
                            $stmt->store_result();
                            /*
                                Store number of rows in num_tasks to display total results
                            */
                            $num_tasks = $stmt->num_rows;
                            $count = ceil($num_tasks/8);

                            $stmt->free_result();
                            $stmt->close();

                            if ($stmt = $conn->prepare("SELECT id, title, status FROM tasks ORDER BY id LIMIT ?, ?"))
                            {
                                $stmt->bind_param("ii", $offset, $results);
                                $stmt->execute(); 
                                $stmt->store_result();
                                $stmt->bind_result($id, $title, $status);

                                if ($stmt->num_rows > 0)
                                {
                                    while($stmt->fetch()) 
                                    {
                                        /*
                                            For styling status
                                        */
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

                            if(isset($_SESSION['offset']))
                            {
                                unset($_SESSION['offset']);
                            }
                        }
                        else
                        {
                            echo "<tr><td>Failure to connect: ($conn->errno) $conn->error</td></tr>";
                        }
                    ?>
                </table>
                <span><?php echo "$num_tasks results. Showing 8 results per page."; ?></span>
                <?php
                    for($i=1;$i<=$count;$i++)
                    {
                        echo "<a style='margin-right:5px;text-decoration:underline;' href='users.php?page=$i'>$i</a>";
                    }
                ?>
            </div>
        </div>
    </div>

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>