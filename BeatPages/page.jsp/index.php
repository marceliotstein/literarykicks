<?php
$what= $_GET["what"];
if ($what==null) {
   $what = $_GET["tag"];
}
$redir = "Location: http://www.litkicks.com/$what";
header($redir);                                                          
?>
