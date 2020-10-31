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
            <div class="members-body" id="selected-tasks-container">
                <a id="back" href="users.php?back=1"><<< Back</a>
                <table class="display-table" id="selected-task">
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
                                ?>
                                <tr><th><?php echo $result['title']; ?></th></tr>
                                <tr><td id="author"><?php echo $result['author']; ?></td></tr>
                                <tr><td id="assignee"><?php echo $result['assignee']; ?></td></tr>
                                <tr><td id="status"><?php echo $result['status']; ?></td></tr>
                                <tr><td id="description"><?php echo $result['description']; ?></td></tr>
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
                            <tr><td id="edit-delete"><a id="edit-task" href="users.php">Edit</a><a id="delete-task" href="users.php?deletetask=true">Delete</a></td></tr>
                </table>
            </div>
        </div>
    </div>

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>