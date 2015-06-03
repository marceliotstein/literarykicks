<?php
  // primary article (story) node template for litkicks
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h1<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h1>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php
  $author = $node->name;
  $createdate = format_date($node->created, 'custom', "F jS, Y");
  $byline = $author . " &#8226; " . $createdate;

  print "<div class=\"article-by-line\">" . $byline . "</div>";
  ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);

      $rc = render($content);
      // HACK FOR LOCALHOST
      if (is_localhost()) {
        $rc = str_replace("/sites/default/files","/litkicks/sites/default/files",$rc);
        $rc = str_replace("\"sites/default/files","\"/litkicks/sites/default/files",$rc);
      }
      // END OF LOCALHOST HACK
      print $rc;
    ?>
  </div>
  <br /><br />

  <!-- AddThis BEGIN -->
  <div class="addthis_sharing_toolbox"></div>
  <!-- AddThis END -->
  <br />
</div>
