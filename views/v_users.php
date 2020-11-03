<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        window.history.forward();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Members Only</title>
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
                    <li><a href="users.php?addtask=1">Add Task</a></li>
                    <li><a href="#">TODO</a></li>
                    <li><a href="#">Pending</a></li>
                    <li><a href="#">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <div class="members-body">
                <?php
                    echo $this->displayAlert();
                ?>
                <table class="display-table" id="tasks">
                    <?php
                        include('includes/database.php');

                        if ($stmt = $conn->prepare("SELECT id, title FROM tasks ORDER BY id"))
                        {
                            $stmt->execute();
                            $stmt->store_result();
                            $stmt->bind_result($id, $title);

                            if ($stmt->num_rows > 0)
                            {
                                while($stmt->fetch()) 
                                {
                                    echo "<tr><td><a href='users.php?id=$id'>BUG-$id: $title</a></td></tr>";
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
                        else
                        {
                            echo "<tr><td>Failure to connect: ($conn->errno) $conn->error</td></tr>";
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