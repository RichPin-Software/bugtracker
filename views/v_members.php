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
                <?php
                    $loginSuccessful = $this->getAlerts();
                    if($loginSuccessful != '')
                    {
                        echo "<ul class='alerts'>$loginSuccessful</ul>";
                        echo "<script>setTimeout(()=>{
                            document.querySelector('.alerts').style.display='none';
                        },2500);</script>";
                    }
                    else
                    {
                        echo $loginSuccessful;
                    }
                ?>
                <table id="tasks">
                    <?php
                        include('includes/database.php');

                        $sql = "SELECT * FROM tasks ORDER BY id";
                        $result = $conn->query($sql);
        
                        if($result) {
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_object()) {
                                    $table = <<<TABLE
                                    <tr>
                                    <td><a href="#">BUG-$row->id: $row->title</a></td>
                                    </tr>
                                    TABLE;
        
                                    echo $table;
                                }
                            } else {
                                echo "<tr><td colspan='5'>No Data Available</td></tr>";
                            }
                        } else {
                            echo "Error: ".$mysqli->error;
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script src="../models/ui.js"></script>
    <script src="app.js"></script>
</body>
</html>