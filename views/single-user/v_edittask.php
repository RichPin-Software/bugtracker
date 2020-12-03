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
                            <img src="../../images/list.svg" alt="">
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
            <h3 class="task-header">Edit Task | BUG-<?php echo $_SESSION['id']; ?></h3>
            <div class="members-body">
                <div id="addtask-container">
                    <?php
                        echo $this->displayAlert();
                        
                        $id = $_SESSION['id'];

                        if ($stmt = $conn->prepare("SELECT * FROM $db_user_table WHERE id = ?"))
                        {
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($result['id'], $result['title'], $result['author'], $result['assignee'], $result['status'], $result['description']);

                            if ($stmt->num_rows > 0)
                            {
                                $stmt->fetch();
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                        <!-- task-title -->
                        <input type="text" name="task-title" cols="100" id="task-title" placeholder="New Task Title" value="<?php echo $result['title']; ?>">
                        <div class="error"><?php echo $this->getData('error_title'); ?></div><br>
                        <!-- task author -->
                        <input type="text" name="task-author" id="task-author" placeholder="Created by" value="<?php echo $result['author']; ?>" disabled>
                        <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                        <!-- task status -->
                        <select id="task-status" name="task-status">
                            <option value="TODO">TODO</option>
                            <option value="On-hold">On-hold</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Resolved">Resolved</option>
                        </select><br><br>
                        <!-- task description -->
                        <textarea type="text" name="task-description" id="task-description" form="task-form" placeholder="Description..."><?php echo $result['description']; ?></textarea>
                        <div class="error"><?php echo $this->getData('error_description'); ?></div><br>
                        <input type="button" name="cancel" class="cancel cancel-form" value="Cancel">
                        <input type="submit" class="submit" value="Submit">
                    </form>
                    <?php
                            }
                            else
                            {
                                echo "<div>Error: task does not exist</div>";
                            }
                        }
                        else
                        {
                            echo "<div>Failure to connect: ($conn->errno) $conn->error</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/app.js"></script>
</body>
</html>