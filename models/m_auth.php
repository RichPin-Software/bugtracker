<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Auth file contains login validation, password protection
 *      and functions to add, remove, and update the database.
 *
 */
class Auth
{
    private $salt = 'j4H97e021_d';
    private $user_information;
    /*
        Constructor
    */
    function __construct() {}
    /*
        setUserInformation()
    */
    function setUserInformation($username, $password)
    {
        global $conn;

        if($this->validateUsernameLogin($username, $password))
        {
            if($stmt = $conn->prepare("SELECT username, groupname, admin, email FROM users_login WHERE username = ?"))
            {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($result['username'], $result['groupname'], $result['admin'], $result['email']);
                
                if($stmt->num_rows > 0)
                {
                    while($stmt->fetch())
                    {
                        $this->user_information['username'] = $result['username'];
                        $this->user_information['groupname'] = $result['groupname'];
                        $this->user_information['admin'] = $result['admin'];
                        $this->user_information['email'] = $result['email'];
                    }
                }
            }
            else
            {
                die("Error: Could not prepare MySQLi statement");
            }
        }
        else
        {
            if($stmt = $conn->prepare("SELECT username, groupname, admin, email FROM users_login WHERE email = ?"))
            {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($result['username'], $result['groupname'], $result['admin'], $result['email']);
                
                if($stmt->num_rows > 0)
                {
                    while($stmt->fetch())
                    {
                        $this->user_information['username'] = $result['username'];
                        $this->user_information['groupname'] = $result['groupname'];
                        $this->user_information['admin'] = $result['admin'];
                        $this->user_information['email'] = $result['email'];
                    }
                }
            }
            else
            {
                die("Error: Could not prepare MySQLi statement");
            }
        }

        $stmt->free_result();
        $stmt->close();
    }
    /*
        getUserInformation()
    */
    function getUserInformation($key)
    {
        $output = '';
        if(isset($this->user_information[$key]))
        {
            $output = $this->user_information[$key];
        }

        return $output;
    }
    /*
        Validate Username
    */
    function validateUsernameLogin($username, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);

        if($stmt = $conn->prepare("SELECT * FROM users_login WHERE username = ? AND password = ?"))
        {
            $stmt->bind_param("ss", $username, $secure_password);
            $stmt->execute();
            $stmt->store_result();

            $result = ($stmt->num_rows > 0) ? true : false;
            $stmt->close();
            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }
    /*
        Validate Email
    */
    function validateEmailLogin($email, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);

        if($stmt = $conn->prepare("SELECT * FROM users_login WHERE email = ? AND password = ?"))
        {
            $stmt->bind_param("ss", $email, $secure_password);
            $stmt->execute();
            $stmt->store_result();

            $result = ($stmt->num_rows > 0) ? true : false;
            $stmt->close();
            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }
    /*
        Validate Login by Username or Email
    */
    function validateLogin($username, $password)
    {
        $login;

        if($this->validateUsernameLogin($username, $password)) { $login = true; }
        else if($this->validateEmailLogin($username, $password)) { $login = true; }
        else { $login = false; }

        return $login;
    }
    /*
        Assign Correct Database to User
    */
    function assignDatabase($username, $password)
    {
        global $conn;
        $database;

        if($this->validateUsernameLogin($username, $password))
        {
            if($stmt = $conn->prepare("SELECT username, groupname FROM users_login WHERE username = ?"))
            {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($result['username'], $result['groupname']);
                
                if($stmt->num_rows > 0)
                {
                    while($stmt->fetch())
                    {
                        $database = ($result['groupname']===NULL || $result['groupname']==="") ? $result['username'] : "group_".$result['groupname'];
                    }
                }
            }
            else
            {
                die("Error: Could not prepare MySQLi statement");
            }
        }
        else
        {
            if($stmt = $conn->prepare("SELECT username, groupname FROM users_login WHERE email = ?"))
            {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($result['username'], $result['groupname']);
                
                if($stmt->num_rows > 0)
                {
                    while($stmt->fetch())
                    {
                        $database = ($result['groupname']===NULL || $result['groupname']==="") ? $result['username'] : "group_".$result['groupname'];
                    }
                }
            }
            else
            {
                die("Error: Could not prepare MySQLi statement");
            }
        }

        $stmt->free_result();
        $stmt->close();
        return $database;
    }
    /*
        Username Validation to Prevent Duplicate Usernames
    */
    function validateNewUsername($username)
    {
        global $conn;

        if($stmt = $conn->prepare("SELECT username FROM users_login WHERE username = ?"))
        {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            $result = ($stmt->num_rows > 0) ? false : true;
            $stmt->close();
            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }

    function validateNewGroupUsername($username, $groupname)
    {
        global $conn;
        $group_username = "$username@$groupname";

        if($stmt = $conn->prepare("SELECT username FROM users_login WHERE username = ?"))
        {
            $stmt->bind_param("s", $group_username);
            $stmt->execute();
            $stmt->store_result();

            $result = ($stmt->num_rows > 0) ? false : true;
            $stmt->close();
            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }
    /*
        Email Validation to Prevent Accounts with Duplicate Emails
    */
    function validateNewEmail($email)
    {
        global $conn;

        if($stmt = $conn->prepare("SELECT email FROM users_login WHERE email = ?"))
        {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            $result = ($stmt->num_rows > 0) ? false : true;
            $stmt->close();
            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }
    /*
        Groupname Validation to Prevent Duplicate Groupnames
    */
    function validateNewGroupname($groupname)
    {
        global $conn;

        if($stmt = $conn->prepare("SELECT groupname FROM users_login WHERE groupname = ?"))
        {
            $stmt->bind_param("s", $groupname);
            $stmt->execute();
            $stmt->store_result();

            $result = ($stmt->num_rows > 0) ? false : true;
            $stmt->close();
            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }

    function validateAdmin($user)
    {
        global $conn;
        $validate;

        if($stmt = $conn->prepare("SELECT admin FROM users_login WHERE username=?"))
        {
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($result);
            
            if($stmt->num_rows > 0)
            {
                while($stmt->fetch())
                {
                    $validate = ($result==="yes") ? true : false;
                }
                $stmt->free_result();
                $stmt->close();
            }
            else
            {
                $validate = false;
            }
        }
        else
        {
            die("Error: could not prepare MySQLi statement::groupname");
        }

        return $validate;
    }
    /*
        Prepared Statements - Add New User
    */
    function addNewUser($username, $email, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);
        /*
            add new username and password to table 'users_login'
        */
        if($stmt = $conn->prepare("INSERT INTO users_login (username, password, email) VALUES (?, ?, ?)"))
        {
            $stmt->bind_param("sss", $username, $secure_password, $email);
            $stmt->execute();
            $stmt->close();
            /*
                create new table for new user account
            */
            $sql = "CREATE TABLE $username (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                author varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                assignee varchar(255) COLLATE utf8_unicode_ci NULL,
                status varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                description text COLLATE utf8_unicode_ci NOT NULL
                )";

            echo ($conn->query($sql)===TRUE) ? : "Error: $conn->error";

            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement::username and password");
        }
    }

    function addNewUserGroup($username, $groupname, $email, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);
        $admin = 'yes';
        $user_group = "$username@$groupname";
        /*
            add new username, groupname, email and password to table 'users_login'
        */
        if($stmt = $conn->prepare("INSERT INTO users_login (username, groupname, password, admin, email) VALUES (?, ?, ?, ?, ?)"))
        {
            $stmt->bind_param("sssss", $user_group, $groupname, $secure_password, $admin, $email);
            $stmt->execute();
            $stmt->close();
            /*
                create new table for group
            */
            $sql = "CREATE TABLE group_$groupname (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                author varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                assignee varchar(255) COLLATE utf8_unicode_ci NULL,
                status varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                description text COLLATE utf8_unicode_ci NOT NULL
                )";

            echo ($conn->query($sql)===TRUE) ? : "Error: $conn->error";

            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }

    function addGroupMember($admin, $username, $email)
    {
        global $conn;
        $groupname;

        if($stmt = $conn->prepare("SELECT groupname FROM users_login WHERE username=?"))
        {
            $stmt->bind_param("s", $admin);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($result);
            
            if($stmt->num_rows > 0)
            {
                while($stmt->fetch())
                {
                    $groupname = $result;
                }
                $stmt->free_result();
                $stmt->close();
            }
            else
            {
                $groupname = "not found";
            }
        }
        else
        {
            die("Error: could not prepare MySQLi statement::groupname");
        }

        $group_user_login = $username."@".$groupname;
        $default_password = md5($groupname.$this->salt);
        $admin_status = "no";

        if($stmt = $conn->prepare("INSERT INTO users_login (username, groupname, password, admin, email) VALUES (?, ?, ?, ?, ?)"))
        {
            $stmt->bind_param("sssss", $group_user_login, $groupname, $default_password, $admin_status, $email);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement::username and password");
        }
    }

    function changePassword($username, $new_password)
    {
        global $conn;

        $secure_password = md5($new_password.$this->salt);

        if($stmt = $conn->prepare("UPDATE users_login SET password=? WHERE username=?"))
        {
            $stmt->bind_param("ss", $secure_password, $username);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement::username and password");
        }
    }
    /*
        Prepared Statements - Add Task
    */
    function addTask($db_table, $title, $status, $author, $description)
    {
        global $conn;
        $assignee = "unassigned";

        if($stmt = $conn->prepare("INSERT INTO $db_table (title, author, assignee, status, description) VALUES (?,?,?,?,?)"))
        {
            $stmt->bind_param("sssss", $title, $author, $assignee, $status, $description);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }
    /*
        Prepared Statements - Edit/Update Selected Task
    */
    function updateTask($db_table, $id, $title, $status, $description)
    {
        global $conn;

        if($stmt = $conn->prepare("UPDATE $db_table SET title=?, status=?, description=? WHERE id=?"))
        {
            $stmt->bind_param("sssi", $title, $status, $description, $id);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }
    /*
        Prepared Statements - Delete Selected Task
    */
    function deleteTask($db_table, $id)
    {
        global $conn;

        if($stmt = $conn->prepare("DELETE FROM $db_table WHERE id=?"))
        {
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }
}