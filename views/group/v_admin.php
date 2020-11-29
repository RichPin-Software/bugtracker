<?php
include('includes/database.php');

$groupname;
$admin = $_SESSION['user'];

if($stmt = $conn->prepare("SELECT groupname FROM users_login WHERE username=?"))
{
    $stmt->bind_param("s", $admin);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($result);
    
    if($stmt->num_rows > 0)
    {
        while($stmt->fetch())
        {
            $groupname = $result;
        }
        $stmt->free_result();
        $stmt->close();
        $conn->close();
    }
    else
    {
        $groupname = "not found";
    }
}
else
{
    die("Error: could not prepare MySQLi statement::groupname");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Admin</title>
</head>
<body>
    <div class="container">
        <div class="row-header">
            <div class="header">
                <div class="ghost"></div>
                <h1>Bug Tracker</h1>
                <div class="header-dropdown dropdown">
                    <img src="images/list.svg" alt="">
                    <div class="dropdown-menu-header">
                        <p><a href="controllers/group/group_all_tasks.php" id="admin">Home</a></p>
                        <p><a id="logout" href="logout.php">Logout</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-nav">
            <div class="nav">
                <ul>
                    <li><a href="controllers/group/group_all_tasks.php">All Tasks</a></li>
                    <li><a href="controllers/group/group_all_tasks.php?filtertasks=onhold">On-hold</a></li>
                    <li><a href="controllers/group/group_all_tasks.php?filtertasks=todo">TODO</a></li>
                    <li><a href="controllers/group/group_all_tasks.php?filtertasks=inprogress">In Progress</a></li>
                    <li><a href="controllers/group/group_all_tasks.php?filtertasks=resolved">Resolved</a></li>
                </ul>
            </div>
        </div>
        <div class="row-body">
            <div class="members-body">
                <?php echo $this->displayAlert(); ?>
                <div id="admin-container">
                    <h2>Add New Member</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="task-form" method="POST">
                        <select id="group-name" name="group-name">
                            <option value="<?php echo $groupname; ?>"><?php echo $groupname; ?></option>
                        </select>
                        <br><br>
                        <input type="text" name="add-user" id="add-user" placeholder="Add User (example: abc123)" value="<?php echo $this->getData('input_add-user'); ?>">
                        <div class="error"><?php echo $this->getData('error_add-user'); ?></div><br>
                        <!-- <input type="button" name="cancel" class="cancel cancel-form" value="Cancel"> -->
                        <button class="cancel"><a href="controllers/group/group_all_tasks.php">Cancel</a></button>
                        <input type="submit" class="submit" value="Submit">
                    </form>
                </div><!-- .admin-container -->
            </div><!-- .members-body -->
        </div><!-- .row-body -->
    </div><!-- .container -->

    <script src="../../../bugtracker/models/ui.js"></script>
    <script src="../../../bugtracker/js/group_app.js"></script>
</body>
</html>