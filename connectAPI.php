
<?php

<<<<<<< HEAD
=======
//returns connection to p_LeagueDB
>>>>>>> bf5d35123f7b946dbe61ff7c23b8b7e7d0115513
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

<<<<<<< HEAD
=======
//returns connection to LoL_Data
>>>>>>> bf5d35123f7b946dbe61ff7c23b8b7e7d0115513
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
