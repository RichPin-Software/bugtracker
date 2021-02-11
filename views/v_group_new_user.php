<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Create Account</title>
</head>
<body class="login">
    <div class="container" id="login-container">
        <div id="login-form">
            <h1>Create Account</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <label id="groupname-label" for="groupname">Group Name:</label><br>
                <input type="text" placeholder="BlueTeam" name="groupname" id="groupname" value="<?php echo $this->getData('new_group'); ?>">
                <div id="groupname-error" class="error"><?php echo $this->getData('error_group'); ?></div><br>
                <label for="email">Email:</label><br>
                <input type="email" placeholder="your_email@example.com" name="email" id="email" value="<?php echo $this->getData('new_email'); ?>">
                <div class="error"><?php echo $this->getData('error_email'); ?></div><br>
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" value="<?php echo $this->getData('new_user'); ?>">
                <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="<?php echo $this->getData('newuser_pass'); ?>">
                <div class="error"><?php echo $this->getData('error_pass'); ?></div><br>
                <input type="button" name="cancel" class="cancel cancel-newuser" value="Cancel">
                <input type="submit" class="submit" value="Submit">
            </form>
        </div>
    </div>

    <script src="../../bugtracker/models/ui.js"></script>
    <script src="../bugtracker/js/app.js"></script>
</body>
</html>