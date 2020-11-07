<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>BUG-<?php echo $_SESSION['id']; ?></title>
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
                    <li><a href="users.php?back=1">All Tasks</a></li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <div class="members-body">
                <a id="back" href="users.php?back=1"><<< Back</a>
                <table id="selected-task">
                    <?php
                        include('includes/database.php');

                        if ($stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?"))
                        {
                            $stmt->bind_param("i", $id);
                            $id = $_SESSION['id'];
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($result['id'], $result['title'], $result['author'], $result['assignee'], $result['status'], $result['description']);

                            

                            if ($stmt->num_rows > 0)
                            {
                                $stmt->fetch();
                                /*
                                    For styling status in task
                                */
                                switch($result['status'])
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
                                ?>
                                <tr><th><?php echo $result['title']; ?></th></tr>
                                <tr><td id="author"><div class="td-content"><span class="task-suffix">Created by:</span> <?php echo $result['author']; ?></div></td></tr>
                                <tr><td id="assignee"><div class="td-content"><span class="task-suffix">Assigned to:</span> <?php echo $result['assignee']; ?></div></td></tr>
                                <tr>
                                    <td id="status">
                                        <div class="td-content dropdown">
                                            <span class="task-suffix">Status: </span> 
                                            <span class="<?php echo "display-$class"; ?>" id="dropdown-status"><?php echo $result['status']; ?></span>
                                            <div class="dropdown-menu">
                                                <p><a href="users.php?status=onhold" id="on-hold">On-hold</a></p>
                                                <p><a href="users.php?status=todo" id="todo">TODO</a></p>
                                                <p><a href="users.php?status=inprogress" id="in-progress">In Progress</a></p>
                                                <p><a href="users.php?status=resolved" id="resolved">Resolved</a></p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr><td id="description"><div><?php echo $result['description']; ?></div></td></tr>
                                <?php
                                $stmt->close();
                                $conn->close();
                            }
                            else
                            {
                                echo "<tr><th>No Data Available</th></tr>";
                            }
                        }
                        else
                        {
                            echo "<tr><th>Failure to connect: ($conn->errno) $conn->error</th></tr>";
                        }
                    ?>
                    <tr>
                        <td id="edit-delete">
                            <a id="edit-task" href="users.php?edittask=true">Edit</a>
                            <a id="delete-task" href="users.php?deletetask=true">Delete</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>