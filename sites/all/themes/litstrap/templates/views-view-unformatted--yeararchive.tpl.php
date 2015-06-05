<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */

$thisarg = explode("?",$_GET['q']);
$thisyear = str_replace("year/","",$thisarg[0]);
if (is_numeric($thisyear)):
  print '<h1 class="pageheader lkheadline">Litkicks Archive: ' . $thisyear . '</h1>';
  foreach ($rows as $id => $row):
    print $row;
  endforeach;
endif;
