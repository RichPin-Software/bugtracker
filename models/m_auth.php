<?php

    if(isset($_POST['username'])&&isset($_POST['password']))
    {
        $username = htmlentities($_POST['username'], ENT_QUOTES);
        $password = htmlentities($_POST['password'], ENT_QUOTES);
        if($username!=''&&$password!='')
        {
            $sql = "SELECT * FROM users_login ORDER BY id";
            $users_login = $conn->query($sql);
            if($users_login->num_rows > 0)
            {
                while($row = $users_login->fetch_object())
                {
                    // display users
                    echo "id: $row->id<br>username: $row->username<br>password: $row->password<br>";
                    echo "You entered:<br>Name: $username<br>Password: $password";
                }
            }
            else
            {
                echo "0 Results";
            }
            $conn->close();
        }
        else
        {
            header('Location: ../login.php?required=0');
        }
    }
    else
    {
        header('Location: ../login.php');
    }