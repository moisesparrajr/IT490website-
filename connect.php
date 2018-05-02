
<?php

function connectDB()
{
        echo " Attempting connection\n";
<<<<<<< HEAD
        $sqlServer = "localhost";
        $sqlUser = "admin";
        $sqlPass = "12345";
        $sqlName = "p_LeagueDB";
        $sqlPort = "3306";
=======
	$db_info = parse_ini_file("db_credentials.ini");
	
	$sqlServer = $db_info["server"];
        $sqlUser = $db_info["user"];
        $sqlPass = $db_info["pass"];
        $sqlName = $db_info["dbname"];
>>>>>>> bf5d35123f7b946dbe61ff7c23b8b7e7d0115513

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
