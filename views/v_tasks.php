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
                    <li><a href="members.php?addtask=true">Add Task</a></li>
                    <li><a href="#">TODO</a></li>
                    <li><a href="#">Pending</a></li>
                    <li><a href="#">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="members-body" id="selected-tasks-container">
                <table class="display-table" id="selected-task">
                    <?php
                        include('includes/database.php');

                        $id = $_SESSION['id'];

                        $sql = "SELECT * FROM tasks WHERE id = $id";
                        $result = $conn->query($sql);
        
                        if($result) {
                            if($result->num_rows > 0) {
                                $row = $result->fetch_object();
                                $table = <<<TABLE
                                <tr><th>$row->title</th></tr>
                                <tr><td id="author">Created By: $row->author</td></tr>
                                <tr><td id="assignee">Assigned To: $row->assignee</td></tr>
                                <tr><td id="status">$row->status</td></tr>
                                <tr><td id="description">$row->description</td></tr>
                                TABLE;
    
                                echo $table;
                            } else {
                                echo "<tr><td>No Data Available</td></tr>";
                            }
                        } else {
                            echo "Error: $mysqli->error";
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/app.js"></script>
</body>
</html>