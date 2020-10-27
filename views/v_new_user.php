<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>New User</title>
</head>
<body>
    <div class="container" id="login-container">
        <div id="login-form">
            <h1>New User</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <?php 
                    echo $this->displayAlert();
                ?>
                <label for="username">Create Username:</label><br>
                <input type="text" name="username" id="username" value="<?php echo $this->getData('new_user'); ?>">
                <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                <label for="password">Create Password:</label>
                <input type="password" name="password" id="password" value="<?php echo $this->getData('newuser_pass'); ?>">
                <div class="error"><?php echo $this->getData('error_pass'); ?></div><br>
                <input type="submit" class="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>