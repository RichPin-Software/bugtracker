<!DOCTYPE html>
<html lang="en">
<head>
    <script>window.history.forward();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Login</title>
</head>
<body class="login">
    <div class="container" id="login-container">
        <div id="login-form">
            <h1>Member Login</h1>
            <div class="alert-banner-login"><?php echo $this->displayAlert(); ?></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" value="<?php echo $this->getData('input_user'); ?>">
                <div class="error"><?php echo $this->getData('error_user'); ?></div><br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="<?php echo $this->getData('input_pass'); ?>">
                <div class="error"><?php echo $this->getData('error_pass'); ?></div><br>
                <a id="signup" href="new_user.php?signup=true">Don't have an account? Sign up.</a><br>
                <div class="dropdown">
                    <a id="login-group-message" href="#">Logging into a group?</a>
                    <div class="dropdown-menu-login">
                        <p>Group username:<br> <span>myUsername@groupname</span></p>
                    </div>
                </div><br>
                <input type="submit" class="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>