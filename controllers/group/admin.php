<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/26/2020
 * 
 *      Controller for admin functions.
 *
 */
include('../../includes/init.php');
include('../../includes/database.php');

$user_key = 'input_add-user';
$email_key = 'input_add-email';
$error_user = 'error_add-user';
$error_email = 'error_add-email';
$error = '*required field';

$db_user_table = $_SESSION['group_table'];
$admin = $_SESSION['user'];
$group;

if(isset($_SESSION['currentUser']))
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $group = $_POST['group-name'];
        $new_group_member = $_POST['add-user'];
        $new_group_member_email = $_POST['add-email'];
        $new_group_username = $new_group_member . "@" . $_POST['group-name'];
        $special_char = '/\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\]|\[|\}|\{|\"|\'|\:|\;|\?|\/|\>|\<|\,|\./';

        if($Template->adminFormValidate($user_key, $new_group_member, $email_key, $new_group_member_email, $error_user, $error_email, $error))
        {
            if((strlen($new_group_member) > 0 && strlen($new_group_member) < 8) || (preg_match($special_char, $new_group_member)===1))
            {
                if(strlen($new_group_member) < 8)
                {
                    $Template->setData($error_user, '*must be at least 8 characters');
                }
                if((preg_match($special_char, $new_group_member)===1))
                {
                    $Template->setData($error_user, "*letters, numbers and underscore only!");
                }

                $Template->load('../../views/group/v_admin.php');
            }
            else if(!$Auth->validateNewUsername($new_group_username))
            {
                $Template->setData($error_user, '*username already exists!');
                $Template->load('../../views/group/v_admin.php');
            }
            else if(!$Auth->validateAdmin($admin))
            {
                $Template->setData($error_user, '*only administrator can add users!');
                $Template->load('../../views/group/v_admin.php');
            }
            else
            {
                $user = $Template->getData($user_key);
                $email = $Template->getData($email_key);
                $Auth->addGroupMember($admin, $user, $email);
                $Template->setAlert("$user@$group added successfully!", 'success');
                $Template->redirect('admin.php');
            }
        }
        else
        {
            $Template->load('../../views/group/v_admin.php');
        }
    }
    else
    {
        $Template->load('../../views/group/v_admin.php');
    }
}
else
{
    $Template->redirect('../../login.php');
}