<?php 

  // get node id for node calling page, if present 

  $current_path = current_path();
  $pagenid = 0;
  if (arg(0) == 'node') {
     $pagenid = arg(1);
  }
  
  // try to determine which columns this node is being displayed in

  print "<!-- CLASSES " . $classes . "-->";
  $frontpage = false;
  if (drupal_is_front_page()) {
     $frontpage = true; 
  }

  // show node content if this is front page main column or node page for this node
  // if this is the nav column and the same node is displayed in main, skip it here

  print "<!-- FRONTPAGE IS " . $frontpage . " TEASER IS " . $teaser . " PN = " . $pagenid . " NN = " . $node->nid . "-->";
  $divhide = "";
  //if ($pagenid == $node->nid) {
  //   $divhide = "style=\"display:none\"";
  //} 
  ?>

  <article<?php print $attributes; ?> <?php print $divhide ?>>

     <?php print $user_picture; ?>
     <?php print render($title_prefix); ?>
     <?php if (!$page && $title): ?>
     <header>
        <?php 
        if ($node->type=="tout") { 
           ?>
           <h2<?php print $title_attributes; ?>><?php print $title ?></h2>
           <?php 
        } else {
           ?>
           <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
           <?php 
        }
        ?>  
     </header>
     <?php endif; ?>

     <?php 
     // i really have no idea what this is for -- oct 2012
     // 
     // Oct 2013 -- this now causes an error message!  still don't know what it's for,
     // removing it
     if (false) {
     //if ($teaser) {
        if (!empty($content['field_story_image'])) {
           $storyimage = render(field_view_field('node',$node,'field_story_image'));
           $storyimage = str_replace("Story Image:","",$storyimage);
           print "<div class=\"storyimage\">" . $storyimage . "</div>";
        }

        if (!empty($content['field_dek'])) {
           $dek = render(field_view_field('node',$node,'field_dek'));
           $dek = str_replace("Dek:","",$dek);
           print "<div class=\"dek\">" . $dek . "</div>";
        }
     }
     ?>
  
     <?php print render($title_suffix); ?>

     <?php 
     if ($node->type!="tout") { 
        
        if (strpos($name,">Anonymous<")===FALSE) { // exclude "Anonymous" author
           if (!$teaser) {
              // this is the main article byline display
              ?>
              <footer class="submitted">By <?php print $name; ?> on <?php print $date; ?></footer>
              <?php
           } 
        } 
        ?>
  
        <div<?php print $content_attributes; ?>>
          <?php
            global $series_text;
            $series_text = lktaxonomy_series_links($node->nid);

            hide($content['comments']);
            hide($content['links']);
            hide($content['taxonomy_vocabulary_4']);
            hide($content['taxonomy_vocabulary_5']);
            hide($content['taxonomy_vocabulary_6']);
            hide($content['field_dek']);
            hide($content['field_story_image']);
            print render($content);
          ?>
        </div>
        <?php
     } else { // tout display
        // the only remaining purpose of this is the "More Recent Posts" tout on the front page
        if (!empty($content['field_dek'])) {
           $dekfield = field_view_field('node',$node,'field_dek');
           $dek = render($dekfield);
           $dek = str_replace("Dek:","",$dek);
           print "<div class=\"dek\">" . $dek . "</div>";
        }
     }
     ?>
  
     <div class="clearfix">

       <?php

       //
       // addthis 
       //

       if (($node->type!="tout") &&
           ($node->type!="page")) {
          if (!$teaser || $frontpage) {
             ?>
             <!-- AddThis Button BEGIN -->
             <div class="addthis_toolbox addthis_default_style ">
             <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
             <a class="addthis_button_tweet"></a>
             <a class="addthis_button_pinterest_pinit"></a>
             <a class="addthis_counter addthis_pill_style"></a>
             </div>
             <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
             <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=asheresque"></script>
             <!-- AddThis Button END -->
             <?php
          }
       }

       //
       // comments
       //

       $num_comments = $node->comment_count;

       if ($node->type=="tout") {
          // no comments
       } else if ($node->type=="page") {
          // no comments
       } else if (!$teaser) {
          $comment_string = "No Responses";
          if ($num_comments==1) {
             $comment_string = "1 Response";
          } else if ($num_comments>1) {
             $comment_string = $num_comments . " Responses";
          }
          print "<div id=\"commentintro\">" . $comment_string . " to \"" . $title . "\"</div>";
          print render($content['comments']); 
       } else {
          //if ($node->type!="tout") {
             $comment_string = "";
             if ($num_comments==1) {
                $comment_string = "(1 comment)";
             } else if ($num_comments>1) {
                $comment_string = "(" . $num_comments . " comments)";
             }
             print "<div id=\"readmorethoughts\"><a href=\"" . $node_url . "\">... Read more and add your thoughts " . $comment_string . "</a></div>";
          //}
       }
       ?>

       <center>
       <link rel="stylesheet" type="text/css" href="http://cache.blogads.com/984341751/feed.css" />
       <script language="javascript" src="http://cache.blogads.com/984341751/feed.js"></script>
       </center>

     </div>
   </article>
