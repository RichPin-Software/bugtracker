<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Template file contains form validation, functions to 
 *      redirect controller pages and load views.  Contains
 *      set and get Data functions to clean user input data
 *      as well as functions for alerts.
 *
 */
class Templates
{
    private $data;
    private $alertTypes;
    /*
        Constructor
    */
    function __construct() {}

    /*
        Functions
    */
    function load($url)
    {
        include($url);
    }

    function redirect($url)
    {
        header("Location: $url");
    }

    /*
        Set/Get Data
    */
    function setData($name, $value)
    {
        $this->data[$name] = htmlentities($value, ENT_QUOTES);
    }

    function getData($name)
    {
        $output = '';
        if(isset($this->data[$name]))
        {
            $output = $this->data[$name];
        }

        return $output;
    }

    /*
        Set/Get Alerts
    */
    function setAlertType($type)
    {
        $this->alertTypes = $type;
    }

    function setAlert($alert, $type = null)
    {
        if($type == '')
        {
            $type = $this->alertTypes[0];
        }
        $_SESSION[$type][] = $alert;
    }

    function getAlerts()
    {
        $data = '';
        foreach($this->alertTypes as $alert)
        {
            if(isset($_SESSION[$alert]))
            {
                foreach($_SESSION[$alert] as $value)
                {
                    $data .= "<li class='$alert'>$value</li>";
                }
                unset($_SESSION[$alert]);
            }
        }
        return $data;
    }

    /*
        Forms and Alerts
    */
    function formValidate($input_1_key, $input_1, $err_key_1, $input_2_key, $input_2, $err_key_2, $error)
    {
        $this->setData($input_1_key, $input_1);
        $this->setData($input_2_key, $input_2);

        $validate;

        if($input_1=='' || $input_2=='')
        {
            if($input_1=='') { $this->setData($err_key_1, $error); }
            if($input_2=='') { $this->setData($err_key_2, $error); }

            $validate = false;
        }
        else
        {
            $validate = true;
        }

        return $validate;
    }

    function singleUserFormValidate($user_key, $username, $err_key_user, $email_key, $email, $err_key_email, $pass_key, $password, $err_key_pass, $error)
    {
        $this->setData($user_key, $username);
        $this->setData($email_key, $email);
        $this->setData($pass_key, $password);

        $validate;

        if($username=='' || $email==''|| $password=='')
        {
            if($username=='') { $this->setData($err_key_user, $error); }
            if($email=='') { $this->setData($err_key_email, $error); }
            if($password=='') { $this->setData($err_key_pass, $error); }

            $validate = false;
        }
        else
        {
            $validate = true;
        }

        return $validate;
    }

    function groupFormValidate($user_key, $username, $err_key_user, $pass_key, $password, $err_key_pass, $group_key, $groupname, $err_key_group, $email_key, $email, $err_key_email, $error)
    {
        $this->setData($user_key, $username);
        $this->setData($pass_key, $password);
        $this->setData($group_key, $groupname);
        $this->setData($email_key, $email);

        $validate;

        if($username=='' || $password=='' || $groupname=='' || $email=='')
        {
            if($username=='') { $this->setData($err_key_user, $error); }
            if($password=='') { $this->setData($err_key_pass, $error); }
            if($groupname=='') { $this->setData($err_key_group, $error); }
            if($email=='') { $this->setData($err_key_email, $error); }

            $validate = false;
        }
        else
        {
            $validate = true;
        }

        return $validate;
    }

    function adminFormValidate($user_key, $user, $email_key, $email, $error_key, $error_key2, $error)
    {
        $this->setData($user_key, $user);
        $this->setData($email_key, $email);

        $validate;

        if($user=='' || $email=='')
        {
            if($user=='') { $this->setData($error_key, $error); }
            if($email=='') { $this->setData($error_key2, $error); }

            $validate = false;
        }
        else
        {
            $validate = true;
        }

        return $validate;
    }

    function displayAlert()
    {
        $alert = $this->getAlerts();
        if($alert != '')
        {
            $displayAlert = <<<ALERT
            <ul class="alerts">$alert</ul>
            <script>
            setTimeout(()=>{
            document.querySelector('.alerts').style.display='none';
            },3000);
            </script>
            ALERT;
        }
        else
        {
            $displayAlert = '';
        }
        
        return $displayAlert;
    }
}