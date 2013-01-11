<?php
session_start();
set_time_limit(0);
session_unset();
session_destroy();
header("location:index.php");
?>
