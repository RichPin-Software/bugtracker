<?php
    include('models/m_template.php');

    $Template = new Templates();
    $Template->setAlertType(array('success', 'error', 'warning'));

    session_start();