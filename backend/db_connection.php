<!-- this will serve as PHP script for connecting the MySQL Database. -->

<!-- 
For connecting MySQL database we need below parameters.

    host name
    username
    password
    database name 
-->
<!-- The define() function defines a constant.

Constants are much like variables, except for the following differences:

    A constant's value cannot be changed after it is set
    Constant names do not need a leading dollar sign ($)
    Constants can be accessed regardless of scope
    Constant values can only be strings and numbers -->

<?php

$servername = "localhost";
$username = "root";
define("password","");
define("dbname", "users");
$dbname2 = "xss_demo";

$conn = new mysqli($servername, $username, password, dbname);
$connXss = new mysqli($servername, $username, password, $dbname2);

if(!$conn || !$connXss){
    die( "Connection_Failed" . mysqli_connect_error());
    }

?>