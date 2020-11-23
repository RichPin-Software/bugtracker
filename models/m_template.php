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
        $special_char = '/\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\]|\[|\}|\{|\"|\'|\:|\;|\?|\/|\>|\<|\,|\./';

        $validate;

        if($input_1=='' || $input_2=='')
        {
            if($input_1=='') { $this->setData($err_key_1, $error); }
            if($input_2=='') { $this->setData($err_key_2, $error); }

            $validate = false;
        }
        else if(preg_match($special_char, $input_1)===1)
        {
            $this->setData($err_key_1, "*letters, numbers and underscore only!");

            $validate = false;
        }
        else
        {
            $validate = true;
        }

        return $validate;
    }

    function groupFormValidate($input_1_key, $input_1, $err_key_1, $input_2_key, $input_2, $err_key_2, $input_3_key, $input_3, $err_key_3, $error)
    {
        $this->setData($input_1_key, $input_1);
        $this->setData($input_2_key, $input_2);
        $this->setData($input_3_key, $input_3);
        $special_char = '/\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\]|\[|\}|\{|\"|\'|\:|\;|\?|\/|\>|\<|\,|\./';

        $validate;

        if($input_1=='' || $input_2=='' || $input_3=='')
        {
            if($input_1=='') { $this->setData($err_key_1, $error); }
            if($input_2=='') { $this->setData($err_key_2, $error); }
            if($input_3=='') { $this->setData($err_key_3, $error); }

            $validate = false;
        }
        else if((preg_match($special_char, $input_1)===1) || (preg_match($special_char, $input_3)===1))
        {
            if(preg_match($special_char, $input_1)===1) { $this->setData($err_key_1, "*letters, numbers and underscore only!"); }
            if(preg_match($special_char, $input_3)===1) { $this->setData($err_key_3, "*letters, numbers and underscore only!"); }

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