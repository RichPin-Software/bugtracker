<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/28/2020
 * 
 *      Controller for logout.
 * 
 *      - User Logout
 *      - Redirect to Login
 *
 */
include('includes/init.php');
include('includes/database.php');

if(isset($_SESSION['currentUser']))
{
    session_unset();
    session_destroy();

    $Template->redirect('login.php');
}
else
{
    $Template->redirect('login.php');
}