
<?php

function connectDB()
{
        echo " Attempting connection\n";
        $sqlServer = "localhost";
        $sqlUser = "admin";
        $sqlPass = "12345";
        $sqlName = "p_LeagueDB";
        $sqlPort = "3306";

        $db = mysqli_connect($sqlServer, $sqlUser, $sqlPass, $sqlName);

        if(mysqli_connect_errno())
        {
                echo " Connection failed: " . mysqli_connect_error() . "\n";
                exit();
        }
        else
        {
                echo " Connection established\n";
                return $db;
        }
}

?>
