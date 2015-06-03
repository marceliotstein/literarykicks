<?php
 /* primary front page article view template for litkicks */
?>
<?php
$title = "";
$path = "";
$body = "";
$author = "";
$date = "";
$num_comments = "";
$tax_topic = "";
$tax_series = "";
$tax_feature = "";
$tax_selection = "";
$tax_format = "";
$type = "";
$dek = "";
$story_image = "";
foreach ($fields as $id => $field) {
   //print "FIELD ID:".$id;
   if ($id=="title") {
      $title = $field->content;
   } else if ($id=="comment_count") {
      $num_comments = $field->content;
   } else if ($id=="path") {
      $fullpath = $field->content;
      $path2 = str_replace("<span>","",$fullpath);
      $path = str_replace("</span>","",$path2);
   } else if ($id=="created") {
      $date = $field->content;
   } else if ($id=="name") {
      $author = $field->content;
   } else if ($id=="taxonomy_vocabulary_1") {
      $tax_topic = $field->content;
   } else if ($id=="taxonomy_vocabulary_3") {
      $tax_series = $field->content;
   } else if ($id=="taxonomy_vocabulary_4") {
      $tax_selection = $field->content;
   } else if ($id=="taxonomy_vocabulary_5") {
      $tax_format = $field->content;
   } else if ($id=="taxonomy_vocabulary_6") {
      $tax_feature = $field->content;
   } else if ($id=="field_dek") {
      $dek = $field->content;
   } else if ($id=="field_story_image") {
      $story_image = $field->content;
   } else if ($id=="type") {
      $type = $field->content;
   } else if ($id=="body") {
      $fullbody = $field->content;
      $bodysplit = explode("<!--break-->",$fullbody);
      $body = $bodysplit[0];
      $body .= "</div>"; // close the div that opens the body
      // HACK FOR LOCALHOST
      if (is_localhost()) {
        $body = str_replace("/sites/default/files","/litkicks-new/sites/default/files",$body);
        $body = str_replace("\"sites/default/files","\"/litkicks-new/sites/default/files",$body);
      }
      // END OF LOCALHOST HACK
   }
}

$comment_string = "";
if (!empty($num_comments)) {
   if ($num_comments=="1") {
     $comment_string = "(1 comment)";
   } else if ($num_comments!="0") {
     $comment_string = "(" . $num_comments . " comments)";
   }
}

global $base_url;
$themeimg_url = $base_url . "/sites/all/themes/litstrap/images";
$frontbar_url = $themeimg_url . "/lkfrontbar.png";

print "<article>";
print "<h1 class=\"node-title lkheadline\">" . $title . "</h1>";
print "<div class=\"article-by-line\">" . $author . " &#8226; " . $date . "</div>";
print "<div class=\"article-tax-line\">" . $tax_topic . "</div>";
print $body;
print "<div class=\"front-readmore\"><a href=\"" . $path . "\">... Read more and add your thoughts " . $comment_string . "</a></div>";
print "<div class=\"front-separator\"><img src=\"" . $frontbar_url . "\" /></div>";
print "</article>";

?>
