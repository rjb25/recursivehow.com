<?php
        $mysql_hostname = 'localhost';

        $mysql_username = '**user**';

        $mysql_password = '**pass**';

        $mysql_dbname = 'jason_database';


        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
