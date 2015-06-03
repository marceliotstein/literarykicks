<?php 
/**
 * @file
 * Alpha's theme implementation to display a single Drupal page.
 */
?>
<div<?php print $attributes; ?>>
  <?php 

    if (!empty($node)) {
      print "<!-- NODE TYPE IS " . $node->type . "-->";
    }

    if (isset($page['header'])) : 
      print render($page['header']); 
    endif; 

    if (isset($page['content'])) : 
      if ((!empty($node)) && ($node->type=="fbitem")) {
        print "<!--GRRRB CONTENT PAGE -->";
        //print_r($page['content']);
      }
      print render($page['content']); 
    endif; 

    if (isset($page['footer'])) : 
      print render($page['footer']); 
    endif; 
  ?>
</div>
