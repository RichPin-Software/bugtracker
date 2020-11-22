<?php
    echo md5('admin'.'j4H97e021_d');


    $sql = "CREATE TABLE $username (
        id int(11) NOT NULL AUTO_INCREMENT,
        title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        author varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        assignee varchar(255) COLLATE utf8_unicode_ci NULL,
        status varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        description text COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (id)
        )";