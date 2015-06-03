<?php

$currmonth = "none";
global $currmonth;

$numcomments = $fields['comment_count']->content;
$createdate = trim(strip_tags($fields['created']->content));
$author = strip_tags($fields['name']->content);
$dateparts = explode(" ",$createdate);
$thismonth = $dateparts[0];
if ($thismonth!=$currmonth) {
   $thisyear = $dateparts[2];
   $currmonth = $thismonth;
   if ($thismonth=="January") { $monthnum = "01"; }
   else if ($thismonth=="February") { $monthnum = "02"; }
   else if ($thismonth=="March") { $monthnum = "03"; }
   else if ($thismonth=="April") { $monthnum = "04"; }
   else if ($thismonth=="May") { $monthnum = "05"; }
   else if ($thismonth=="June") { $monthnum = "06"; }
   else if ($thismonth=="July") { $monthnum = "07"; }
   else if ($thismonth=="August") { $monthnum = "08"; }
   else if ($thismonth=="September") { $monthnum = "09"; }
   else if ($thismonth=="October") { $monthnum = "10"; }
   else if ($thismonth=="November") { $monthnum = "11"; }
   else if ($thismonth=="December") { $monthnum = "12"; }
   $monthurl = "http://www.litkicks.com/lkarchive/" . $thisyear . $monthnum;
   print "<h3 class=\"archive-title\"><a href=\"" . $monthurl . "\">" . $thismonth . " " . $thisyear . "</a></h3>";
}

if ($numcomments==0) {
  $commentstr = "";
} else if ($numcomments==1) {
  $commentstr = "(1 comment)";
} else {
  $commentstr = "(" . $numcomments . " comments)";
}
$postlink = $fields['title']->content;
print "<div class=\"archive-line\">&#8226; " . $postlink . " " . $commentstr . "<br /> &nbsp; &nbsp; &nbsp; <i>by</i> " . $author . " <i>on</i> " . $createdate . "</div>";
