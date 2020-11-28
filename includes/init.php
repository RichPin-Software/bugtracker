<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Initialization file
 *
 */
if(file_exists('../../models'))
{
   include('../../models/m_template.php');
   include('../../models/m_auth.php');

   clearstatcache();
}
else
{
   include('models/m_template.php');
   include('models/m_auth.php');

   clearstatcache();
}

$Template = new Templates();
$Template->setAlertType(array('success', 'error', 'warning'));

$Auth = new Auth();

session_start();