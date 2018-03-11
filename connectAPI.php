
<?php

//returns connection to p_LeagueDB
function connectDB()
{
        echo " Attempting connection to Users\n";
        $sqlServer = "localhost";
        $sqlUser = "admin";
        $sqlPass = "12345";
        $sqlName = "p_LeagueDB";

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

//returns connection to LoL_Data
function connectLol()
{
        echo " Attempting connection to LolDB\n";
        $sqlServer = "localhost";
        $sqlUser = "admin";
        $sqlPass = "12345";
        $sqlName = "LoL_Data";

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
