<?php
    include('includes/init.php');

    if($_SESSION['userLoggedIn'])
    {
        session_unset();
        session_destroy();

        $Template->redirect('login.php?userLoggedOut=true');
    }
    else
    {
        $Template->redirect('login.php');
    }