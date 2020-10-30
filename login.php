<?php
    include('includes/init.php');
    include('includes/database.php');

    $user_key = 'input_user';
    $pass_key = 'input_pass';
    $err_key_1 = 'error_user';
    $err_key_2 = 'error_pass';
    $error = '*required field!';
    /*
        If user submits login form
    */
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($Template->formValidate($user_key, $username, $err_key_1, $pass_key, $password, $err_key_2, $error))
        {
            $username = $Template->getData($user_key);
            $password = $Template->getData($pass_key);

            if($Auth->validateLogin($username, $password))
            {
                $_SESSION['login_successful'] = true;
                $_SESSION['user'] = $Template->getData($user_key);
                $Template->redirect('users.php');
            }
            else
            {
                $Template->setAlert('Invalid username or password!','error');
                $Template->load('views/v_login.php');
            }
        }
        else
        {
            $Template->setAlert('Must complete required fields', 'error');
            $Template->load('views/v_login.php');
        }
    }
    else
    {
        /*
            If user logs out
        */
        if(isset($_GET['logout']))
        {
            if($_SESSION['login_successful'])
            {
                session_unset();
                session_destroy();

                $Template->setAlert('Logout Successful', 'success');
                $Template->load('views/v_login.php');
            }
        }
        /*
            Display login form
        */
        $Template->load('views/v_login.php');
    }