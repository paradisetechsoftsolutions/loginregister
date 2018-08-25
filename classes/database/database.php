<?php
// Connection parameters
$DatabaseServer = "localhost";
$DatabaseUser   = "root";
$DatabasePass   = "root";
$DatabaseName   = "corephp";

// Connecting to the database
$database = new mysqli($DatabaseServer, $DatabaseUser, $DatabasePass, $DatabaseName);

?>