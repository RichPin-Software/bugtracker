<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Members Only</title>
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
                    <li><a href="members.php?addTask=true">Add Task</a></li>
                    <li><a href="#">TODO</a></li>
                    <li><a href="#">Pending</a></li>
                    <li><a href="#">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="members-body">
                <div id="addtask-form">
                    <form action="" method="POST">
                        <input type="text" name="task-title" cols="100" id="task-title" placeholder="New Task Title">
                        <div class="error"></div><br>
                        <input type="text" name="task-author" id="task-author" placeholder="Created by">
                        <div class="error"></div><br>
                        <textarea name="task-description" id="task-description" cols="100" rows="20"></textarea><br>
                        <input type="button" name="cancel" id="cancel" value="Cancel">
                        <input type="submit" class="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../models/ui.js"></script>
    <script src="app.js"></script>
</body>
</html>