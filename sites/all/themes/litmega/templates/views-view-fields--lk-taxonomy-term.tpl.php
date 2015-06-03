<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
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
      $name = $field->content;
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
   }
}

$comment_string = "";
if ($num_comments=="1") {
  $comment_string = "(1 comment)";
} else if ($num_comments!="0") {
  $comment_string = "(" . $num_comments . " comments)";
}

print "<h2 class=\"list-title\">" . $title . "</h2>";
print "by " . $name . " on " .$date;
print "<br /><br />";
print $tax_topic;
print "<br />";
print $body;
print "<br />";
print "<div id=\"readmorethoughts\"><a href=\"" . $path . "\">... Read more and add your thoughts " . $comment_string . "</a></div>";
print "<br /><br />";
print "<center><hr width=\"300\" size=\"3\" background-color=\"#000000\" noshade></center>";
print "<br />";

?>
