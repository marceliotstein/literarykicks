<?php
// primary article (story) node template for litkicks
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php
  $author = $node->name;
  $createdate = format_date($node->created, 'custom', "F jS, Y");
  $img = '<img src="http://litkicks.com/sites/default/files/' . $node->field_story_image['und'][0]['filename'] . '" />';
  ?>

  <div class="col-xs-12 col-sm-12 hidden-md hidden-lg hidden-xl lklisting-entry">
    <div class="lklisting-title"><?php print $title ?></div>
    <div class="lklisting-pic"><?php print $img ?></div>
    <div class="lklisting-date"><?php print $createdate ?></div>
    <div class="lklisting-author">by <?php print $author ?></div>
  </div>
  <div class="hidden-xs hidden-sm col-md-12 col-lg-12 col-xl-12 lklisting-entry">
    <table>
      <tr colspan="2">
        <div class="lklisting-title"><?php print $title ?></div>
      </tr>
      <tr>
        <td class="lklisting-pic">
          <?php print $img ?>
        </td>
        <td class="lklisting-desc">
          <div class="lklisting-date"><?php print $createdate ?></div>
          <div class="lklisting-author">by <?php print $name ?></div>
          <!-- AddThis BEGIN -->
          <div class="addthis_sharing_toolbox"></div>
          <!-- AddThis END -->
        </td>
      </tr>
      <tr colspan="2">
        <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);

        $rc = render($content);
        // HACK FOR LOCALHOST
        if (is_localhost()) {
          $rc = str_replace("/sites/default/files","/literarykicks/sites/default/files",$rc);
          $rc = str_replace("\"sites/default/files","\"/literarykicks/sites/default/files",$rc);
        }
        // END OF LOCALHOST HACK
        print $rc;
        ?>
      </tr>
    </table>
  </div>
</div>
