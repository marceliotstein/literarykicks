<?php

/**
 * @file
 * template.php
 */

function is_localhost() {
   $whitelist = array( '127.0.0.1', '::1' );
   if (in_array( $_SERVER['REMOTE_ADDR'], $whitelist)) {
     return true;
   }
}

function litstrap_preprocess_page(&$variables) {
  $thisuri = str_replace("literarykicks/","",request_uri());
  $uriexp = explode("/",$thisuri);

  // manipulate titles for archive and taxonomy pages
  $titleprefix = "";
  $titlesuffix = "";
  if ($uriexp[1]=="year") {
    if (is_numeric($uriexp[2])) {
      $titlesuffix = $uriexp[2];
    }
  } else if ($uriexp[1]=="series") {
    $titleprefix = "Series: ";
  } else if ($uriexp[1]=="topic") {
    $titleprefix = "Topic: ";
  }
  $variables['titleprefix'] = $titleprefix;
  $variables['titlesuffix'] = $titlesuffix;
}

function litstrap_preprocess_node(&$variables, $hook) {
  hide($variables['content']['field_story_image']);
  hide($variables['content']['field_dek']);
  hide($variables['content']['taxonomy_vocabulary_1']);
  hide($variables['content']['taxonomy_vocabulary_3']);
  hide($variables['content']['taxonomy_vocabulary_4']);
  hide($variables['content']['taxonomy_vocabulary_5']);
  hide($variables['content']['taxonomy_vocabulary_6']);

  // process byline

  $variables['submitted'] = str_replace("Submitted ","",$variables['submitted']);

  // process topics

  $topiclist = "";
  if (!empty($variables['content']['taxonomy_vocabulary_1']['#items'])) {
    $numterms = 0;
    foreach ($variables['content']['taxonomy_vocabulary_1']['#items'] as $taxitem) {
      $thisterm = $taxitem['taxonomy_term']->name;
      $thistermtoken = str_replace(" ","-",strtolower($thisterm));
      $topiclist .= '<span class="topicbox"><nobr><a href="/topic/' . $thistermtoken . '">' . $thisterm . '</a></nobr></span> ';
    }
  }
  $variables['topiclist'] = $topiclist;

  // process comments

  $numcomments = 0;
  if (!empty($variables['content']['comments'])) {
    $numcomments = count($variables['content']['comments']['comments']);
  }
  $commentintro = "";
  $commentstr = "";
  if ($numcomments==0) {
    $commentstr .= "No Responses";
  } else if ($numcomments==1) {
    $commentstr .= "1 Response";
  } else {
    $commentstr .= $numcomments . " Responses";
  }
  $commentintro .= "<div id=\"commentintro\">" . $commentstr . " to \"" . $variables['title'] . "\"</div>";
  $variables['commentintro'] = $commentintro;
  hide($variables['content']['comments']['title']);
}
