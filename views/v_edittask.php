<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Edit Task</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="header">
                <h1>Bug Tracker</h1>
                <a href="login.php?logout=1">Logout</a>
            </div>
        </div>
        <div class="row">
            <div class="nav">
                <ul>
                    <li><a href="users.php?addtask=1">Add Task</a></li>
                    <li><a href="#">TODO</a></li>
                    <li><a href="#">Pending</a></li>
                    <li><a href="#">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="members-body" id="add-task-container">
                <div id="addtask-container">
                    <?php
                        echo $this->displayAlert();

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
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                        <input type="text" name="task-title" cols="100" id="task-title" placeholder="New Task Title" value="<?php echo $result['title']; ?>">
                        <div class="error"><?php echo $this->getData('error_title'); ?></div><br>
                        <input type="text" name="task-author" id="task-author" placeholder="Created by" value="<?php echo $result['author']; ?>" disabled>
                        <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                        <textarea type="text" name="task-description" id="task-description" form="task-form" placeholder="Description..."><?php echo $result['description']; ?></textarea>
                        <div class="error"><?php echo $this->getData('error_description'); ?></div><br>
                        <input type="button" name="cancel" class="cancel" value="Cancel">
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

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>