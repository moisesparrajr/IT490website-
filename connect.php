
<?php

function connectDB()
{
        echo " Attempting connection\n";
	$db_info = parse_ini_file("db_credentials.ini");
	
	$sqlServer = $db_info["server"];
        $sqlUser = $db_info["user"];
        $sqlPass = $db_info["pass"];
        $sqlName = $db_info["dbname"];

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
