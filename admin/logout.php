<?php
include "config/dbc.php";

session_start();

session_unset();

session_destroy();

header("Location: {$hostname}/admin/");
?>
