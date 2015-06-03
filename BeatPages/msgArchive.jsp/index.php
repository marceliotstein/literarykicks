<?php
$message = $_GET["message"];
$redir = "Location: http://www.litkicks.com/BoardArchiveMessage?message=$message";
header($redir);                                                          
?>
