<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Add Task</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="header">
                <h1>Bug Tracker</h1>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="row">
            <div class="nav">
                <ul>
                    <li><a id="add-task" href="#">Add Task</a></li>
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
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="addtask-form" method="POST">
                        <input type="text" name="task-title" cols="100" id="task-title" placeholder="New Task Title" value="<?php echo $this->getData('input_title'); ?>">
                        <div class="error"><?php echo $this->getData('error_title'); ?></div><br>
                        <input type="text" name="task-author" id="task-author" placeholder="Created by" value="<?php echo $this->getData('input_user'); ?>">
                        <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                        <textarea type="text" name="task-description" id="task-description" form="addtask-form" placeholder="Description..."><?php echo $this->getData('input_description'); ?></textarea>
                        <div class="error"><?php echo $this->getData('error_description'); ?></div><br>
                        <input type="button" name="cancel" class="cancel" value="Cancel">
                        <input type="submit" class="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>